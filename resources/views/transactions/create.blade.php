@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Create Transaction Based on Company</h1>

    @include('partials.errors')

    <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col-4">
                <label for="company_id" class="form-label">Company:</label>
                <select id="company_id" name="company_id" class="form-select">
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label for="date" class="form-label">Date:</label>
                <input type="date" id="date" name="date" class="form-control" value="{{ old('date') }}" required>
            </div>
            <div class="col-4">
                <label for="payment_method" class="form-label">Payment Method:</label>
                <input type="text" id="payment_method" name="payment_method" class="form-control" value="{{ old('payment_method') }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
                <label for="other_detail" class="form-label">Other Detail:</label>
                <textarea id="other_detail" name="other_detail" class="form-control">{{ old('other_detail') }}</textarea>
            </div>
            <div class="col-4">
                <label for="truck_no" class="form-label">Truck No:</label>
                <input type="text" id="truck_no" name="truck_no" class="form-control" value="{{ old('truck_no') }}">
            </div>
            <div class="col-4">
                <label for="weight" class="form-label">Weight:</label>
                <input type="number" step="0.01" id="weight" name="weight" class="form-control" value="{{ old('weight') }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
                <label for="rate" class="form-label">Rate:</label>
                <input type="number" step="0.01" id="rate" name="rate" class="form-control" value="{{ old('rate') }}">
            </div>
            <div class="col-4">
                <label for="gravity" class="form-label">Gravity:</label>
                <input type="number" step="0.01" id="gravity" name="gravity" class="form-control" value="{{ old('gravity') }}">
            </div>
            <div class="col-4">
                <label for="letter" class="form-label">Letter:</label>
                <input type="text" id="letter" name="letter" class="form-control" value="{{ old('letter') }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
                <label for="debit" class="form-label">Debit:</label>
                <input type="number" step="0.01" id="debit" name="debit" class="form-control" value="{{ old('debit') }}">
            </div>
            <div class="col-4">
                <label for="credit" class="form-label">Credit:</label>
                <input type="number" step="0.01" id="credit" name="credit" class="form-control" value="{{ old('credit') }}">
            </div>
            <div class="col-4">
                <label for="images" class="form-label">Images:</label>
                <input type="file" id="images" name="images[]" class="form-control" multiple>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
