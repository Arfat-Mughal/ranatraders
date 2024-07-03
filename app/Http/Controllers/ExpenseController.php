<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Company;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::query();

        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        if ($request->has('description')) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }

        $expenses = $query->paginate(10);
        $companies = Company::all();

        return view('expenses.index', compact('expenses', 'companies'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('expenses.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required',
            'type' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $expense = Expense::create($validated);

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('expenses', 'public');
                $expense->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('expenses.index');
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $companies = Company::all();
        return view('expenses.edit', compact('expense', 'companies'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'company_id' => 'required',
            'type' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $expense->update($validated);

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('expenses', 'public');
                $expense->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('expenses.index');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index');
    }

    public function export(Request $request)
    {
        // Logic to export expenses based on filters
    }

    public function import(Request $request)
    {
        // Logic to import expenses from Excel
    }
}
