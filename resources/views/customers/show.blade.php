@extends('layouts.app')

@section('content')
    <h1>Customer Details</h1>

    <div>
        <strong>Name:</strong>
        <p>{{ $customer->name }}</p>
    </div>
    <div>
        <strong>Address:</strong>
        <p>{{ $customer->address }}</p>
    </div>
    <div>
        <strong>Phone:</strong>
        <p>{{ $customer->phone }}</p>
    </div>
    <div>
        <strong>Email:</strong>
        <p>{{ $customer->email }}</p>
    </div>
    <div>
        <strong>Company:</strong>
        <p>{{ $customer->company->name }}</p>
    </div>

    <a href="{{ route('customers.index') }}">Back to List</a>
@endsection
