@extends('layouts/frontend')
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
                    <div class="d-flex align-items-center"><img src="{{asset($details['thumb'])}}" alt="..." class="img-fluid">
                      <div class="title">
                        <a href="detail.html">
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
        <div class="CTAs d-flex align-items-center justify-content-center justify-content-md-end flex-column flex-md-row"><a href="{{route('shop')}}" class="btn btn-template-outlined wide">Continue Shopping</a><a href="#" class="btn btn-template wide">Update Cart</a></div>
      </div>
    </section>
    <!-- Order Details Section-->
    <section class="order-details no-padding-top"> 
      <div class="container">
        <div class="row">                         
<!--           <div class="col-lg-6">
            <div class="block">
              <div class="block-header">
                <h6 class="text-uppercase">Coupon Code</h6>
              </div>
              <div class="block-body">
                <p>If you have a coupon code, please enter it in the box below</p>
                <form action="#">
                  <div class="form-group d-flex">
                    <input type="text" name="coupon">
                    <button type="submit" class="cart-black-button">Apply coupon</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="block">
              <div class="block-header">
                <h6 class="text-uppercase">Instructions for seller</h6>
              </div>
              <div class="block-body">
                <p>If you have some information for the seller you can leave them in the box below</p>
                <form action="#">
                  <textarea name="instructions"></textarea>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="block">
              <div class="block-header">
                <h6 class="text-uppercase">Order Summary</h6>
              </div>
              <div class="block-body">
                <p>Shipping and additional costs are calculated based on values you have entered.</p>
                <ul class="order-menu list-unstyled">
                  <li class="d-flex justify-content-between"><span>Order Subtotal </span><strong>$390.00</strong></li>
                  <li class="d-flex justify-content-between"><span>Shipping and handling</span><strong>$10.00</strong></li>
                  <li class="d-flex justify-content-between"><span>Tax</span><strong>$0.00</strong></li>
                  <li class="d-flex justify-content-between"><span>Total</span><strong class="text-primary price-total">$400.00</strong></li>
                </ul>
              </div>
            </div>
          </div> -->
          <div class="col-lg-12 text-center CTAs"><a href="checkout1.html" class="btn btn-template btn-lg wide">Proceed to checkout<i class="fa fa-long-arrow-right"></i></a></div>
        </div>
      </div>
    </section>
@endsection