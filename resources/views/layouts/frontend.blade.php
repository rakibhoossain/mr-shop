<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from demo.bootstrapious.com/hub/1-4-3/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 19 Mar 2020 03:57:56 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('settings.site_name')}} | @yield('title' , 'Home')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">
    <!-- Bootstrap Select-->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-select/css/bootstrap-select.min.css')}}">
    <!-- Price Slider Stylesheets -->
    <link rel="stylesheet" href="{{asset('vendor/nouislider/nouislider.css')}}">
    <!-- Custom font icons-->
    <link rel="stylesheet" href="{{asset('css/custom-fonticons.css')}}">
    <!-- Google fonts - Poppins-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700">
    <!-- owl carousel-->
    <link rel="stylesheet" href="{{asset('vendor/owl.carousel/assets/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/owl.carousel/assets/owl.theme.default.css')}}">

    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('css/frontend.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset(config('settings.site_favicon'))}}">
    <!-- Modernizr-->
    <script src="{{asset('js/modernizr.custom.79639.js')}}"></script>
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body data-currency="{{Shop::currency()}}">
    <!-- navbar-->
    <header class="header">
      <!-- Tob Bar-->
      <div class="top-bar">
        <div class="container-fluid">
          <div class="row d-flex align-items-center">
            <div class="col-lg-6 hidden-lg-down text-col">
              <ul class="list-inline">
                <li class="list-inline-item"><i class="icon-telephone"></i><a href="tel:{{config('settings.default_phone')}}">{{config('settings.default_phone')}}</a></li>
                <li class="list-inline-item">Free shipping on orders over $300</li>
              </ul>
            </div>
            <div class="col-lg-6 d-flex justify-content-end">
              <!-- Language Dropdown-->
              <div class="dropdown show"><a id="langsDropdown" href="https://example.com/" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-4-3/img/united-kingdom.svg" alt="english">English</a>
                <div aria-labelledby="langsDropdown" class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-4-3/img/germany.svg" alt="german">German</a><a href="#" class="dropdown-item"> <img src="https://d19m59y37dris4.cloudfront.net/hub/1-4-3/img/france.svg" alt="french">French</a></div>
              </div>
              <!-- Currency Dropdown-->
              <div class="dropdown show"><a id="currencyDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle">USD</a>
                <div aria-labelledby="currencyDropdown" class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item">EUR</a><a href="#" class="dropdown-item"> GBP</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <nav class="navbar navbar-expand-lg">
        <div class="search-area">
          <div class="search-area-inner d-flex align-items-center justify-content-center">
            <div class="close-btn"><i class="icon-close"></i></div>
            <form action="#">
              <div class="form-group">
                <input type="search" name="search" id="search" placeholder="What are you looking for?">
                <button type="submit" class="submit"><i class="icon-search"></i></button>
              </div>
            </form>
          </div>
        </div>
        <div class="container-fluid">  
          <!-- Navbar Header  -->
          <a href="{{route('home')}}" class="navbar-brand">
          @if(config('settings.site_logo'))
            <img src="{{asset(config('settings.site_logo'))}}" alt="{{config('settings.site_name')}}">
          @else
            <h2>{{config('settings.site_name')}}</h2>
          @endif
          </a>
          <button type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>
          <!-- Navbar Collapse -->
          <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item"><a href="{{route('home')}}" class="nav-link active">Home</a>
              <li class="nav-item"><a href="{{route('shop')}}" class="nav-link">Shop</a>

                <!-- only for web gurd -->
              <li class="nav-item"><a href="{{route('account.index')}}" class="nav-link">Account</a>


              <li class="nav-item"><a href="{{route('contact')}}" class="nav-link">Contact</a>


                
              </li>



            </ul>
            <div class="right-col d-flex align-items-lg-center flex-column flex-lg-row">
              <!-- Search Button-->
              <div class="search"><i class="icon-search"></i></div>
              <!-- User Not Logged - link to login page-->
              <div class="user dropdown"> 



                <!-- <a id="userdetails" href="customer-login.html" class="user-link"><i class="icon-profile"></i></a> -->

<!-- <li class="nav-item"> -->
        <a class="nav-link" data-toggle="dropdown" href="#"><i class="icon-profile"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
        </div>
      <!-- </li> -->




              </div>
              <!-- Cart Dropdown-->
              <div class="cart dropdown show"><a id="cartdetails" href="https://example.com/" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="icon-cart"></i>
                  <div class="cart-no">{{Shop::totalCartItem()}}</div></a><a href="{{route('cart')}}" class="text-primary view-cart">View Cart</a>

                <div aria-labelledby="cartdetails" class="dropdown-menu">
                  @if(session('cart'))
                  <!-- cart item-->
                  @foreach(session('cart') as $id => $details)
                  <div class="dropdown-item cart-product">
                    <div class="d-flex align-items-center">
                      <div class="img"><img src="{{asset($details['thumb'])}}" alt="..." class="img-fluid"></div>
                      <div class="details d-flex justify-content-between">
                        <div class="text"> <a href="#"><strong>{{$details['name']}}</strong></a><small>Quantity: {{$details['quantity']}} </small><span class="price">{{Shop::frontendPrice($details['quantity'] * $details['price'])}} </span></div><a href="{{route('removeFromCart', $id)}}" class="delete"><i class="fa fa-trash-o"></i></a>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  <!-- total price-->
                  <div class="dropdown-item total-price d-flex justify-content-between"><span>Total</span><strong class="text-primary">{{Shop::frontendPrice(Shop::totalCartPrice())}}</strong></div>
                  <!-- call to actions-->
                  <div class="dropdown-item CTA d-flex"><a href="{{route('cart')}}" class="btn btn-template wide">View Cart</a><a href="{{route('checkout')}}" class="btn btn-template wide">Checkout</a></div>
                  @else
                  <div class="dropdown-item cart-product">
                    <div class="d-flex align-items-center">
                      <h2>Cart empty!</h2>
                    </div>
                  </div>
                  @endif



                </div>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </header>
    @yield('content')
    @include('frontend/partials/product_popup')
    @include('alert')

    <div id="scrollTop"><i class="fa fa-long-arrow-up"></i></div>
    <!-- Footer-->
    <footer class="main-footer">
      <!-- Service Block-->
      <div class="services-block">
        <div class="container">
          <div class="row">
            <div class="col-lg-4 d-flex justify-content-center justify-content-lg-start">
              <div class="item d-flex align-items-center">
                <div class="icon"><i class="icon-truck"></i></div>
                <div class="text">
                  <h6 class="no-margin text-uppercase">Free shipping &amp; return</h6><span>Free Shipping over $300</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 d-flex justify-content-center">
              <div class="item d-flex align-items-center">
                <div class="icon"><i class="icon-coin"></i></div>
                <div class="text">
                  <h6 class="no-margin text-uppercase">Money back guarantee</h6><span>30 Days Money Back Guarantee</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 d-flex justify-content-center">
              <div class="item d-flex align-items-center">
                <div class="icon"><i class="icon-headphones"></i></div>
                <div class="text">
                  <h6 class="no-margin text-uppercase">020-800-456-747</h6><span>24/7 Available Support</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Main Block -->
      <div class="main-block">
        <div class="container">
          <div class="row">
            <div class="info col-lg-4">
              <div class="logo">
                @if(config('settings.site_logo'))
                  <img src="{{asset(config('settings.site_logo'))}}" alt="{{config('settings.site_name')}}">
                @else
                  <h2>{{config('settings.site_name')}}</h2>
                @endif
              </div>
              <p>{{config('settings.site_tagline')}}</p>
              <ul class="social-menu list-inline">
                @if(config('settings.social_facebook'))<li class="list-inline-item"><a href="{{config('settings.social_facebook')}}" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li> @endif          
                @if(config('settings.social_twitter'))<li class="list-inline-item"><a href="{{config('settings.social_twitter')}}" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li> @endif
                @if(config('settings.social_instagram'))<li class="list-inline-item"><a href="{{config('settings.social_instagram')}}" target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a></li> @endif
                @if(config('settings.social_pinterest'))<li class="list-inline-item"><a href="{{config('settings.social_pinterest')}}" target="_blank" title="Pinterest"><i class="fa fa-pinterest"></i></a></li> @endif
                @if(config('settings.social_vimeo'))<li class="list-inline-item"><a href="{{config('settings.social_vimeo')}}" target="_blank" title="vimeo"><i class="fa fa-vimeo"></i></a></li> @endif
                @if(config('settings.social_youtube'))<li class="list-inline-item"><a href="{{config('settings.social_youtube')}}" target="_blank" title="Youtube"><i class="fa fa-youtube"></i></a></li> @endif
              </ul>
            </div>
            <div class="site-links col-lg-2 col-md-6">
              <h5 class="text-uppercase">Shop</h5>
              <ul class="list-unstyled">
                <li> <a href="#">For Women</a></li>
                <li> <a href="#">For Men</a></li>
                <li> <a href="#">Stores</a></li>
                <li> <a href="#">Our Blog</a></li>
                <li> <a href="#">Shop</a></li>
              </ul>
            </div>
            <div class="site-links col-lg-2 col-md-6">
              <h5 class="text-uppercase">Company</h5>
              <ul class="list-unstyled">
                <li> <a href="#">Login</a></li>
                <li> <a href="#">Register</a></li>
                <li> <a href="#">Wishlist</a></li>
                <li> <a href="#">Our Products</a></li>
                <li> <a href="#">Checkouts</a></li>
              </ul>
            </div>
            <div class="newsletter col-lg-4">
              <h5 class="text-uppercase">Daily Offers & Discounts</h5>
              <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. At itaque temporibus.</p>
              <form action="#" id="newsletter-form">
                <div class="form-group">
                  <input type="email" name="subscribermail" placeholder="Your Email Address">
                  <button type="submit"> <i class="fa fa-paper-plane"></i></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights">
        <div class="container">
          <div class="row d-flex align-items-center">
            <div class="text col-md-6">
              {!!config('settings.footer_copyright_text')!!}
            </div>
            <div class="payment col-md-6 clearfix">
              <ul class="payment-list list-inline-item pull-right">
                <li class="list-inline-item"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-4-3/img/visa.svg" alt="..."></li>
                <li class="list-inline-item"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-4-3/img/mastercard.svg" alt="..."></li>
                <li class="list-inline-item"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-4-3/img/paypal.svg" alt="..."></li>
                <li class="list-inline-item"><img src="https://d19m59y37dris4.cloudfront.net/hub/1-4-3/img/western-union.svg" alt="..."></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <button type="button" data-toggle="collapse" data-target="#style-switch" id="style-switch-button" class="btn btn-primary btn-sm d-none d-lg-block"><i class="fa fa-cog fa-2x"></i></button>
    <div id="style-switch" class="collapse">
      <h4 class="text-uppercase">Select theme colour</h4>
      <form class="mb-3">
        <select name="colour" id="colour" class="form-control style-switch-select">
          <option value="">select colour variant</option>
          <option value="default">violet</option>
          <option value="pink">pink</option>
          <option value="green">green</option>
          <option value="red">red</option>
          <option value="sea">sea</option>
          <option value="blue">blue</option>
        </select>
      </form>
      <p><img src="{{asset('img/template-mac.png')}}" alt="" class="img-fluid"></p>
      <p class="text-muted text-small">Stylesheet switching is done via JavaScript and can cause a blink while page loads. This will not happen in your production code.</p>
    </div>

    <!-- JavaScript files-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('vendor/owl.carousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('vendor/nouislider/nouislider.min.js')}}"></script>
    <script src="{{asset('vendor/jquery-countdown/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('vendor/masonry-layout/masonry.pkgd.min.js')}}"></script>
    <script src="{{asset('vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
    <!-- masonry -->
    <script>
      $(function(){
          var $grid = $('.masonry-wrapper').masonry({
              itemSelector: '.item',
              columnWidth: '.item',
              percentPosition: true,
              transitionDuration: 0,
          });
      
          $grid.imagesLoaded().progress( function() {
              $grid.masonry();
          });
      })


      
      
    </script>
    <script src="{{asset('js/jquery.inputmask.bundle.js')}}"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>
    <!-- Main Template File-->
    <script src="{{asset('js/front.js')}}"></script>
    @stack('scripts')
  </body>

</html>