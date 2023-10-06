@extends('layouts.frontlayout')

@section('content')



    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="shop__sidebar">
                        <div class="sidebar__categories">
                            <div class="section-title">
                                <h4>Categories</h4>
                            </div>
                            <div class="categories__accordion">
                                <div class="accordion" id="accordionExample">
                                    @foreach ($categories as $item)
                                    <div class="card">
                                        <div class="card-heading active">
                                            <a data-toggle="collapse" data-target="#collapseOne{{ $item->slug }}">{{ $item->name }}</a>
                                        </div>
                                        <div id="collapseOne{{ $item->category_id }}" class="collapse show" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <ul>
                                                    @foreach($item->submenu as $submenu)
                                                        <li><a href="{{ url('category') }}/{{ $submenu->slug }}">{{ $submenu->name }}</a></li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="sidebar__filter" style="display:none;">
                            <div class="section-title">
                                <h4>Shop by price</h4>
                            </div>
                            <div class="filter-range-wrap">
                                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="33" data-max="99"></div>
                                <div class="range-slider">
                                    <div class="price-input">
                                        <p>Price:</p>
                                        <input type="text" id="minamount">
                                        <input type="text" id="maxamount">
                                    </div>
                                </div>
                            </div>
                            <a href="#">Filter</a>
                        </div>
                        <div class="sidebar__sizes" style="display:none;">
                            <div class="section-title">
                                <h4>Shop by size</h4>
                            </div>
                            <div class="size__list">
                                <label for="xxs">
                                    xxs
                                    <input type="checkbox" id="xxs">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="xs">
                                    xs
                                    <input type="checkbox" id="xs">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="xss">
                                    xs-s
                                    <input type="checkbox" id="xss">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="s">
                                    s
                                    <input type="checkbox" id="s">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="m">
                                    m
                                    <input type="checkbox" id="m">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="ml">
                                    m-l
                                    <input type="checkbox" id="ml">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="l">
                                    l
                                    <input type="checkbox" id="l">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="xl">
                                    xl
                                    <input type="checkbox" id="xl">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="sidebar__color" style="display:none;">
                            <div class="section-title">
                                <h4>Shop by size</h4>
                            </div>
                            <div class="size__list color__list">
                                <label for="black">
                                    Blacks
                                    <input type="checkbox" id="black">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="whites">
                                    Whites
                                    <input type="checkbox" id="whites">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="reds">
                                    Reds
                                    <input type="checkbox" id="reds">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="greys">
                                    Greys
                                    <input type="checkbox" id="greys">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="blues">
                                    Blues
                                    <input type="checkbox" id="blues">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="beige">
                                    Beige Tones
                                    <input type="checkbox" id="beige">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="greens">
                                    Greens
                                    <input type="checkbox" id="greens">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="yellows">
                                    Yellows
                                    <input type="checkbox" id="yellows">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        @if(count($products) == 0) 
                            <center><h3>No product found.</h3></center>
                        @endif
                        @foreach($products as $product)
                        @if(count($product->productImages) > 0)
                        <div class="col-lg-4 col-md-6">
                            <div class="product__item">
                                <a href="{{ url('/product-detail') }}/{{ $product->slug }}"><img height="100%" src="@if(count($product->productImages) > 0){{ asset('storage/'.$product->productImages[0]->image_path) }} @endif" alt="{{ $product->name }}"></a>
                                <div style="display: none;" class="product__item__pic set-bg" data-setbg="@if(count($product->productImages) > 0){{ asset('storage/'.$product->productImages[0]->image_path) }} @endif">
                                    <div class="label new">New</div>
                                    <ul class="product__hover">
                                        <li>
                                            <?php 
                                                if(count($product->productImages) > 0) {
                                                    ?>
                                                        <a href="{{ asset('storage/'.$product->productImages[0]->image_path) }}" class="image-popup"><span class="arrow_expand"></span></a>
                                                    <?php
                                                }else{
                                                    ?>
                                                        <a href="img/shop/shop-1.jpg" class="image-popup"><span class="arrow_expand"></span></a>
                                                    <?php
                                                }
                                            ?>

                                        </li>
                                        <li><a href="{{ url('/wishlist/add') }}/{{ $product->id }}"><span class="icon_heart_alt"></span></a></li>
                                        {{-- <li><a href="{{ url('/cart/add') }}/{{ $product->id }}"><span class="icon_bag_alt"></span></a></li> --}}
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="{{ url('/product-detail') }}/{{ $product->slug }}">{{ $product->name }}</a></h6>
                                    <div class="rating">
                                        {{-- <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i> --}}
                                    </div>
                                    <div class="product__price">₹ {{ $product->sale_price }}<span>₹ {{ $product->price }}</span></div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        
                        {{-- <div class="col-lg-4 col-md-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{ url('/frontend/img/shop/shop-2.jpg') }}">
                                    <ul class="product__hover">
                                        <li><a href="img/shop/shop-2.jpg" class="image-popup"><span class="arrow_expand"></span></a></li>
                                        <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                        <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="#">Flowy striped skirt</a></h6>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="product__price">$ 49.0</div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-lg-12 text-center">
                            {{ $products->links('pagination::bootstrap-4') }}
                            <?php //echo $products->render(); ?>
                            {{-- <div class="pagination__option">
                                <a href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <a href="#"><i class="fa fa-angle-right"></i></a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
@endsection