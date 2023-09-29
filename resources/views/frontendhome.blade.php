@extends('layouts.frontlayout')

@section('content')

{{-- New category section --}}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<section class="categories">
    <div class="">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @foreach($banners as $key => $banner)
                    <li data-target="#myCarousel" data-slide-to="{{ $key }}" @if($key == 0) class="active" @endif></li>                    
                @endforeach
              {{-- <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li> --}}
            </ol>
        
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                @foreach($banners as $key => $banner)
                    <div class="item @if($key == 0) active @endif">
                        @if($banner->url)
                            <a href="{{ $banner->url }}" target="_blank">
                                <img src="{{ asset('storage/'.$banner->banner_image) }}" alt="{{ $banner->banner_image }}" style="width:100%;">
                            </a>
                        @else 
                            <img src="{{ asset('storage/'.$banner->banner_image) }}" alt="{{ $banner->banner_image }}" style="width:100%;">
                        @endif

                    </div>
                @endforeach    
              {{-- <div class="item">
                <img src="{{url('/frontend/img/slider-2.jpeg') }}" alt="Chicago" style="width:100%;">
              </div>
            
              <div class="item">
                <img src="{{url('/frontend/img/slider-1.jpeg') }}" alt="New york" style="width:100%;">
              </div> --}}
            </div>
        
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
    </div>
</section>

{{-- End New Category section --}}
<!-- Categories Section Begin -->
    <section class="product spad">
        <div class="container-fluid">
            <div class="row">
            
            <div class="col-lg-12">
                {{-- <div class="section-title">
                    <h4>All Category</h4>
                </div> --}}
                <div class="row">

                    @foreach ($categoriesWithImages as $key=> $item)
                    @if($key > 0)
                        <div class="col-lg-3 col-md-3 col-sm-3 p-0" style="padding: 1%;">
                            <a href="{{ url('category') }}/{{ $item->slug }}">
                                <img src="{{ url('/images/categories/') }}/{{ $item->image }}" class="img-responsive" alt="">
                            </a>
                        
                        </div>    
                    @endif                    
                    @endforeach


                   
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h4>New product</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">All</li>
                    @foreach($categoryProduct as $value)
                        <li data-filter=".{{ $value->name }}">{{ $value->name }}</li>
                    @endforeach
                    {{-- <li data-filter=".women">Women’s</li>
                    <li data-filter=".men">Men’s</li>
                    <li data-filter=".kid">Kid’s</li>
                    <li data-filter=".accessories">Accessories</li>
                    <li data-filter=".cosmetic">Cosmetics</li> --}}
                </ul>
            </div>
        </div>
        <div class="row property__gallery">
            
           

            @foreach($categoryProduct as $value)
                 
                    @foreach($value->products as $product)
                        @if(count($product->productImages) > 0)
                            <div class="col-lg-3 col-md-4 col-sm-6 mix {{ $value->name }}">
                                <div class="product__item">
                                    <a href="{{ url('/product-detail') }}/{{ $product->slug }}"><img height="350" src="@if(count($product->productImages) > 0){{ asset('storage/'.$product->productImages[0]->image_path) }} @endif" alt="{{ $product->name }}"></a>
                                        <div style="display: none;" class="product__item__pic set-bg" data-setbg="@if(count($product->productImages) > 0) {{ asset('storage/'.$product->productImages[0]->image_path) }} @endif">
                                            <div class="label new">New</div>
                                            <ul class="product__hover">
                                                <li><a href="{{ asset('storage/'.$product->productImages[0]->image_path) }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                                {{-- Wishlist Section --}}
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

                                                
                                            </ul>
                                        </div>
                              
                                    <div class="product__item__text">
                                        <h6><a href="{{ url('/product-detail') }}/{{ $product->slug }}">{{ $product->name }}</a></h6>
                                        <div class="rating">
                                
                                        </div>
                                        <div class="product__price">₹ {{ $product->sale_price }}<span>₹ {{ $product->price }}</span></div>
                                    </div>
                                </div>
                            </div>

                        @endif
                    @endforeach
                
            @endforeach
      
        </div>
    </div>
</section>
<!-- Product Section End -->

<!-- Banner Section Begin -->
<section class="banner set-bg" data-setbg="@if($promotionalbanner){{ asset('storage/'.$promotionalbanner->background_image) }} @endif">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-8 m-auto">
                <div class="banner__slider owl-carousel">
                    @foreach($promotionalslider as $value)
                        <div class="banner__item">
                            <div class="banner__text">
                                <span>{{ $value->title }}</span>
                                <h1>{{ $value->description }}</h1>
                                <a href="{{ $value->url }}" target="_blank">Shop now</a>
                            </div>
                        </div>
                    @endforeach    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Trend Section Begin -->
<section class="trend spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Hot Trend</h4>
                    </div>
                    @foreach($hotTrendsProducts as $product)
                        <div class="trend__item">
                            <div class="trend__item__pic">
                                <img src="{{ asset('storage/'.$product->productImages[0]->image_path) }}" alt="" height="50" width="50">
                            </div> 
                            <div class="trend__item__text">
                                <h6><a href="{{ url('/product-detail') }}/{{ $product->slug }}">{{ $product->name }}</a></h6>
                                <div class="rating">
                                    {{-- <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i> --}}
                                </div>
                                <div class="product__price">₹ {{ $product->sale_price }}<span>₹ {{ $product->price }}</div>
                            </div>
                        </div>
                    @endforeach
                    {{-- <div class="trend__item">
                        <div class="trend__item__pic">
                            <img src="{{ url('/frontend/img/trend/ht-2.jp') }}g" alt="">
                        </div>
                        <div class="trend__item__text">
                            <h6>Pendant earrings</h6>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product__price">$ 59.0</div>
                        </div>
                    </div>
                    <div class="trend__item">
                        <div class="trend__item__pic">
                            <img src="{{ url('/frontend/img/trend/ht-3.jp') }}g" alt="">
                        </div>
                        <div class="trend__item__text">
                            <h6>Cotton T-Shirt</h6>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product__price">$ 59.0</div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Best seller</h4>
                    </div>
                    @foreach($bestsellerProducts as $product)
                        <div class="trend__item">
                            <div class="trend__item__pic">
                                <img src="{{ asset('storage/'.$product->productImages[0]->image_path) }}" alt=""  height="50" width="50">
                            </div>
                            <div class="trend__item__text">
                                <h6><a href="{{ url('/product-detail') }}/{{ $product->slug }}">{{ $product->name }}</a></h6>
                                <div class="rating">
                                    {{-- <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i> --}}
                                </div>
                                <div class="product__price">₹ {{ $product->sale_price }}<span>₹ {{ $product->price }}</div>
                            </div>
                        </div>
                    @endforeach
                   
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Feature</h4>
                    </div>
                    @foreach($featureProducts as $product)
                    <div class="trend__item">
                        <div class="trend__item__pic">
                            <img src="{{ asset('storage/'.$product->productImages[0]->image_path) }}" alt=""  height="50" width="50">
                        </div>
                        <div class="trend__item__text">
                            <h6><a href="{{ url('/product-detail') }}/{{ $product->slug }}">{{ $product->name }}</a></h6>
                            <div class="rating">
                                {{-- <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i> --}}
                            </div>
                            <div class="product__price">₹ {{ $product->sale_price }}<span>₹ {{ $product->price }}</div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Trend Section End -->

<!-- Discount Section Begin -->
<section class="discount">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 p-0">
                <div class="discount__pic">
                    <img src="@if($discountbanner){{ asset('storage/'.$discountbanner->discount_background_image) }}@endif" alt="">
                </div>
            </div>
            <div class="col-lg-6 p-0">
                <div class="discount__text">
                    <div class="discount__text__title">
                        <span>Discount</span>
                        <h2>Summer {{ date('Y') }}</h2>
                        {{-- <h5><span>Sale</span> 50%</h5> --}}
                    </div>
                    <div class="discount__countdown" id="countdown-time" style="display: none;">
                        <div class="countdown__item">
                            <span>22</span>
                            <p>Days</p>
                        </div>
                        <div class="countdown__item">
                            <span>18</span>
                            <p>Hour</p>
                        </div>
                        <div class="countdown__item">
                            <span>46</span>
                            <p>Min</p>
                        </div>
                        <div class="countdown__item">
                            <span>05</span>
                            <p>Sec</p>
                        </div>
                    </div>
                    <a href="@if($discountbanner) {{$discountbanner->url}} @endif" target="_blank">Shop now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Discount Section End -->

<!-- Services Section Begin -->
<section class="services spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-car"></i>
                    <h6>Free Shipping</h6>
                    <p>For all order over $99</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-money"></i>
                    <h6>Money Back Guarantee</h6>
                    <p>If good have Problems</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-support"></i>
                    <h6>Online Support 24/7</h6>
                    <p>Dedicated support</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-headphones"></i>
                    <h6>Payment Secure</h6>
                    <p>100% secure payment</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

@endsection