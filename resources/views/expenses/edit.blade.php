@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Expense</h1>
        <form method="POST" action="{{ route('expenses.update', $expense->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="company_id" class="form-label">Company</label>
                <select name="company_id" id="company_id" class="form-select" required>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ $expense->company_id == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select" required>
                    @foreach (['Online', 'ByHand', 'ATM', 'RTRN UDHAR', 'Udhar Credit', 'Worker Advance', 'R & M EXP', 'MISC EXP'] as $type)
                        <option value="{{ $type }}" {{ $expense->type == $type ? 'selected' : '' }}>
                            {{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3" required>{{ $expense->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" step="0.01"
                    value="{{ $expense->amount }}" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ $expense->date }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Images</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
