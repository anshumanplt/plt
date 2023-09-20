<!-- resources/views/admin/users/index.blade.php -->

@extends('layouts.app') {{-- Use your admin layout --}}

@section('content')
<div class="card">
    <div class="card-body">

        <div class="container">
            <h1>All Orders</h1>


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
                        <th>#</th>
                        <th>Order Id</th>
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                        <th>Shipping Address</th>
                        <th>Status</th>
                        <th>Action</th>
    
    
    
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
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
                        <td>{{ $order->order_state }}</td>
                        <td><a href="{{ route('admin.orders.show', $order->id) }}">View Details</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $orders->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
