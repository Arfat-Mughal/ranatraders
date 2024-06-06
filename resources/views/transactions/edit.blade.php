@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Edit Transaction</h1>

    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="company_id" class="form-label">Company:</label>
            <select id="company_id" name="company_id" class="form-select">
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ $transaction->company_id == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date:</label>
            <input type="date" id="date" name="date" class="form-control" value="{{ $transaction->date }}" required>
        </div>
        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method:</label>
            <input type="text" id="payment_method" name="payment_method" class="form-control" value="{{ $transaction->payment_method }}" required>
        </div>
        <div class="mb-3">
            <label for="other_detail" class="form-label">Other Detail:</label>
            <textarea id="other_detail" name="other_detail" class="form-control">{{ $transaction->other_detail }}</textarea>
        </div>
        <div class="mb-3">
            <label for="truck_no" class="form-label">Truck No:</label>
            <input type="text" id="truck_no" name="truck_no" class="form-control" value="{{ $transaction->truck_no }}" required>
        </div>
        <div class="mb-3">
            <label for="weight" class="form-label">Weight:</label>
            <input type="number" step="0.01" id="weight" name="weight" class="form-control" value="{{ $transaction->weight }}" required>
        </div>
        <div class="mb-3">
            <label for="rate" class="form-label">Rate:</label>
            <input type="number" step="0.01" id="rate" name="rate" class="form-control" value="{{ $transaction->rate }}" required>
        </div>
        <div class="mb-3">
            <label for="gravity" class="form-label">Gravity:</label>
            <input type="number" step="0.01" id="gravity" name="gravity" class="form-control" value="{{ $transaction->gravity }}" required>
        </div>
        <div class="mb-3">
            <label for="letter" class="form-label">Letter:</label>
            <input type="text" id="letter" name="letter" class="form-control" value="{{ $transaction->letter }}" required>
        </div>
        <div class="mb-3">
            <label for="debit" class="form-label">Debit:</label>
            <input type="number" step="0.01" id="debit" name="debit" class="form-control" value="{{ $transaction->debit }}">
        </div>
        <div class="mb-3">
            <label for="credit" class="form-label">Credit:</label>
            <input type="number" step="0.01" id="credit" name="credit" class="form-control" value="{{ $transaction->credit }}">
        </div>
        <div class="mb-3">
            <label for="balance" class="form-label">Balance:</label>
            <input type="number" step="0.01" id="balance" name="balance" class="form-control" value="{{ $transaction->balance }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
