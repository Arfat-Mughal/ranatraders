@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Customers</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('customers.create') }}" class="btn btn-primary">Add Customer</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Sr.No</th>
                        <th>Name</th>
                        {{-- <th>Address</th> --}}
                        <th>Phone</th>
                        <th>Email</th>
                        {{-- <th>Company</th> --}}
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $customer->name }}</td>
                            {{-- <td>{{ $customer->address }}</td> --}}
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            {{-- <td>{{ $customer->company->name }}</td> --}}
                            <td>
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info btn-sm">Show</a>
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
