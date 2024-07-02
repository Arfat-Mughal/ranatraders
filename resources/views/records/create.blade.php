@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Create New Record</h1>
        <form method="POST" action="{{ route('records.store') }}">
            @csrf
            <div class="mb-3">
                <label for="company_id" class="form-label">Company</label>
                <select name="company_id" id="company_id" class="form-select">
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="dn" class="form-label">D/N</label>
                <select name="dn" id="dn" class="form-select">
                    <option value="Day">Day</option>
                    <option value="Night">Night</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select">
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="rate" class="form-label">Rate</label>
                <input type="number" name="rate" id="rate" step="0.01" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="liter" class="form-label">Liter</label>
                <input type="number" name="liter" id="liter" step="0.01" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
