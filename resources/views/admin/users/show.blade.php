<!-- resources/views/admin/users/show.blade.php -->

@extends('layouts.app') {{-- Use your admin layout --}}

@section('content')
<div class="card">
    <div class="card-body">
        <div class="container">
            <h1>Admin User Details</h1>
            <p><strong>Name:</strong> {{ $adminUser->name }}</p>
            <p><strong>Email:</strong> {{ $adminUser->email }}</p>
            {{-- Add more details as needed --}}
        </div>
    </div>
</div>
@endsection
