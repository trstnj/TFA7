@extends('layouts.app')

@section('title', 'Add User - POS System')

@section('content')
    <h1>Add User</h1>
    <p>Enter the new user's account information.</p>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div>
            <label for="username">Username</label><br>

            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username') }}"
                maxlength="50"
                required
            >

            @error('username')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

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

        <button type="submit">Save User</button>
        <a href="{{ route('users.index') }}">Cancel</a>
    </form>
@endsection
