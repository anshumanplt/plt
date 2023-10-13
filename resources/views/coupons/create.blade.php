<!-- resources/views/coupons/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="container">
    <h1>Create Coupon</h1>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <form action="{{ route('coupons.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name="code" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select class="form-control" id="type" name="type" required>
                <option value="flat">Flat</option>
                <option value="percentage">Percentage</option>
            </select>
        </div>
        <div class="form-group">
            <label for="discount">Discount</label>
            <input type="number" class="form-control" id="discount" name="discount" required>
        </div>
        <div class="form-group">
            <label for="expiration_date">Expiration Date</label>
            <input type="date" class="form-control" id="expiration_date" name="expiration_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
    </div>
    </div>
</div>
@endsection
