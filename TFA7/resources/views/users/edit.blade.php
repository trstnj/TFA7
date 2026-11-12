@extends('layouts.app')

@section('title', 'Edit User - POS System')

@section('content')
    <h1>Edit User</h1>
    <p>Update the user's account information.</p>

    <form
        action="{{ route('users.update', $user->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div>
            <label for="username">Username</label><br>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username', $user->username) }}"
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
                value="{{ old('full_name', $user->full_name) }}"
                maxlength="100"
                required
            >

            @error('full_name')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="avatar">Profile Picture</label><br>

            <input
                type="file"
                id="avatar"
                name="avatar"
                accept="image/jpeg,image/png,image/webp"
            >

            <p>
                JPEG, PNG, or WebP only.
                Maximum file size: 2 MB.
            </p>

            @error('avatar')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        @if ($user->avatar)
            <div>
                <p>Current Profile Picture:</p>

                <img
                    src="{{ asset('storage/' . $user->avatar) }}"
                    alt="Current profile picture"
                    width="100"
                    height="100"
                    style="object-fit: cover; border-radius: 50%;"
                >
            </div>

            <br>
        @endif

        <button type="submit">Update User</button>

        <a href="{{ route('users.index') }}">Cancel</a>
    </form>
@endsection
