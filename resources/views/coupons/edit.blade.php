<!-- resources/views/coupons/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="container">
    <h1>Edit Coupon</h1>

    <form action="{{ route('coupons.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $coupon->code }}" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select class="form-control" id="type" name="type" required>
                <option value="flat" {{ $coupon->type === 'flat' ? 'selected' : '' }}>Flat</option>
                <option value="percentage" {{ $coupon->type === 'percentage' ? 'selected' : '' }}>Percentage</option>
            </select>
        </div>
        <div class="form-group">
            <label for="discount">Discount</label>
            <input type="number" class="form-control" id="discount" name="discount" value="{{ $coupon->discount }}" required>
        </div>
        <div class="form-group">
            <label for="expiration_date">Expiration Date</label>
            <input type="date" class="form-control" id="expiration_date" name="expiration_date" value="{{ $coupon->expiration_date }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    </div>
</div>
</div>
@endsection
