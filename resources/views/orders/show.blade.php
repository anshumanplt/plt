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

    <div class="container" style="min-height: 450px;">
    
        <div class="row">
            <div class="col-md-3">
                @include('myaccount_sidebar')
            </div>
            <div class="col-md-9">
                <h2>Order Details</h2>
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
                @if ($order->order_state === 'pending')
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger">Cancel Order</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

@endsection