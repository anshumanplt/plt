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


    <!-- Checkout Section Begin -->
    <section class="checkout spad">
         <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6 class="coupon__link">
                    {{-- <span class="icon_tag_alt"></span> --}}
                 </h6>
            </div>
        </div>
        @if (!$addresses->isEmpty())
        <h3>Selected Address</h3>
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('addresses.set-default') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label></label>
                            <select class="form-control" name="addressid">
                                @foreach($addresses as $address)
                                @php 
                                    $cityData = App\Models\City::where('id', $address->city)->first();
                                    $stateData = App\Models\State::where('id', $address->state)->first();
                                    $countryData = App\Models\Country::where('id',$address->country)->first();

                                    // echo $cityData->name;
                                @endphp
                                    <option value="{{ $address->id }}" @if($address->is_default) selected @endif>Address: {{ $address->address1 }}, Address2: {{ $address->address2 }}, Mobile: {{ $address->mobile }}, PIN: {{ $address->pin }}, City: {{ $cityData->name }}, State: {{ $stateData->name }}, Country: {{ $countryData->name }}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Set as Default</button>
                    </div>
                </form>

            @foreach ($addresses as $address)
            <div class="col-lg-4" style="display:none;">
                <div class="card-body ">
                    <table class="table-borderless">
                        <tr>
                            <td><b>Address1:</b></td>
                            <td>{{ $address->address1 }}</td>
                        </tr>
                        <tr>
                            <td><b>Address2:</b></td>
                            <td>{{ $address->address2 }}</td>
                        </tr>
                        <tr>
                            <td><b>Mobile:</b></td>
                            <td>{{ $address->mobile }}</td>
                        </tr>
                        <tr>
                            <td><b>Postal:</b></td>
                            <td>{{ $address->pin }}</td>
                        </tr>
                        <tr>
                            <td><b>City:</b></td>
                            <td>
                                @php 
                                    $cityData = App\Models\City::where('id', $address->city)->first();
                                    echo $cityData->name;
                                @endphp
                                </td>
                        </tr>
                        <tr>
                            <td><b>State:</b></td>
                            <td>
                                @php 
                                    $stateData = App\Models\State::where('id', $address->state)->first();
                                    echo $stateData->name;
                                @endphp
                                
                            </td>
                        </tr>
                        <tr>
                            <td><b>Country:</b></td>
                            <td>
                                @php 
                                    $countryData = App\Models\Country::where('id',$address->country)->first();
                                    echo $countryData->name;
                                @endphp
                              
                            </td>
                        </tr>
                        <tr>
                            <td><b>Default Address:</b></td>
                            <td>
                                @if($address->is_default) 
                                    <input type="radio" @if($address->is_default) checked @endif>
                                    @else
                                    <form action="{{ route('addresses.set-default', $address->id) }}" method="post">
                                        @csrf
                                        <button type="submit">Set as Default</button>
                                    </form>
                                @endif
                           
                            </td>
                        </tr>
                    </table>
               
                </div>
            </div>
               
            @endforeach
            </div>
            <br>
        </div>
        @endif
        <form action="{{ route('checkout.addAddress') }}" method="POST" class="checkout__form">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <h5>Shipping detail</h5>
                    <div class="row">
                
                        <div class="col-lg-12">
                          
                            <div class="checkout__form__input">
                                <p>Address <span>*</span></p>
                                <input type="text" name="address1" required placeholder="Address 1">
                                <input type="text" name="address2"  placeholder="Address 2 ( optinal )">
                            </div>
                            <div class="checkout__form__input">
                                <p>Country <span>*</span></p>
                                {{-- <input type="text">
                                 --}}
                                 <select name="country" id="country_id" required class="form-control" id="">
                                    <option value="">--Select Country--</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="checkout__form__input">
                                <p>State <span>*</span></p>
                                {{-- <input type="text"> --}}
                                <select id="state_id" required class="form-control" name="state">
                                    <!-- Options for states... -->
                                </select>
                            </div>
                            <div class="checkout__form__input">
                                <p>Town/City <span>*</span></p>
                                {{-- <input type="text">
                                 --}}
                                 <select id="city_id" required class="form-control" name="city">
                                    <!-- Options for cities... -->
                                </select>
                            </div>
                        
                            <div class="checkout__form__input">
                                <p>Postcode/Zip <span>*</span></p>
                                <input name="pin" required type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Phone <span>*</span></p>
                                <input name="mobile" type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-danger" value="Add Address">
                        </div>
                    </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="checkout__order">
                            <h5>Your order</h5>
                            <div class="checkout__order__product">
                                <ul>
                                    <li>
                                        <span class="top__text">Product</span>
                                        <span class="top__text__right">Total</span>
                                    </li>
                                    @php
                                        $cartTotal = 0;  
                                    @endphp
                                    @foreach($cartItems as $key => $cartItem)

                                    @if($cartItem->sku) 
                                        @php
                                            $getPrice = \App\Models\ProductAttribute::where('sku', $cartItem->sku)->first();
                                            $getAttributeImage = \App\Models\ProductAttributeImage::where('sku', $cartItem->sku)->first();
                                        //    echo '₹ '.$getPrice->price;
                                            $finalPrice =  $getPrice->price;
                                        @endphp
                                    @else
                                        @php 
                                            $finalPrice =  $cartItem->product->sale_price;
                                        @endphp

                                    @endif 

                                    <li>{{ $key + 1 }}. {{ $cartItem->product->name }} <span>₹ {{ $finalPrice }} * {{ $cartItem->quantity }}</span></li>
                                    <?php
                                        $cartTotal += $finalPrice * $cartItem->quantity; // Update cart total
                                    ?>
                                    @endforeach

                                </ul>
                            </div>
                            <div class="checkout__order__total">
                                <ul>
                                    <li>Subtotal <span>₹ {{ $cartTotal }}</span></li>
                                    <li>Shipping Charges <span> @if($cartTotal < 799)₹ 80 @else FREE @endif</span></li>
                                    <li>Total <span>₹ @if($cartTotal < 799)  {{ $cartTotal + 80 }} @else {{ $cartTotal }} @endif</span></li>
                                    
                          
                                </ul>
                            </div>
                            <form action="{{ route('orders.place-order') }}" method="POST">
                                @csrf
                            <div class="checkout__order__widget">
                                <label for="">Payment Method</label>
                                <select name="payment_method" id="" class="form-control">
                                    <option value="COD">COD</option>
                                    <option value="Netbanking">Netbanking</option>
                                </select>
                                {{-- <input type="hidden" name="address_id" value=""> --}}
                                {{-- <label for="cod">
                                    Cash on delivery
                                    <input type="checkbox" id=""  name="payment_method" value="cod">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="paypal">
                                    Netbanking
                                    <input type="checkbox" id=""  name="payment_method" value="netbanking">
                                    <span class="checkmark"></span>
                                </label> --}}
                            </div>
                            <button type="submit" class="site-btn">Place oder</button>
                            </form>
                        </div>
                    </div>
                </div>
            
        </div>
    </section>
        <!-- Checkout Section End -->







@endsection