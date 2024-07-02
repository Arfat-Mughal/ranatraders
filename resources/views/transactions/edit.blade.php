@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Edit Transaction</h1>

    @include('partials.errors')

    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-4">
                <label for="company_id" class="form-label">Company:</label>
                <select id="company_id" name="company_id" class="form-select">
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}"
                            {{ $transaction->company_id == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label for="date" class="form-label">Date:</label>
                <input type="date" id="date" name="date" class="form-control" value="{{ $transaction->date }}"
                    required>
            </div>
            <div class="col-4">
                <label for="payment_method" class="form-label">Payment Method:</label>
                <input type="text" id="payment_method" name="payment_method" class="form-control"
                    value="{{ $transaction->payment_method }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
                <label for="other_detail" class="form-label">Other Detail:</label>
                <textarea id="other_detail" name="other_detail" class="form-control">{{ $transaction->other_detail }}</textarea>
            </div>
            <div class="col-4">
                <label for="truck_no" class="form-label">Truck No:</label>
                <input type="text" id="truck_no" name="truck_no" class="form-control"
                    value="{{ $transaction->truck_no }}">
            </div>
            <div class="col-4">
                <label for="weight" class="form-label">Weight:</label>
                <input type="number" step="0.01" id="weight" name="weight" class="form-control"
                    value="{{ $transaction->weight }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
                <label for="rate" class="form-label">Rate:</label>
                <input type="number" step="0.01" id="rate" name="rate" class="form-control"
                    value="{{ $transaction->rate }}">
            </div>
            <div class="col-4">
                <label for="gravity" class="form-label">Gravity:</label>
                <input type="number" step="0.01" id="gravity" name="gravity" class="form-control"
                    value="{{ $transaction->gravity }}">
            </div>
            <div class="col-4">
                <label for="letter" class="form-label">Letter:</label>
                <input type="text" id="letter" name="letter" class="form-control"
                    value="{{ $transaction->letter }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
                <label for="debit" class="form-label">Debit:</label>
                <input type="number" step="0.01" id="debit" name="debit" class="form-control"
                    value="{{ $transaction->debit }}">
            </div>
            <div class="col-4">
                <label for="credit" class="form-label">Credit:</label>
                <input type="number" step="0.01" id="credit" name="credit" class="form-control"
                    value="{{ $transaction->credit }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
                <label for="images" class="form-label">Add Images:</label>
                <input type="file" id="images" name="images[]" class="form-control" multiple>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <strong>Existing Images:</strong>
                <div class="row">
                    @foreach ($transaction->images as $image)
                        <div class="col-md-3">
                            <img src="{{ Storage::url($image->path) }}" class="img-fluid mb-2" alt="Transaction Image">
                            {{-- <form action="{{ route('images.destroy', $image) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form> --}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
