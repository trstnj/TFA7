@extends('layouts.app')

@section('title', 'User Accounts - POS System')

@section('content')
    <h1>User Accounts</h1>
    <p>List of staff accounts in the POS system.</p>

    <p>
        <a href="{{ route('users.create') }}">
            Add User
        </a>
    </p>

    <table>
        <thead>
            <tr>
                <th>Avatar</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>
                        @if ($user->avatar)
                            <img
                                src="{{ asset('storage/' . $user->avatar) }}"
                                alt="{{ $user->full_name }}'s avatar"
                                width="60"
                                height="60"
                                style="object-fit: cover; border-radius: 50%;"
                            >
                        @else
                            <img
                                src="{{ asset('images/default-avatar.svg') }}"
                                alt="Default avatar"
                                width="60"
                                height="60"
                                style="object-fit: cover; border-radius: 50%;"
                            >
                        @endif
                    </td>

                    <td>{{ $user->username }}</td>
                    <td>{{ $user->full_name }}</td>

                    <td>
                        <a href="{{ route('users.edit', $user->id) }}">
                            Edit
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        No user accounts found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
