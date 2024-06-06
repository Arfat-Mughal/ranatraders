@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Transactions</h1>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">Add Transaction</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Date</th>
                <th>Payment Method</th>
                <th>Other Detail</th>
                <th>Truck No</th>
                <th>Weight</th>
                <th>Rate</th>
                <th>Gravity</th>
                <th>Letter</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
                <th>Company</th>
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
                    <td>{{ $transaction->truck_no }}</td>
                    <td>{{ $transaction->weight }}</td>
                    <td>{{ $transaction->rate }}</td>
                    <td>{{ $transaction->gravity }}</td>
                    <td>{{ $transaction->letter }}</td>
                    <td>{{ $transaction->debit }}</td>
                    <td>{{ $transaction->credit }}</td>
                    <td>{{ $transaction->balance }}</td>
                    <td>{{ $transaction->company->name }}</td>
                    <td>
                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
