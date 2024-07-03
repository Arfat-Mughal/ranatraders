@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Records</h1>
        <form method="GET" action="{{ route('records.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="company_id" id="company_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Select Company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="dn" class="form-select">
                        <option value="">Select D/N</option>
                        <option value="Day" {{ request('dn') == 'Day' ? 'selected' : '' }}>Day</option>
                        <option value="Night" {{ request('dn') == 'Night' ? 'selected' : '' }}>Night</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">Select Type</option>
                        <option value="Petrol" {{ request('type') == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                        <option value="Diesel" {{ request('type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-3">
                    <input type="date" name="start_date" class="form-control" placeholder="Start Date"
                        value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" name="end_date" class="form-control" placeholder="End Date"
                        value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-secondary">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('records.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>

        <div class="row d-flex">
            <div class="col-3">
                <a href="{{ route('records.create') }}" class="btn btn-primary mb-3">Create New Record</a>
            </div>
            @if (request('company_id'))
                <div class="col-3" id="export-import-buttons">
                    <a href="{{ route('records.export', ['company_id' => request('company_id')]) }}"
                        class="btn btn-success">Export to Excel</a>
                </div>
                <div class="col-6">
                    <form method="POST" action="{{ route('records.import') }}" enctype="multipart/form-data"
                        class="d-inline">
                        @csrf
                        <input type="file" name="file" class="form-control-file d-inline" required>
                        <button type="submit" class="btn btn-primary">Import from Excel</button>
                    </form>
                </div>
            @endif
        </div>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Company</th>
                    <th>Date</th>
                    <th>D/N</th>
                    <th>Type</th>
                    <th>Rate</th>
                    <th>Liter</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td>{{ $record->id }}</td>
                        <td>{{ $record->company->name }}</td>
                        <td>{{ $record->date }}</td>
                        <td>{{ $record->dn }}</td>
                        <td>{{ $record->type }}</td>
                        <td>{{ $record->rate }}</td>
                        <td>{{ $record->liter }}</td>
                        <td>{{ $record->amount }}</td>
                        <td>
                            <a href="{{ route('records.edit', $record->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form method="POST" action="{{ route('records.destroy', $record->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $records->links('pagination::bootstrap-5') }}
    </div>
@endsection
