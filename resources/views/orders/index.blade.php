@extends('layouts.frontlayout')
@section('content')
      <!-- Breadcrumb Begin -->
      <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
<div class="container">
    
    <div class="row">
        <div class="col-md-3">
            @include('myaccount_sidebar')
        </div>
        <div class="col-md-9">
            <h2>My Orders</h2>
            <table class="table">
                <tr>
                    <td>Order Id</td>
                    <td>Total Amount</td>
                    <td>Payment Method</td>
                    <td>Shipping Address</td>
                    <td>Status</td>
                    <td>Action</td>



                </tr>
                @foreach ($orders as $order)
                    <tr>
                        <td> {{ $order->id }}</td>
                        <td> ₹{{ $order->total_amount }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td> <p>{{ $order->address->address1 }}</p>
                            <p>{{ $order->address->address2 }}</p>
                            <p>{{ $order->address->city }}, {{ $order->address->state }}, {{ $order->address->country }}</p></td>
                        <td>{{ $order->order_state }}</td>
                        <td><a href="{{ route('orders.show', $order->id) }}">View Details</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>



@endsection