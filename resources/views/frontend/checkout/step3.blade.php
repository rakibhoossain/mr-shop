@extends('frontend.checkout.layout')
@section('checkout-step')
<ul class="nav nav-pills">
  <li class="nav-item"><a href="{{route('checkout')}}" class="nav-link">Address</a></li>
  <li class="nav-item"><a href="{{route('checkout','step2')}}" class="nav-link">Delivery Method </a></li>
  <li class="nav-item"><a href="{{route('checkout','step3')}}" class="nav-link active">Payment Method </a></li>
  <li class="nav-item"><a href="#" class="nav-link disabled">Order Review</a></li>
</ul>
<div class="tab-content">
  <div id="payment-method" class="tab-block">
    <form action="{{route('checkout.store.step3')}}" method="POST" class="shipping-form">
      @csrf
      <div id="accordion" role="tablist" aria-multiselectable="true">
        <div class="card">
          <div id="headingOne" role="tab" class="card-header">
            <h6><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Credit Card</a></h6>
          </div>
          <div id="collapseOne" role="tabpanel" aria-labelledby="headingOne" class="collapse show">
            <div class="card-body">


                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="card-name" class="form-label">Name on Card</label>
                    <input type="text" name="card-name" placeholder="Name on card" id="card-name" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="card-number" class="form-label">Card Number</label>
                    <input type="text" name="card-number" placeholder="Card number" id="card-number" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="expiry-date" class="form-label">Expiry Date</label>
                    <input type="text" name="expiry-date" placeholder="MM/YY" id="expiry-date" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="cvv" class="form-label">CVC/CVV</label>
                    <input type="text" name="cvv" placeholder="123" id="cvv" class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="zip" class="form-label">ZIP</label>
                    <input type="text" name="zip" placeholder="123" id="zip" class="form-control">
                  </div>
                </div>


            </div>
          </div>
        </div>
        <div class="card">
          <div id="headingTwo" role="tab" class="card-header">
            <h6><a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="collapsed">Paypal</a></h6>
          </div>
          <div id="collapseTwo" role="tabpanel" aria-labelledby="headingTwo" class="collapse">
            <div class="card-body">
              <input type="radio" name="shippping" id="payment-method-1" class="radio-template">
              <label for="payment-method-1"><strong>Continue with Paypal</strong><br><span class="label-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span></label>
            </div>
          </div>
        </div>
        <div class="card">
          <div id="headingThree" role="tab" class="card-header">
            <h6><a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="collapsed">Pay on delivery</a></h6>
          </div>
          <div id="collapseThree" role="tabpanel" aria-labelledby="headingThree" class="collapse">
            <div class="card-body">
              <input type="radio" name="shippping" id="payment-method-2" class="radio-template">
              <label for="payment-method-2"><strong>Pay on Delivery</strong><br><span class="label-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span></label>
            </div>
          </div>
        </div>
      </div>
      <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
        <a href="{{route('checkout','step2')}}" class="btn btn-template-outlined wide prev"><i class="fa fa-angle-left"></i>Back to delivery method</a>
        <button type="submit" class="btn btn-template wide next">Continue to order review<i class="fa fa-angle-right"></i></button>
      </div>
    </form>
  </div>
</div>
@endsection