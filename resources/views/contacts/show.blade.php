@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Contact Details</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $contact->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $contact->email }}</p>
            <p class="card-text"><strong>Subject:</strong> {{ $contact->subject }}</p>
            <p class="card-text"><strong>Message:</strong> {{ $contact->message }}</p>
            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
