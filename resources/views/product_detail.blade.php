@extends('layouts.frontlayout')
@section('content')

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        {{-- <a href="#">Women’s </a> --}}
                        <span>{{ $product->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
            
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__left product__thumb nice-scroll">
                           
                            @if(count($variantData) > 0)
                                @if(count($variantData['productSKUImages']) > 0)
                                    @foreach ($variantData['productSKUImages'] as $key => $item)
                                        <a class="pt active" href="#product-{{$key}}">
                                            <img src="{{ asset('storage/'.$item->image_path) }}" alt="">
                                        </a>                                
                                    @endforeach
                                @endif
                            @else
                                @foreach ($product->productImages as $key => $item)
                                    <a class="pt active" href="#product-{{$key}}">
                                        <img src="{{ asset('storage/'.$item->image_path) }}" alt="">
                                    </a>                                
                                @endforeach   
                            @endif 
                        </div>
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                @if(count($variantData) > 0)
                                    @if(count($variantData['productSKUImages']) > 0)
                                        @foreach ($variantData['productSKUImages'] as $key => $item)
                                            <img data-hash="product-{{ $key }}" class="product__big__img" src="{{ asset('storage/'.$item->image_path) }}" alt="">
                                        @endforeach   
                                    @endif
                                @else
                                    @foreach ($product->productImages as $key => $item)
                                        <img data-hash="product-{{ $key }}" class="product__big__img" src="{{ asset('storage/'.$item->image_path) }}" alt="">
                                    @endforeach
                                @endif


                  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="col-sm-12">
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    </div>
                    <div class="product__details__text">
                        <h3>{{ $product->name }}</h3>
                        <div class="rating">
                            {{-- <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <span>( 138 reviews )</span> --}}
                        </div>

                        <div class="product__details__price">
                            @if(count($variantData) > 0) 
                                ₹ {{ $variantData['productSku']->price }}
                            @else
                                ₹ {{ $product->sale_price }}
                            @endif
                                
                        
                            <span>₹ {{ $product->price }}</span></div>
                        <p>@if(count($variantData) > 0) <b>SKU:</b> {{ $variantData['productSku']->sku }} @endif</p>
                        <p>{{ $product->description }}</p>
                        <div class="product__details__button">
                            {{-- <div class="quantity">
                                <span>Quantity:</span>
                                <div class="pro-qty">
                                    <input type="text" value="1">
                                </div>
                            </div> --}}
                            @if(count($variantData) > 0) 
                                <a href="{{ url('/cart/add') }}/{{ $product->id }}@if(count($variantData) > 0)/{{ $variantData['productSku']->sku }} @endif"   class="cart-btn"><span class="icon_bag_alt"></span> Add to cart</a>
                            @else

                            @if(count($allSelectedAttributevalue) > 0)
                                @if(count($variantData) > 0) 
                                    <a href="javascript:void(0)" onclick="alert('Please select product variant.')"  class="cart-btn"><span class="icon_bag_alt"></span> Add to cart</a>
                                    @else 
                                    <form method="POST" action="{{ route('notifyme') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Email:</label>
                                            <input type="text" placeholder="Email" required class="form-control" name="email" >
                                        </div>
                                        <button type="submit" class="cart-btn">Notify Me</button>
    
                                    </form>
                                @endif
                                @else
                                <form method="POST" action="{{ route('notifyme') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Email:</label>
                                        <input type="text" placeholder="Email" required class="form-control" name="email" >
                                    </div>
                                    <button type="submit" class="cart-btn">Notify Me</button>

                                </form>

                            @endif

                            @endif
                            <ul>
                               

                                @if(Auth::check())
                                    @php 
                                        $wishlist = \App\Models\Wishlist::where(['user_id' => Auth::user()->id, 'product_id' => $product->id])->first();
                                        
                                    @endphp
                                        @if($wishlist) 
                                            <li><a href="{{ route('wishlist.remove', $wishlist->id) }}"><span class="icon_heart_alt" style="color: red;"></span></a></li>
                                            @else
                                            <li><a href="{{ url('/wishlist/add') }}/{{ $product->id }}"><span class="icon_heart_alt"></span></a></li>
                                        @endif

                                    @else
                                        <li><a href="{{ url('/wishlist/add') }}/{{ $product->id }}"><span class="icon_heart_alt"></span></a></li>
                                @endif

                                {{-- <li><a href="#"><span class="icon_adjust-horiz"></span></a></li> --}}
                            </ul>
                        </div>
                        <div class="product__details__widget">
                            
                            @if(count($allSelectedAttributevalue) > 0)
                                <form action="{{ url('/product-detail') }}/{{ $product->id }}" id="myForm" method="get">
                                    @csrf
                                    @foreach ($allAttribute as $key => $item)
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <span>{{ $item->name }}:</span>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="stock__checkbox">
                                                    @foreach($item->attributeValues as $value) 
                                                        @if(in_array($value->id, $allSelectedAttributevalue))
                                                            <label for="">
                                                                <label for="">{{ $value->value }}</label>   
                                                                <input type="radio" name="{{ $item->name }}" class="options" @if( request()->get($item->name) )  @if($value->id == request()->get($item->name)) checked @endif @endif value="{{ $value->id }}" id="">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <button type="submit" style="display: none;">Submit Variants</button>
                                </form>
                            @endif
                           

                             
                             
                           
                        </div>
                    </div>
                </div>
                <div class="col-lg-12" style="display: none;">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Specification</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( 2 )</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <h6>Description</h6>
                                <p>{{ $product->description }}</p>
                               
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <h6>Specification</h6>
                                <p>NA</p>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <h6>Reviews ( 2 )</h6>
                                <p>NA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-top: 10%;">
                <div class="col-lg-12 text-center">
                    <div class="related__title">
                        <h5>RELATED PRODUCTS</h5>
                    </div>
                </div>
                @php 
                    $productCount = 0;
                @endphp
                @foreach ($relatedProduct as $item)
                @if(count($item->productImages) > 0)
                    @php 
                        ++$productCount ;
                    @endphp
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="@if(count($item->productImages) > 0){{ asset('storage/'.$item->productImages[0]->image_path) }} @endif"> 
                                <div class="label new">New</div>
                                <ul class="product__hover">
                                    <li><a href="@if(count($item->productImages) > 0){{ asset('storage/'.$item->productImages[0]->image_path) }} @endif" class="image-popup"><span class="arrow_expand"></span></a></li>
                                    @if(Auth::check())
                                        @php 
                                            $wishlist = \App\Models\Wishlist::where(['user_id' => Auth::user()->id, 'product_id' => $item->id])->first();
                                            
                                        @endphp
                                            @if($wishlist) 
                                                <li><a href="{{ route('wishlist.remove', $wishlist->id) }}"><span class="icon_heart_alt" style="color: red;"></span></a></li>
                                                @else
                                                <li><a href="{{ url('/wishlist/add') }}/{{ $product->id }}"><span class="icon_heart_alt"></span></a></li>
                                            @endif

                                        @else
                                            <li><a href="{{ url('/wishlist/add') }}/{{ $item->id }}"><span class="icon_heart_alt"></span></a></li>
                                    @endif
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="{{ url('/product-detail') }}/{{ $item->id }}">{{ $item->name }}</a></h6>
                                <div class="rating">
                                    {{-- <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i> --}}
                                </div>
                                <div class="product__price">₹ {{ $item->sale_price }}<span>₹ {{ $item->price }}</div>
                            </div>
                        </div>
                    </div>

                @endif
                @endforeach
                @if($productCount == 0) 
                <div class="col-lg-12 text-center">
                    <center>No related product availble.</center>
                </div>
                    @endif
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->
    <script>
        // Get a reference to the form
        var form = document.getElementById('myForm');
    
        // Get a reference to the radio buttons
        var radioButtons = form.getElementsByClassName('options');
    
        // Attach a change event listener to the radio buttons
        for (var i = 0; i < radioButtons.length; i++) {
            radioButtons[i].addEventListener('change', function () {
                // Check if any radio button is checked
                for (var j = 0; j < radioButtons.length; j++) {
                    if (radioButtons[j].checked) {
                        // Submit the form
                        form.submit();
                        break;
                    }
                }
            });
        }
    </script>
    <script>
 
        function getAttribute() {
            e.preventDefault();
            alert("check");
        }
     
        // attribute, attributeValue
    
    </script>

@endsection