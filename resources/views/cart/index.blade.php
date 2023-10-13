@extends('layouts.frontlayout')
@section('content')

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Shopping cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Flash messages -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="shop__cart__table">
                        @if (count($cartItems) == 0)
                            <center><h3>Your cart is empty.</h3></center>
                        @else
                        <table>
                            <thead>
                                <tr>
                                    
                                    <th>Product</th>
                                    
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $cartTotal = 0;  
                                @endphp
                                @foreach ($cartItems as $cartItem)

                                @if($cartItem->sku) 
                                    @php
                                        $getPrice = \App\Models\ProductAttribute::where('sku', $cartItem->sku)->first();
                                        $getAttributeImage = \App\Models\ProductAttributeImage::where('sku', $cartItem->sku)->first();
                                    //    echo '₹ '.$getPrice->price;
                                        $finalPrice =  $getPrice->price;
                                    @endphp
                                @else
                                    @php 
                                        $finalPrice =  $cartItem->sale_price;
                                    @endphp

                                @endif 
                                <tr>
                                    <td class="cart__product__item">
                                        {{-- <img src="{{ url('/frontend/img/shop-cart/cp-1.jpg') }}" alt=""> --}}
                                        @if($getAttributeImage)
                                            <img src="{{ asset('storage/'.$getAttributeImage->image_path) }}" alt="Product Image" width="50"> 
                                        @else
                                            @if (count($cartItem->images) > 0)
                                                <img src="@if(count($cartItem->images) > 0) {{ asset('storage/'.$cartItem->images[0]->image_path) }}@endif" alt="Product Image" width="50">
                                            @else
                                                No Image
                                            @endif
                                        @endif

                                        <div class="cart__product__item__title">
                                            <h6>{{ $cartItem->name }}</h6>
                                            <p>{{ $cartItem->sku }}</p>
                                        </div>
                                    </td>

                                    <td class="cart__quantity">
                                        {{-- <div class="pro-qty"> --}}
                                            {{-- <input type="text" value="{{ $cartItem->quantity }}"> --}}
                                            <form action="{{ route('cart.update', ['product' => $cartItem->id, 'sku' => $cartItem->sku]) }}" method="POST">
                                                @csrf                            
                                                <input type="hidden" name="_method" value="PUT">                            
                                                <input type="number" name="quantity" value="{{ $cartItem->quantity }}" class="col-sm-4" min="1" fdprocessedid="k2zmpw">
                                                <button type="submit" fdprocessedid="bn3unn" class="btn btn-primary btn-xs">Update</button>
                                            </form>
                                        {{-- </div> --}}
                                    </td>

                                    <td class="cart__price">₹ {{ $finalPrice }}</td>
                                    <td class="cart__total">₹ {{ $cartItem->quantity * $finalPrice }}</td>
                                    <td class="cart__close"> <a href="{{ route('cart.remove', $cartItem->sku) }}"><span class="icon_close"></span></a></td>
                                </tr>
                                <?php
                                    $cartTotal += $finalPrice * $cartItem->quantity; // Update cart total
                                ?>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
            @if (count($cartItems) > 0)
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="{{ url('/') }}">Continue Shopping</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    {{-- <div class="cart__btn update__btn">
                        <a href="#"><span class="icon_loading"></span> Update cart</a>
                    </div> --}}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                
                    <div class="discount__content">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" id="couponCode"  name="couponCode" placeholder="Enter your coupon code">
                            <button type="button" id="applyCoupon" class="site-btn">Apply</button>
                            <span id="couponError" style="color: red;"></span>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="cart__total__procced">
                        <h6>Cart total</h6>
                        <ul>
                            @php
                            $beforeDiscount = $cartTotal;
                            if($discount) {
                                if($discount->type == 'percentage') {
                                    $discountPercentage = ($cartTotal * $discount->discount) / 100;
                                    
                                    if($discountPercentage > 100) {
                                        $discount->discount = 100;

                                    }else{
                                        $discount->discount = $discountPercentage;
                                    }

                                    

                                    if (($cartTotal > $discount->discount) && ($cartTotal >= 500)) {
                                        $cartTotal = $cartTotal - $discount->discount;
                                    }

                                }else{
                                    if (($cartTotal > $discount->discount) && ($cartTotal >= 500)) {
                                        $cartTotal = $cartTotal - $discount->discount;
                                    }
                                }
                             
                            } 

                   
                       @endphp
                            <li>Subtotal <span>₹ {{ $beforeDiscount }}</span></li>
                            <li>Shipping Charges <span> @if($cartTotal < 799)₹ 80 @else FREE @endif</span></li>
                            @if($discount)
                                @if(($cartTotal > $discount->discount) && ($cartTotal >= 500)) 
                                    <li>Coupon Code <span> @if($discount) {{ $discount->code }} @else NA @endif</span></li>
                                    <li>Discount <span>-₹ @if($discount){{ $discount->discount }}   @else 0 @endif</span></li>
                                @endif
                                @else 
                                    <li>Coupon Code <span> NA </span></li>
                                    <li>Discount <span>₹ 0</span></li>
                            @endif
                          
                            <li>Total <span>₹ @if($cartTotal < 799)  {{ $cartTotal + 80 }} @else {{ $cartTotal }} @endif</span></li>
                        </ul>
                        <a href="{{ url('checkout') }}" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    <!-- Shop Cart Section End -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#applyCoupon').click(function () {
                // Get the entered coupon code
                var couponCode = $('#couponCode').val();
    
                // Make an AJAX request to validate the coupon code
                $.ajax({
                    type: 'POST',
                    url: '/validate-coupon', // Replace with the actual URL for coupon validation
                    data: {
                        _token: '{{ csrf_token() }}',
                        couponCode: couponCode
                    },
                    success: function (response) {
                        // Check the response from the server
                        if (response.valid) {
                            // Coupon is valid, you can proceed with your logic
                            $('#couponError').text('Coupon applied successfully');
                            location.reload();
                        } else {
                            // Coupon is invalid, display an error message
                            $('#couponError').text('Invalid coupon code');
                        }
                    },
                    error: function () {
                        // Handle any errors from the server
                        $('#couponError').text('An error occurred while validating the coupon');
                    }
                });
            });
        });
    </script>
@endsection