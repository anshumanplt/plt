@extends('layouts.frontlayout')
@section('content')
      <!-- Breadcrumb Begin -->
      <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="Javascript:void(0)">My Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
    <!-- Breadcrumb End -->
<div class="container">
    
    <div class="row">
        <div class="sidebar col-md-3">
            @include('myaccount_sidebar')
        </div>
        <div class="content col-md-9">
            <h2>My Orders</h2>
            <table class="table table-bordered">
                <tr>
                    <td>#</td>
                    <td>Order Id</td>
                    <td>Total Amount</td>
                    <td>Payment Method</td>
                    <td>Shipping Address</td>
                    <td>Status</td>
                    <td>Action</td>



                </tr>
                @foreach ($orders as $key =>  $order)
                @php 
                    $cityData = App\Models\City::where('id', $order->address->city)->first();
                    $stateData = App\Models\State::where('id', $order->address->state)->first();
                    $countryData = App\Models\Country::where('id',$order->address->country)->first();
                @endphp
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td> {{ $order->id }}</td>
                        <td> ₹{{ $order->total_amount }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td> <p><b>Address 1 :</b>{{ $order->address->address1 }}</p><br>
                            <p><b>Address 2 :</b>{{ $order->address->address2 }}</p><br>
                            <p><b>City :</b>{{ $cityData->name }}, <br><b>State :</b>{{ $stateData->name }},<br> <b>Country :</b>{{ $countryData->name }}</p></td>
                        {{-- <td> <p>{{ $order->address->address1 }}</p>
                            <p>{{ $order->address->address2 }}</p>
                            <p>{{ $order->address->city }}, {{ $order->address->state }}, {{ $order->address->country }}</p></td> --}}
                        <td>{{ $order->order_state }}</td>
                        <td><a href="{{ route('orders.show', $order->id) }}">View Details</a></td>
                    </tr>
                @endforeach
            </table>
            {{$orders->links('pagination::bootstrap-4')}}
        </div>
    </div>
</div>



@endsection