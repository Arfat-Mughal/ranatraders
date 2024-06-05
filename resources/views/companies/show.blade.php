@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Company Details</h1>
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ $company->name }}</h2>
                    </div>
                    <div class="card-body">
                        <p><strong>Address:</strong> {{ $company->address }}</p>
                        <p><strong>Phone:</strong> {{ $company->phone }}</p>
                        <p><strong>Email:</strong> {{ $company->email }}</p>
                        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this company?')">Delete</button>
                        </form>
                        <a href="{{ route('companies.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
