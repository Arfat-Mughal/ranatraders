@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Transactions</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @include('partials.errors')

    <div class="row mb-3">
        <div class="col-lg-3">
            <form action="{{ route('transactions.index') }}" method="GET">
                <label for="company_id" class="form-label">Select Company</label>
                <select id="company_id" name="company_id" class="form-select" required>
                    <option value="" disabled selected>Select a Company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                    @endforeach
                </select>
        </div>
        <div class="col-lg-2">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-lg-2">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-lg-2">
            <label class="form-label">&nbsp;</label>
            <button type="submit" class="btn btn-primary w-100">Filter</button>
            </form>
        </div>
        <div class="col-lg-3">
            <label class="form-label">&nbsp;</label>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary w-100">Add Transaction</a>
        </div>
    </div>
    <div class="row mb-3">
        @if(request('company_id'))
        <div class="col-lg-3">
                <form action="{{ route('transactions.export') }}" method="GET">
                    <input type="hidden" name="company_id" value="{{ request('company_id') }}">
                    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                    <button type="submit" class="btn btn-success w-100 mt-3">Export to Excel</button>
                </form>
                </div>
                <div class="col-lg-6 mt-3">
                    <form action="{{ route('transactions.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                        @csrf
                        <div class="form-group mb-0 mr-1">
                            <input type="file" class="form-control-file" id="file" name="file">
                        </div>
                        <input type="hidden" name="company_id" value="{{ request('company_id') }}">
                        <button type="submit" class="btn btn-primary ml-2">Import Excel </button>
                    </form>
                </div>
                
        @endif
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Date</th>
                <th>Payment Method</th>
                <th>Other Detail</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->date }}</td>
                    <td>{{ $transaction->payment_method }}</td>
                    <td>{{ $transaction->other_detail }}</td>
                    <td>{{ $transaction->debit }}</td>
                    <td>{{ $transaction->credit }}</td>
                    <td>{{ $transaction->balance }}</td>
                    <td>
                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm" onclick="return confirmEdit()">Edit</a>
                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this transaction?');
        }
    
        function confirmEdit() {
            return confirm('Be careful, Activities are recoded. Still need to update this transaction?');
        }
    </script>

    {{ $transactions->appends(request()->input())->links() }}
@endsection
