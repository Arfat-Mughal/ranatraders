<?php

namespace App\Http\Controllers;

use App\Events\TransactionCreated;
use App\Events\TransactionDeleted;
use App\Exports\TransactionsExport;
use App\Imports\TransactionsImport;
use App\Models\Transaction;
use App\Models\Company;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Validators\ValidationException;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::all();

        $transactions = Transaction::query();

        if ($request->has('company_id')) {
            $transactions->where('company_id', $request->company_id);
        } else {
            // If company_id is not provided, return empty array
            $transactions->where('company_id', null);
        }

        if ($request->has('start_date') && $request->start_date) {
            $transactions->where('date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $transactions->where('date', '<=', $request->end_date);
        }

        $transactions = $transactions->orderBy('date', 'desc')->paginate(20);

        return view('transactions.index', compact('transactions', 'companies'));
    }

    public function export(Request $request)
    {
        $company_id = $request->input('company_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Retrieve company details
        $company = Company::find($company_id);

        // Format current date
        $currentDate = now()->format('Y-m-d');

        // Construct filename
        $filename = $company->name . '_' . $currentDate . '.xlsx';

        return Excel::download(new TransactionsExport($company_id, $start_date, $end_date), $filename);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048', // Ensure file is Excel format and within size limits
        ]);

        try {
            $file = $request->file('file');

            // Handle file upload and import
            Excel::import(new TransactionsImport($request->company_id), $file);

            return redirect()->back()->with('success', 'Transactions imported successfully!');
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];

            foreach ($failures as $failure) {
                $errorMessages[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }

            return redirect()->back()->withErrors(['import_errors' => $errorMessages]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error importing file: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $companies = Company::all();
        $customers = Customer::all();
        return view('transactions.create', compact('companies','customers'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'date' => 'nullable|date',
            'payment_method' => 'required|string',
            'other_detail' => 'nullable|string',
            'truck_no' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'rate' => 'nullable|numeric',
            'gravity' => 'nullable|numeric',
            'letter' => 'nullable|string',
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Custom validation to ensure either debit or credit is provided
        $validator = Validator::make($request->all(), [
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
        ]);
    
        $validator->after(function ($validator) use ($request) {
            if (is_null($request->debit) && is_null($request->credit)) {
                $validator->errors()->add('debit', 'Either debit or credit is required.');
            }
        });
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Use the current date if no date is provided
        $data['date'] = $request->input('date', Carbon::now()->format('Y-m-d'));
    
        // Check if the date is the current date
        if ($data['date'] === Carbon::now()->format('Y-m-d')) {
            // Get the latest balance for the company
            $latestTransaction = Transaction::where('company_id', $request->company_id)
                ->orderBy('created_at', 'desc')
                ->first();
    
            $current_balance = $latestTransaction ? $latestTransaction->balance : 0;
    
            // Adjust the balance based on debit and credit
            $new_balance = $current_balance;
    
            if ($request->filled('debit')) {
                $new_balance -= $request->debit;
            }
    
            if ($request->filled('credit')) {
                $new_balance += $request->credit;
            }
    
            // Add the calculated balance to the validated data
            $data['balance'] = $new_balance;
        } else {
            $data['balance'] = 0; // Default balance for non-current dates
        }
    
        $data['user_id'] = Auth::id(); // Set the user_id to the authenticated user's ID
    
        // Create the transaction
        $transaction = Transaction::create($data);
    
        activity('transaction')
            ->performedOn($transaction)
            ->causedBy(Auth::user())
            ->withProperties($data)
            ->log('created');
    
        if ($data['date'] !== Carbon::now()->format('Y-m-d')) {
            event(new TransactionCreated($transaction));
        }
    
        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $imagePath = $imageFile->store('images', 'public');
                $transaction->images()->create(['path' => $imagePath]);
            }
        }
    
        return redirect()->route('transactions.index', ['company_id' => $request->company_id])
            ->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $companies = Company::all();
        return view('transactions.edit', compact('transaction', 'companies'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        // Validate the request data
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'date' => 'required|date',
            'payment_method' => 'required|string',
            'other_detail' => 'nullable|string',
            'truck_no' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'rate' => 'nullable|numeric',
            'gravity' => 'nullable|numeric',
            'letter' => 'nullable|string',
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
        ]);

        // Custom validation to ensure either debit or credit is provided
        $validator = Validator::make($request->all(), [
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
        ]);

        $validator->after(function ($validator) use ($request) {
            if (is_null($request->debit) && is_null($request->credit)) {
                $validator->errors()->add('debit', 'Either debit or credit is required.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $transaction->update($data);


        activity('transaction')
            ->performedOn($transaction)
            ->causedBy(Auth::user())
            ->withProperties($data)
            ->log('updated');

        event(new TransactionCreated($transaction));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $transaction->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('transactions.index', ['company_id' => $request->company_id])
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {

        activity('transaction')
            ->performedOn($transaction)
            ->causedBy(Auth::user())
            ->withProperties($transaction)
            ->log('deleted');

        event(new TransactionDeleted($transaction));

        return redirect()->back()
            ->with('success', 'Transaction deleted successfully.');
    }
}
