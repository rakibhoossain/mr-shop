@extends('layouts/frontend')
@section('content')
<!-- Hero Section-->
<section class="hero hero-page gray-bg padding-small">
  <div class="container">
    <div class="row d-flex">
      <div class="col-lg-9 order-2 order-lg-1">
        <h1>Checkout</h1><p class="lead text-muted">You currently have {{Helper::totalCartItem()}} items in your shopping cart</p>
      </div>
      <div class="col-lg-3 text-right order-1 order-lg-2">
        <ul class="breadcrumb justify-content-lg-end">
          <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
          <li class="breadcrumb-item active">Checkout</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- Checkout Forms-->
<section class="checkout">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        @yield('checkout-step')
      </div>
      <div class="col-lg-4">
        <div class="block-body order-summary">
          <h6 class="text-uppercase">Order Summary</h6>
          <p>Shipping and additional costs are calculated based on values you have entered</p>
          <ul class="order-menu list-unstyled">
            <li class="d-flex justify-content-between"><span>Order Subtotal </span><strong>{{Helper::totalCartPrice()}}</strong></li>
            <li class="d-flex justify-content-between"><span>Shipping and handling</span><strong>$10.00</strong></li>
            <li class="d-flex justify-content-between"><span>Tax</span><strong>$0.00</strong></li>
            <li class="d-flex justify-content-between"><span>Total</span><strong class="text-primary price-total">$400.00</strong></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection