@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Record</h1>
        <form method="POST" action="{{ route('records.update', $record->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="company_id" class="form-label">Company</label>
                <select name="company_id" id="company_id" class="form-select">
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ $company->id == $record->company_id ? 'selected' : '' }}>
                            {{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ $record->date }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="dn" class="form-label">D/N</label>
                <select name="dn" id="dn" class="form-select">
                    <option value="Day" {{ $record->dn == 'Day' ? 'selected' : '' }}>Day</option>
                    <option value="Night" {{ $record->dn == 'Night' ? 'selected' : '' }}>Night</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select">
                    <option value="Petrol" {{ $record->type == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                    <option value="Diesel" {{ $record->type == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="rate" class="form-label">Rate</label>
                <input type="number" name="rate" id="rate" step="0.01" class="form-control"
                    value="{{ $record->rate }}" required>
            </div>
            <div class="mb-3">
                <label for="liter" class="form-label">Liter</label>
                <input type="number" name="liter" id="liter" step="0.01" class="form-control"
                    value="{{ $record->liter }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
