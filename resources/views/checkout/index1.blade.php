@extends('layouts.frontlayout')

@section('content')
<div class="container">
    <h2>Checkout</h2>

    <h3>Cart Items</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $cartTotal = 0; ?>
            @foreach ($cartItems as $cartItem)
                <tr>
                    <td>{{ $cartItem->product->name }}</td>
                    <td>{{ $cartItem->quantity }}</td>
                    <td>{{ $cartItem->product->price }}</td>
                    <td>{{ $cartItem->product->price * $cartItem->quantity }}</td>
                </tr>
                <?php
                $cartTotal += $cartItem->product->price * $cartItem->quantity; // Update cart total
            ?>
            @endforeach
        </tbody>
    </table>
    <h4>Total: ₹
        {{ $cartTotal }}
    </h4>
    
  

    <h3>Add Address</h3>
    @if (!$addresses->isEmpty())
    <h3>Selected Address</h3>
    <ul>
        @foreach ($addresses as $address)
            <li>
                {{ $address->address }},
                {{ $address->city }},
                {{ $address->postal_code }}
            </li>
        @endforeach
    </ul>
    @else
        <form action="{{ route('checkout.addAddress') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="city" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="postal_code">Postal Code</label>
                <input type="text" name="postal_code" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Address</button>
        </form>
    @endif
    <button type="submit" class="btn btn-success">Place Order</button>
</div>
@endsection
