@extends('frontend.checkout.layout')
@section('checkout-step')
<div class="tab-content">
  <div id="order-review" class="tab-block">
    <div class="cart">
      <div class="cart-holder">
        <div class="basket-header">
          <div class="row">
            <div class="col-6">Product</div>
            <div class="col-2">Price</div>
            <div class="col-2">Quantity</div>
            <div class="col-2">Unit Price</div>
          </div>
        </div>
        <div class="basket-body">
          <!-- Product-->
          @if(session('cart'))
          @foreach(session('cart') as $id => $details)
          <div class="item row d-flex align-items-center">
            <div class="col-6">
              <div class="d-flex align-items-center">
                <img src="{{asset($details['thumb'])}}" alt="{{$details['name']}}" class="img-fluid">
                <div class="title">
                  <a href="{{route('product.single', $details['slug'])}}">
                    <h6>{{$details['name']}}</h6>  @if($details['varient_label'])<span class="text-muted">{{$details['varient_label']}}</span> @endif </a></div>
              </div>
            </div>
            <div class="col-2"><span>{{Helper::frontendPrice($details['price'])}}</span></div>
            <div class="col-2"><span>{{$details['quantity']}}</span></div>
            <div class="col-2"><span>{{Helper::frontendPrice($details['quantity'] * $details['price'])}}</span></div>
          </div>
          @endforeach
          @endif
        </div>
      </div>
      <div class="total row"><span class="col-md-10 col-2">Total</span><span class="col-md-2 col-10 text-primary">{{Helper::totalCartPrice()}}</span></div>
    </div>
    <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
      <a href="{{route('checkout','step3')}}" class="btn btn-template-outlined wide prev"><i class="fa fa-angle-left"></i>Back to payment method</a>
      <a href="{{route('checkout.final')}}" class="btn btn-template wide next">Place an order<i class="fa fa-angle-right"></i></a>
    </div>
  </div>
</div>
@endsection