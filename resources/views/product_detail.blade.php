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
                                            <img src="{{ asset('../storage/app/public/'.$item->image_path) }}" alt="">
                                        </a>                                
                                    @endforeach
                                @endif
                            @else
                                @foreach ($product->productImages as $key => $item)
                                    <a class="pt active" href="#product-{{$key}}">
                                        <img src="{{ asset('../storage/app/public/'.$item->image_path) }}" alt="">
                                    </a>                                
                                @endforeach   
                            @endif 
                        </div>
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                @if(count($variantData) > 0)
                                    @if(count($variantData['productSKUImages']) > 0)
                                        @foreach ($variantData['productSKUImages'] as $key => $item)
                                            <img data-hash="product-{{ $key }}" class="product__big__img" src="{{ asset('../storage/app/public/'.$item->image_path) }}" alt="">
                                        @endforeach   
                                    @endif
                                @else
                                    @foreach ($product->productImages as $key => $item)
                                        <img data-hash="product-{{ $key }}" class="product__big__img" src="{{ asset('../storage/app/public/'.$item->image_path) }}" alt="">
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
                            <a href="javascript:void(0)" onclick="alert('Please select product variant.')"  class="cart-btn"><span class="icon_bag_alt"></span> Add to cart</a>

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
                            <form action="{{ url('/product-detail') }}/{{ $product->id }}" method="get">
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
                                                            <input type="radio" name="{{ $item->name }}" @if( request()->get($item->name) )  @if($value->id == request()->get($item->name)) checked @endif @endif value="{{ $value->id }}" id="">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <button type="submit">Submit Variants</button>
                            </form>
                            
                            <form action="{{ url('/product-detail') }}/{{ $product->id }}" method="get" style="display: none;">
                                @csrf
                                @foreach ($allAttribute as $key => $item)
                          
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <span>{{ $item->name }}:</span>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="stock__checkbox">
                                                
                                                    @foreach($allArray as $key1 => $value)
                                                        @if($value['attribute_id'] == $item->id) 
                                                        <label for="">
                                                            <label for="">{{ $value['value'] }}</label>   
                                                            <input type="radio" name="{{ $item->name }}" value="{{ $value['id'] }}" id="">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        @endif

                                                    @endforeach
                                                    
                                                    

                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                @endforeach
                                <button type="submit">Submit Variants</button>
                            </form>

                             
                             
                                {{-- <li>
                                    <span>Promotions:</span>
                                    <p>Free shipping</p>
                                </li> --}}
                            {{-- </ul> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
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
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="related__title">
                        <h5>RELATED PRODUCTS</h5>
                    </div>
                </div>
                @foreach ($relatedProduct as $item)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="@if(count($item->productImages) > 0){{ asset('../storage/app/public/'.$item->productImages[0]->image_path) }} @endif">
                            <div class="label new">New</div>
                            <ul class="product__hover">
                                <li><a href="@if(count($item->productImages) > 0){{ asset('../storage/app/public/'.$item->productImages[0]->image_path) }} @endif" class="image-popup"><span class="arrow_expand"></span></a></li>
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
                @endforeach
                
            
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <script>
 
        function getAttribute() {
            e.preventDefault();
            alert("check");
        }
     
        // attribute, attributeValue
    
    </script>

@endsection