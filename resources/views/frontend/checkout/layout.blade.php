@extends('layouts/frontend')
@section('title', 'Checkout')
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
        <ul class="nav nav-pills">
        <li class="nav-item"><a href="{{route('checkout')}}" class="nav-link {{($step === 'step1') ? 'active' : '' }} ">Address</a></li>
        <li class="nav-item"><a href="{{route('checkout','step2')}}" class="nav-link {{($step === 'step2') ? 'active' : '' }} {{{!array_key_exists(2, $checkout_steps)? 'disabled' : ''}}} ">Delivery Method </a></li>
        <li class="nav-item"><a href="{{route('checkout','step3')}}" class="nav-link {{($step === 'step3') ? 'active' : '' }} {{{!array_key_exists(3, $checkout_steps)? 'disabled' : ''}}} ">Payment Method </a></li>
        <li class="nav-item"><a href="{{route('checkout','step4')}}" class="nav-link {{($step === 'step4') ? 'active' : '' }} {{{!array_key_exists(4, $checkout_steps)? 'disabled' : ''}}} ">Order Review</a></li>
      </ul>
        @yield('checkout-step')
      </div>
      <div class="col-lg-4">
        <div class="block-body order-summary">
          <h6 class="text-uppercase">Order Summary</h6>
          <p>Shipping and additional costs are calculated based on values you have entered</p>
          <ul class="order-menu list-unstyled">
            <li class="d-flex justify-content-between"><span>Order Subtotal </span><strong>{{Helper::totalCartPrice()}}</strong></li>
            @if( isset($shippping_method['charge']))
            <li class="d-flex justify-content-between"><span>Shipping and handling</span><strong>{{Helper::frontendPrice($shippping_method['charge'])}}</strong></li>
            @endif
            <li class="d-flex justify-content-between"><span>Total</span><strong class="text-primary price-total">{{Helper::getCartGrandPrice()}}</strong></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection