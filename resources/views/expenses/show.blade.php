@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Expense Details</h1>
        <div class="mb-3">
            <label class="form-label">Company:</label>
            <p>{{ $expense->company->name }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label">Type:</label>
            <p>{{ $expense->type }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label">Description:</label>
            <p>{{ $expense->description }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label">Amount:</label>
            <p>{{ $expense->amount }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label">Date:</label>
            <p>{{ $expense->date }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label">Images:</label>
            <div>
                @foreach ($expense->images as $image)
                    <img src="{{ $image->url }}" class="img-thumbnail" style="width: 150px; height: 150px;"
                        alt="Expense Image">
                @endforeach
            </div>
        </div>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
