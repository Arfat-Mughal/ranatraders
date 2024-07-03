@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Expenses</h1>
        <form method="GET" action="{{ route('expenses.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <select name="company_id" class="form-select">
                        <option value="">Select Company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">Select Type</option>
                        @foreach (['Online', 'ByHand', 'ATM', 'RTRN UDHAR', 'Udhar Credit', 'Worker Advance', 'R & M EXP', 'MISC EXP'] as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                {{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="description" class="form-control" placeholder="Search Description"
                        value="{{ request('description') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-secondary">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>

        @if (request('company_id'))
            <div class="row mb-3" id="export-import-buttons">
                <div class="col">
                    <a href="{{ route('expenses.export', request()->all()) }}" class="btn btn-success">Export to Excel</a>
                </div>
                <div class="col">
                    <form method="POST" action="{{ route('expenses.import') }}" enctype="multipart/form-data"
                        class="d-inline">
                        @csrf
                        <input type="file" name="file" class="form-control-file d-inline" required>
                        <button type="submit" class="btn btn-primary">Import from Excel</button>
                    </form>
                </div>
            </div>
        @endif

        <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-3">Create New Expense</a>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Company</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                    <tr>
                        <td>{{ $expense->id }}</td>
                        <td>{{ $expense->company->name }}</td>
                        <td>{{ $expense->type }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>{{ $expense->amount }}</td>
                        <td>{{ $expense->date }}</td>
                        <td>
                            <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form method="POST" action="{{ route('expenses.destroy', $expense->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $expenses->links('pagination::bootstrap-5') }}
    </div>
@endsection
