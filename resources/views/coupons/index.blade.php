<!-- resources/views/coupons/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="container">
    <h1>Coupons</h1>
    

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('coupons.create') }}" class="btn btn-primary mb-3">Create Coupon</a>

    <table class="table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Discount</th>
                <th>Expiration Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->code }}</td>
                    <td>{{ $coupon->type }}</td>
                    <td>{{ $coupon->discount }}</td>
                    <td>{{ $coupon->expiration_date }}</td>
                    <td>
                        <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this coupon?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    </div>
    </div>
</div>
@endsection
