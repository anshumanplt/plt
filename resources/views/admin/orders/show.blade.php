<!-- resources/views/admin/users/index.blade.php -->

@extends('layouts.app') {{-- Use your admin layout --}}

@section('content')
<div class="card">
    <div class="card-body">

        <div class="container">
            <h1>Order Details</h1>


            {{-- <a href="{{ route('admin-users.create') }}" class="btn btn-primary mb-3">Create Admin User</a> --}}

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Status</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $orderItem)
                        <tr>
                            <td>{{ $orderItem->product->name }}</td>
                            <td>{{ $orderItem->quantity }}</td>
                            <td> ₹{{ $orderItem->unit_price }}</td>
                            <td>{{ $order->order_state }}</td>
                            <td> ₹{{ $orderItem->subtotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
            <p>Total Amount:  ₹{{ $order->total_amount }}</p>
            {{-- @if ($order->order_state === 'pending') --}}
                <form action="{{ route('admin.orders.updatestatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-sm-4">
                        <label for=""></label>
                        <select name="orderstatus" id="" class="form-control">
                            <option value="">--Select Status--</option>
                            <option value="pending" @if($order->order_state == 'pending') selected @endif>Pending</option>
                            <option value="confirmed" @if($order->order_state == 'confirmed') selected @endif>Confirmed</option>
                            <option value="shipped" @if($order->order_state == 'shipped') selected @endif>Shipped</option>
                            <option value="completed" @if($order->order_state == 'completed') selected @endif>Completed</option>
                            <option value="cancel" @if($order->order_state == 'cancel') selected @endif>Cancelled</option>


                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3">Update Order Status</button>
                </form>

              
            {{-- @endif --}}

        </div>
    </div>
</div>
@endsection