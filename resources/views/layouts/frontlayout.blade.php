<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Prettylovingthing">
    <meta name="keywords" content="Prettylovingthing, Ecommerce">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" type="image/x-icon" href="{{ url('/frontend/img/prettyloving-favicon.jpg') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prettylovingthing</title>

    <meta name="googlebot" content="noindex">
<meta name="googlebot-news" content="nosnippet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ url('/frontend/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/frontend/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/frontend/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/frontend/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/frontend/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/frontend/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/frontend/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/frontend/css/style.css') }}" type="text/css">
 {{-- toastr --}}
 <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />

</head>

<body>
    <style>
        .search-results-container {
            max-height: 300px; /* Set the maximum height for the scrollable container */
            overflow-y: auto; /* Add vertical scrollbar when content exceeds container height */
            border: 1px solid #ccc; /* Add a border for clarity */
        }
    </style>
    <!-- Page Preloder -->
    {{-- <div id="preloder">
        <div class="loader"></div>
    </div> --}}

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__close">+</div>
        <ul class="offcanvas__widget">
            <li><span class="icon_search search-switch"></span></li>
            @if(Auth::check())
            <li><a href="{{ url('/wishlist') }}"><span class="icon_heart_alt"></span>
                <div class="tip">   @php 
                    $wishlist = \App\Models\Wishlist::where('user_id', Auth::user()->id)->get();
                    echo count($wishlist);
                    @endphp</div>
            </a></li>
            @endif
            <li><a href="{{ url('/cart') }}"><span class="icon_bag_alt"></span>
                <div class="tip">
                    @if(Auth::check())
                        @php 

                            $cartValue = \App\Models\Cart::where('user_id', Auth::user()->id)->get();
                          
                            echo count($cartValue);
                            
                        @endphp
                        @else
                           
                            {{ session('guest_cart') ? count(session('guest_cart')) : 0 }}
                    @endif
                </div>
            </a></li>
            
        </ul>
        <div class="offcanvas__logo">
            <a href="{{ url('/') }}"><img src="{{ url('/frontend/img/prettylovingthing-logo.png') }}" alt=""></a>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__auth">
            <a href="{{ url('/login') }}">Login</a>
            <a href="{{ url('/register') }}">Register</a>
        </div>
    </div>

    <!-- Offcanvas Menu End -->
   
    <!-- Header Section Begin -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-2">
                    <div class="header__logo">
                        <a href="{{ url('/') }}"><img src="{{ url('/frontend/img/prettylovingthing-logo.png') }}" alt=""></a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <nav class="header__menu">
                        <ul>
                            {{-- <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li> --}}
                            @foreach ($categories as $item)
                                <li><a href="{{ url('category') }}/{{ $item->slug }}">{{ $item->name }}</a>
                                    <?php 
                                        if(count($item->submenu) > 0) {
                                            ?>
                                                <ul class="dropdown">
                                                    @foreach($item->submenu as $submenu)
                                                    <li><a href="{{ url('category') }}/{{ $submenu->slug }}">{{ $submenu->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            <?php
                                        }    
                                    ?>

                                </li>   
  
                            @endforeach

                            {{-- <li><a href="#">Men’s</a></li> --}}
                            {{-- <li><a href="./shop.html">Shop</a></li> --}}
                            {{-- <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="./product-details.html">Product Details</a></li>
                                    <li><a href="./shop-cart.html">Shop Cart</a></li>
                                    <li><a href="./checkout.html">Checkout</a></li>
                                    <li><a href="./blog-details.html">Blog Details</a></li>
                                </ul>
                            </li>
                            <li><a href="./blog.html">Blog</a></li>
                            <li><a href="./contact.html">Contact</a></li> --}}
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__right">
                        @if(!Auth::check())
                                <div class="header__right__auth">
                                    <a href="{{ url('/login') }}">Login</a>
                                    <a href="{{ url('/register') }}">Register</a>
                                </div>
                            @else
                            <div class="header__right__auth">
                                <a href="{{ url('/my-account') }}">My account</a>
                                
                                <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                 {{ __('Logout') }}
                             </a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                 @csrf
                             </form>
                            </div>
                        @endif

                        <ul class="header__right__widget">
                            <li><span class="icon_search search-switch"></span></li>
                            @if(Auth::check())
                            <li><a href="{{ url('/wishlist') }}"><span class="icon_heart_alt"></span>
                                <div class="tip">
                                    @php 
                                    $wishlist = \App\Models\Wishlist::where('user_id', Auth::user()->id)->get();
                                    echo count($wishlist);
                                    @endphp
                                </div>
                            </a></li>
                            @endif
                            <li><a href="{{ url('/cart') }}"><span class="icon_bag_alt"></span>
                                <div class="tip">  
                                    @if(Auth::check())
                                    @php 
                                    $cartValue = \App\Models\Cart::where('user_id', Auth::user()->id)->get();
                                    echo count($cartValue);
                                    @endphp
                                        @else
                                            {{ session('guest_cart') ? count(session('guest_cart')) : 0 }}
                                    @endif
                                    </div>
                            </a></li>
                            
                        </ul>

                    </div>
                </div>
            </div>
            <div class="canvas__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
    
    @yield('content')


    @include('partials.instagram')
    <!-- Instagram Begin -->
{{-- <div class="instagram">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="{{ url('/frontend/img/instagram/insta-1.jpg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">@ prettylovingthing</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="{{ url('/frontend/img/instagram/insta-2.jpg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">@ prettylovingthing</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="{{ url('/frontend/img/instagram/insta-3.jpg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">@ prettylovingthing</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="{{ url('/frontend/img/instagram/insta-4.jpg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">@ prettylovingthing</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="{{ url('/frontend/img/instagram/insta-5.jpg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">@ prettylovingthing</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                <div class="instagram__item set-bg" data-setbg="{{ url('/frontend/img/instagram/insta-6.jpg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">@ prettylovingthing</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- Instagram End -->

<!-- Footer Section Begin -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-7">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="{{ url('/') }}"><img src="{{ url('/frontend/img/prettylovingthing-logo.png') }}" alt=""></a>
                    </div>
                    <p>We are Pretty Loving Thing. The brand behind fashion Freedom.We exist for the love of fashion. We have got all the permimum range of outfits you could ever need in life. from ”designer fashion for women to the latest trends in women’s fashion” From date night dress to ritual colection.</p>
                    <div class="footer__payment">
                        {{-- <a href="javascript:void(0)"><img src="{{ url('/frontend/img/payment/razor.png') }}" height="50" width="50" alt="Razor Pay"></a> --}}
                        {{-- <a href="#"><img src="{{ url('/frontend/img/payment/payment-2.png') }}" alt=""></a>
                        <a href="#"><img src="{{ url('/frontend/img/payment/payment-3.png') }}" alt=""></a>
                        <a href="#"><img src="{{ url('/frontend/img/payment/payment-4.png') }}" alt=""></a>
                        <a href="#"><img src="{{ url('/frontend/img/payment/payment-5.png') }}" alt=""></a> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-5">
                <div class="footer__widget">
                    <h6>Support</h6>
                    <ul>
                        <li><a href="{{ route('aboutus') }}">About</a></li>
                        {{-- <li><a href="#">Blogs</a></li> --}}
                        <li><a href="{{ route('contactus') }}">Contact</a></li>
                        {{-- <li><a href="#">FAQ</a></li> --}}
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4">
                <div class="footer__widget">
                    <h6>Company</h6>
                    <ul id="menu-about" class="">
                        <li><a href="{{ route('privacypolicy') }}">Privacy Policy</a></li> 
                        <li><a href="{{ route('termscondition') }}">Terms &amp; Conditions</a></li> 
                        <li><a href="{{ route('shippingpolicy') }}">Shipping Policy</a></li> 
                        {{-- <li><a href="{{ route('paymentpolicy') }}">Payment Policy</a></li>  --}}
                        <li><a href="{{ route('disputeresolution') }}">Dispute Resolution</a></li> 
                        {{-- <li><a href="{{ route('genuinequalityproduct') }}">Genuine Quality product</a></li>  --}}
                      </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-8 col-sm-8">
                <div class="footer__newslatter">
                    <h6>NEWSLETTER</h6>
                    <form action="{{ route('newsletter') }}" method="post">
                        @csrf
                        <input type="text" required placeholder="Email">
                        <button type="submit" class="site-btn">Subscribe</button>
                    </form>
                    <div class="footer__social">
                        {{-- <a href="#"><i class="fa fa-facebook"></i></a> --}}
                        <a href="https://twitter.com/i/flow/login?redirect_after_login=%2FThingLoving" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="https://www.youtube.com/channel/UCBm6Ma7ePjijiZhysvwB5aw"><i class="fa fa-youtube-play"></i></a>
                        <a href="https://www.instagram.com/prettylovingthing/"><i class="fa fa-instagram"></i></a>
                        <a href="https://in.pinterest.com/PrettyLovingThing/_created/"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                <div class="footer__copyright__text">
                    <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved <a href="{{ url('/') }}" target="_blank">Prettylovingthing</a></p>
                </div>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Search Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">+</div>
        <form class="search-model-form" id="searchForm">
            <input type="text" id="searchQuery" placeholder="Search for products">
        </form>
        <div class="search-results-container">
            <div id="searchResults"></div>
        </div>
    </div>
</div>
<!-- Search End -->

<!-- Js Plugins -->
<script src="{{ url("/frontend/js/jquery-3.3.1.min.js") }}"></script>
<script src="{{ url("/frontend/js/bootstrap.min.js") }}"></script>
<script src="{{ url("/frontend/js/jquery.magnific-popup.min.js") }}"></script>
<script src="{{ url("/frontend/js/jquery-ui.min.js") }}"></script>
<script src="{{ url("/frontend/js/mixitup.min.js") }}"></script>
<script src="{{ url("/frontend/js/jquery.countdown.min.js") }}"></script>
<script src="{{ url("/frontend/js/jquery.slicknav.js") }}"></script>
<script src="{{ url("/frontend/js/owl.carousel.min.js") }}"></script>
<script src="{{ url("/frontend/js/jquery.nicescroll.min.js") }}"></script>
<script src="{{ url("/frontend/js/main.js") }}"></script>
   {{-- toastr js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script>
    function limitStringTo200Characters(inputString) {
        if (inputString.length <= 200) {
            return inputString; // Return the input string as is if it's 200 characters or less
        } else {
            return inputString.slice(0, 200) + " ..."; // Truncate the string to 200 characters and add ellipsis
        }
    }
</script>


<script>
    $(document).ready(function() {
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
    });

</script>
<script>
    $(document).ready(function() {
        $('#country_id').change(function() {
            var countryId = $(this).val();

            $.ajax({
                url: "{{ url('get-states')}}/" + countryId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var $stateSelect = $('#state_id');
                    $stateSelect.empty();

                    $.each(data, function(key, state) {
                        $stateSelect.append('<option value="' + state.id + '">' + state.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#state_id').change(function() {
            var stateId = $(this).val();

            $.ajax({
                url: '/get-cities/' + stateId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var $citySelect = $('#city_id');
                    $citySelect.empty();

                    $.each(data, function(key, city) {
                        $citySelect.append('<option value="' + city.id + '">' + city.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#searchQuery').on('keyup', function () {
            var query = $(this).val();

            $('#searchResults').html('<p>Loading...</p>'); // Display loading indicator

            $.ajax({
                url: "{{ route('search') }}",
                method: "GET",
                data: { query: query },
                success: function (data) {
                    $('#searchResults').html(data);
                }
            });
        });
    });
</script>
</body>

</html>