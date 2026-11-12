@extends('layouts.app')

@section('title', 'Customer Accounts - POS System')

@section('content')
    <h1>Customer Accounts</h1>
    <p>List of registered customers in the POS system.</p>

    <p>
        <a href="{{ route('customers.create') }}">
            Add Customer
        </a>
    </p>

    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->full_name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>
                        <a href="{{ route('customers.edit', $customer->id) }}">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
