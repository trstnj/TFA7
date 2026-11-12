
@extends('layouts.app')

@section('title', 'Add Customer - POS System')

@section('content')
    <h1>Add Customer</h1>
    <p>Enter the new customer's information.</p>

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <div>
            <label for="full_name">Full Name</label><br>
            <input
                type="text"
                id="full_name"
                name="full_name"
                value="{{ old('full_name') }}"
                maxlength="100"
                required
            >

            @error('full_name')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="email">Email</label><br>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                maxlength="100"
                required
            >

            @error('email')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="phone">Phone Number</label><br>
            <input
                type="text"
                id="phone"
                name="phone"
                value="{{ old('phone') }}"
                maxlength="20"
            >

            @error('phone')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <button type="submit">Save Customer</button>
        <a href="{{ route('customers.index') }}">Cancel</a>
    </form>
@endsection
