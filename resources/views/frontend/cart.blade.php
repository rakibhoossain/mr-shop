@extends('layouts/frontend')
@section('title', 'Cart')
@section('content')
    <!-- Hero Section-->
    <section class="hero hero-page gray-bg padding-small">
      <div class="container">
        <div class="row d-flex">
          <div class="col-lg-9 order-2 order-lg-1">
            <h1>Shopping cart</h1><p class="lead text-muted">You currently have {{Helper::totalCartItem()}} items in your shopping cart</p>
          </div>
          <div class="col-lg-3 text-right order-1 order-lg-2">
            <ul class="breadcrumb justify-content-lg-end">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item active">Shopping cart</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!-- Shopping Cart Section-->
    <section class="shopping-cart">
      <form action="{{route('cartUpdate')}}" method="POST">
      @csrf
      <div class="container">
        <div class="basket">
          <div class="basket-holder">
            <div class="basket-header">
              <div class="row">
                <div class="col-5">Product</div>
                <div class="col-2">Price</div>
                <div class="col-2">Quantity</div>
                <div class="col-2">Total</div>
                <div class="col-1 text-center">Remove</div>
              </div>
            </div>
            <div class="basket-body">
              <!-- Product-->
            @if(session('cart'))
            @foreach(session('cart') as $id => $details)
              <div class="item" data-price="{{$details['price']}}">
                <div class="row d-flex align-items-center">
                  <div class="col-5">
                    <div class="d-flex align-items-center">
                      <img src="{{asset($details['thumb'])}}" alt="{{$details['name']}}" class="img-fluid">
                      <div class="title">
                        <a href="{{route('product.single', $details['slug'])}}">
                          <h5>{{$details['name']}}</h5> 
                          @if($details['varient_label'])<span class="text-muted">{{$details['varient_label']}}</span> @endif
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-2"><span>{{Helper::frontendPrice($details['price'])}}</span></div>
                  <div class="col-2">
                    <div class="d-flex align-items-center">
                      <div class="quantity d-flex align-items-center">
                        <div class="dec-btn btn-dec">-</div>
                        <input type="text" name="carts[{{$id}}]" value="{{$details['quantity']}}" class="quantity-no cart_qty" data-max="{{$details['max']}}">
                        <div class="inc-btn btn-inc" data-max="{{$details['max']}}">+</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-2"><span class="cart_price">{{Helper::frontendPrice($details['quantity'] * $details['price'])}}</span></div>
                  <div class="col-1 text-center"><a href="{{route('removeFromCart', $id)}}" class="delete"><i class="delete fa fa-trash"></i></a></div>
                </div>
              </div>
              @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="CTAs d-flex align-items-center justify-content-center justify-content-md-end flex-column flex-md-row"><a href="{{route('shop')}}" class="btn btn-template-outlined wide">Continue Shopping</a><button type="submit" class="btn btn-template wide" style="margin-bottom: 10px; margin-left: 5px;">Update Cart</button></div>
      </div>
      </form>
    </section>
    <!-- Order Details Section-->
    <section class="order-details no-padding-top"> 
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center CTAs"><a href="{{route('checkout')}}" class="btn btn-template btn-lg wide">Proceed to checkout<i class="fa fa-long-arrow-right"></i></a></div>
        </div>
      </div>
    </section>
@endsection