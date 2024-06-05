@extends('layouts.app')

@section('content')
    <h1>Companies</h1>
    <a href="{{ route('companies.create') }}">Add Company</a>

    <table>
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->address }}</td>
                    <td>{{ $company->phone }}</td>
                    <td>{{ $company->email }}</td>
                    <td>
                        <a href="{{ route('companies.show', $company->id) }}">Show</a>
                        <a href="{{ route('companies.edit', $company->id) }}">Edit</a>
                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
