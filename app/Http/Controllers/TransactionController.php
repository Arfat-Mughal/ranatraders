<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Company;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('company')->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('transactions.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'date' => 'required|date',
            'payment_method' => 'required|string',
            'other_detail' => 'nullable|string',
            'truck_no' => 'required|string',
            'weight' => 'required|numeric',
            'rate' => 'required|numeric',
            'gravity' => 'required|numeric',
            'letter' => 'required|string',
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
            'balance' => 'required|numeric',
        ]);

        Transaction::create($request->all());
        return redirect()->route('transactions.index')
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
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'date' => 'required|date',
            'payment_method' => 'required|string',
            'other_detail' => 'nullable|string',
            'truck_no' => 'required|string',
            'weight' => 'required|numeric',
            'rate' => 'required|numeric',
            'gravity' => 'required|numeric',
            'letter' => 'required|string',
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
            'balance' => 'required|numeric',
        ]);

        $transaction->update($request->all());
        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
