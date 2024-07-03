<?php

namespace App\Http\Controllers;

use App\Exports\RecordsExport;
use App\Imports\RecordsImport;
use App\Models\Company;
use App\Models\Record;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        $query = Record::with('company');

        if ($request->has('company_id') && $request->company_id) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->has('dn') && $request->dn) {
            $query->where('dn', $request->dn);
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('rate', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('liter', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('amount', 'LIKE', '%' . $request->search . '%');
            });
        }

        $records = $query->paginate(10);

        $companies = Company::all(); // Fetch all companies for the filter dropdown

        return view('records.index', compact('records', 'companies'));
    }


    public function create()
    {
        $companies = Company::all();
        return view('records.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'date' => 'required|date',
            'dn' => 'required|in:Day,Night',
            'type' => 'required|in:Petrol,Diesel',
            'rate' => 'required|numeric',
            'liter' => 'required|numeric',
        ]);

        $record = Record::create($request->all());

        return redirect()->route('records.index')->with('success', 'Record created successfully.');
    }

    public function edit(Record $record)
    {
        $companies = Company::all();
        return view('records.edit', compact('record', 'companies'));
    }

    public function update(Request $request, Record $record)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'date' => 'required|date',
            'dn' => 'required|in:Day,Night',
            'type' => 'required|in:Petrol,Diesel',
            'rate' => 'required|numeric',
            'liter' => 'required|numeric',
        ]);

        $record->update($request->all());

        return redirect()->route('records.index')->with('success', 'Record updated successfully.');
    }

    public function destroy(Record $record)
    {
        $record->delete();

        return redirect()->route('records.index')->with('success', 'Record deleted successfully.');
    }


    public function export(Request $request)
    {
        $companyId = $request->company_id;
        return Excel::download(new RecordsExport($companyId), 'records.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new RecordsImport, $request->file('file'));

        return redirect()->route('records.index')->with('success', 'Records imported successfully.');
    }
}
