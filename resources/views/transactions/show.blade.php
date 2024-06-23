@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Transaction Details</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Transaction Information</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Date:</strong> {{ $transaction->date }}</li>
                <li class="list-group-item"><strong>Payment Method:</strong> {{ $transaction->payment_method }}</li>
                <li class="list-group-item"><strong>Other Detail:</strong> {{ $transaction->other_detail }}</li>
                <li class="list-group-item"><strong>Truck No:</strong> {{ $transaction->truck_no }}</li>
                <li class="list-group-item"><strong>Weight:</strong> {{ $transaction->weight }}</li>
                <li class="list-group-item"><strong>Rate:</strong> {{ $transaction->rate }}</li>
                <li class="list-group-item"><strong>Gravity:</strong> {{ $transaction->gravity }}</li>
                <li class="list-group-item"><strong>Letter:</strong> {{ $transaction->letter }}</li>
                <li class="list-group-item"><strong>Debit:</strong> {{ $transaction->debit }}</li>
                <li class="list-group-item"><strong>Credit:</strong> {{ $transaction->credit }}</li>
                <li class="list-group-item"><strong>Balance:</strong> {{ $transaction->balance }}</li>
                <li class="list-group-item"><strong>Company:</strong> {{ $transaction->company->name }}</li>
            </ul>
        </div>
    </div>

    <div>
        <strong>Images:</strong>
        <div class="row">
            @foreach($transaction->images as $image)
                <div class="col-md-3">
                    <img src="{{ $image->url }}" class="img-fluid" alt="Transaction Image">
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Back to Transactions</a>
        <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning">Edit Transaction</a>
        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this transaction?')">Delete Transaction</button>
        </form>
    </div>
@endsection
