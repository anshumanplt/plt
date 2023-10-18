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

            <h3>Billing/Shipping Address</h3>
        <table width="100%" style="border-collapse: collapse;" class="table">
          <tr>
            <td width="180px" class="column-title">Name<td>
            <td class="column-detail">{{ Auth::user()->name }}<td>
          </tr>
          <tr>
            <td width="180px" class="column-title">Email<td>
            <td class="column-detail">{{ Auth::user()->email }}<td>
          </tr>
          <tr>
            <td class="column-title">Mobile<td>
            <td class="column-detail">{{ $order->address->mobile }}<td>
          </tr>
          <tr>
            <td class="column-title">Address1<td>
            <td class="column-detail">{{ $order->address->address1 }}<td>
          </td>
          <tr>
            <td class="column-title">Address2<td>
            <td class="column-detail">{{ $order->address->address2 }}<td>
          </tr>
          <tr>
            <td class="column-title">City<td>
            <td class="column-detail">{{ $order->address->addCity->name }}<td>
          </td>
          <tr>
            <td class="column-title">State<td>
            <td class="column-detail">{{ $order->address->addState->name }}<td>
          </tr>
          <tr>
            <td class="column-title">Country<td>
            <td class="column-detail">{{ $order->address->addCountry->name }}<td>
          </tr>
          <tr>
            <td class="column-title">PIN<td>
            <td class="column-detail">{{ $order->address->pin }}<td>
          </tr>


        </table>
        <br><br><br>

            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Status</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $key => $orderItem)

                        
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><b>{{ $orderItem->sku }}</b> <br><br>{{ $orderItem->product->name }}</td>
                            <td>{{ $orderItem->quantity }}</td>
                            <td> ₹{{ $orderItem->unit_price }}</td>
                            <td>{{ $order->order_state }}</td>
                            <td> ₹{{ $orderItem->subtotal }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4"></td>
                        <td><b>Total Amount:</b></td>
                        <td>₹{{ $order->total_amount }}</td>
                    </tr>
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