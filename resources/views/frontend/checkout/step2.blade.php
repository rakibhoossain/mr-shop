@extends('frontend.checkout.layout')
@section('checkout-step')
<ul class="nav nav-pills">
  <li class="nav-item"><a href="{{route('checkout')}}" class="nav-link">Address</a></li>
  <li class="nav-item"><a href="{{route('checkout','step2')}}" class="nav-link active">Delivery Method </a></li>
  <li class="nav-item"><a href="#" class="nav-link disabled">Payment Method </a></li>
  <li class="nav-item"><a href="#" class="nav-link disabled">Order Review</a></li>
</ul>
<div class="tab-content">
  <div id="delivery-method" class="tab-block">
    <form action="{{route('checkout.store.step2')}}" method="POST" class="shipping-form">
      @csrf
      <div class="row">
        <div class="form-group col-md-6">
          <input type="radio" name="shippping" id="option1" class="radio-template">
          <label for="option1"><strong>Usps next day</strong><br><span class="label-description">Get it right on next day - fastest option possible.</span></label>
        </div>
        <div class="form-group col-md-6">
          <input type="radio" name="shippping" id="option2" class="radio-template">
          <label for="option2"><strong>Usps next day</strong><br><span class="label-description">Get it right on next day - fastest option possible.</span></label>
        </div>
        <div class="form-group col-md-6">
          <input type="radio" name="shippping" id="option3" class="radio-template">
          <label for="option3"><strong>Usps next day</strong><br><span class="label-description">Get it right on next day - fastest option possible.</span></label>
        </div>
        <div class="form-group col-md-6">
          <input type="radio" name="shippping" id="option4" class="radio-template">
          <label for="option4"><strong>Usps next day</strong><br><span class="label-description">Get it right on next day - fastest option possible.</span></label>
        </div>
      </div>
      <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
        <a href="{{route('checkout')}}" class="btn btn-template-outlined wide prev"><i class="fa fa-angle-left"></i>Back to Address</a>
        <button type="submit" class="btn btn-template wide next">Choose payment method<i class="fa fa-angle-right"></i></button>
      </div>
    </form>
  </div>
</div>
@endsection