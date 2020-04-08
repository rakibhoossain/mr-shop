@extends('layouts/frontend')
@section('title', 'Checkout')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('css/smart_wizard.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/smart_wizard_theme_arrows.min.css')}}">
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
    <!-- Shopping Checkout Section-->
    <section class="checkout">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
<div id="smartwizard">
    <ul>
        <li><a href="#step-1">Address</a></li>
        <li><a href="#step-2">Delivery Method</a></li>
        <li><a href="#step-3">Payment Method</a></li>
        <li><a href="#step-4">Order Review</a></li>
    </ul>
 
    <div>
        <div id="step-1" class="">
            Step Content
        </div>
        <div id="step-2" class="">
            Step Content
        </div>
        <div id="step-3" class="">
            Step Content
        </div>
        <div id="step-4" class="">
            Step Content
        </div>
    </div>
</div>

















            
            <ul class="nav nav-pills">
              <li class="nav-item"><a href="checkout1.html" class="nav-link active">Address</a></li>
              <li class="nav-item"><a href="#" class="nav-link disabled">Delivery Method </a></li>
              <li class="nav-item"><a href="#" class="nav-link disabled">Payment Method </a></li>
              <li class="nav-item"><a href="#" class="nav-link disabled">Order Review</a></li>
            </ul>
            <div class="tab-content">











              <div id="address" class="active tab-block">
                <form action="#">
                  <!-- Invoice Address-->
                  <div class="block-header mb-5">
                    <h6>Invoice address</h6>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="firstname" class="form-label">First Name</label>
                      <input id="firstname" type="text" name="first-name" placeholder="Enter you first name" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="lastname" class="form-label">Last Name</label>
                      <input id="lastname" type="text" name="last-name" placeholder="Enter your last name" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="email" class="form-label">Email Address</label>
                      <input id="email" type="email" name="email" placeholder="enter your email address" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="street" class="form-label">Street</label>
                      <input id="street" type="text" name="address" placeholder="Your street name" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="city" class="form-label">City</label>
                      <input id="city" type="text" name="city" placeholder="Your city" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="zip" class="form-label">ZIP</label>
                      <input id="zip" type="text" name="zip" placeholder="ZIP code" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="state" class="form-label">State</label>
                      <input id="state" type="text" name="state" placeholder="Your state" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                      <label for="country" class="form-label">Country</label>
                      <input id="country" type="text" name="country" placeholder="Your country" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="phone-number" class="form-label">Phone Number</label>
                      <input id="phone-number" type="tel" name="phone-number" placeholder="Your phone number" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="company" class="form-label">Company</label>
                      <input id="company" type="text" name="company" placeholder="Your company name" class="form-control">
                    </div>
                    <div class="form-group col-12 mt-3 ml-3">
                      <input id="another-address" type="checkbox" class="checkbox-template">
                      <label for="another-address" data-toggle="collapse" data-target="#shippingAddress" aria-expanded="false" aria-controls="shippingAddress">Use different shipping address</label>
                    </div>
                  </div>
                  <!-- /Invoice Address-->
                  <!-- Shippping Address-->
                  <div id="shippingAddress" aria-expanded="false" class="collapse">
                    <div class="block-header mb-5 mt-3">
                      <h6>Shipping address</h6>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="shipping_firstname" class="form-label">First Name</label>
                        <input id="shipping_firstname" type="text" name="shipping_first-name" placeholder="Enter you first name" class="form-control">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="shipping_lastname" class="form-label">Last Name</label>
                        <input id="lshipping_astname" type="text" name="shipping_last-name" placeholder="Enter your last name" class="form-control">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="shipping_email" class="form-label">Email Address</label>
                        <input id="shipping_email" type="email" name="shipping_email" placeholder="enter your email address" class="form-control">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="shipping_street" class="form-label">Street</label>
                        <input id="shipping_street" type="text" name="shipping_address" placeholder="Your street name" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="shipping_city" class="form-label">City</label>
                        <input id="shipping_city" type="text" name="shipping_city" placeholder="Your city" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="shipping_zip" class="form-label">ZIP</label>
                        <input id="shipping_zip" type="text" name="shipping_zip" placeholder="ZIP code" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="shipping_state" class="form-label">State</label>
                        <input id="shipping_state" type="text" name="shipping_state" placeholder="Your state" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="shipping_country" class="form-label">Country</label>
                        <input id="shipping_country" type="text" name="shipping_country" placeholder="Your country" class="form-control">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="shipping_phone-number" class="form-label">Phone Number</label>
                        <input id="shipping_phone-number" type="tel" name="shipping_phone-number" placeholder="Your phone number" class="form-control">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="shipping_company" class="form-label">Company</label>
                        <input id="shipping_company" type="text" name="shipping_company" placeholder="Your company name" class="form-control">
                      </div>
                    </div>
                  </div>
                  <!-- /Shipping Address-->
                  <div class="CTAs d-flex justify-content-between flex-column flex-lg-row"><a href="cart.html" class="btn btn-template-outlined wide prev"> <i class="fa fa-angle-left"></i>Back to basket</a><a href="checkout2.html" class="btn btn-template wide next">Choose delivery method<i class="fa fa-angle-right"></i></a></div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="block-body order-summary">
              <h6 class="text-uppercase">Order Summary</h6>
              <p>Shipping and additional costs are calculated based on values you have entered</p>
              <ul class="order-menu list-unstyled">
                <li class="d-flex justify-content-between"><span>Order Subtotal </span><strong>$390.00</strong></li>
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

@push('scripts')
<script type="text/javascript" src="{{asset('js/jquery.smartWizard.min.js')}}"></script>

<script type="text/javascript">
 $(document).ready(function(){

          // Step show event
          $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
             //alert("You are on step "+stepNumber+" now");
             // if(stepPosition === 'first'){
             //     $("#prev-btn").addClass('disabled');
             // }else if(stepPosition === 'final'){
             //     $("#next-btn").addClass('disabled');
             // }else{
             //     $("#prev-btn").removeClass('disabled');
             //     $("#next-btn").removeClass('disabled');
             // }

console.log(stepNumber);
console.log(anchorObject);

          });

          // Toolbar extra buttons
          // var btnFinish = $('<button></button>').text('Finish')
          //                                  .addClass('btn btn-info')
          //                                  .on('click', function(){ alert('Finish Clicked'); });
          // var btnCancel = $('<button></button>').text('Cancel')
          //                                  .addClass('btn btn-danger')
          //                                  .on('click', function(){ $('#smartwizard').smartWizard("reset"); });


          // Smart Wizard
          $('#smartwizard').smartWizard({
                  selected: 0,
                  theme: 'arrows',
                  transitionEffect:'fade',
                  showStepURLhash: false,
                  toolbarSettings: {toolbarPosition: 'end',
                                    toolbarButtonPosition: 'end',
                                    // toolbarExtraButtons: [btnFinish, btnCancel]
                                  }
          });


          // // External Button Events
          // $("#reset-btn").on("click", function(e) {
          //     // Reset wizard
          //     $('#smartwizard').smartWizard("reset");
          // });

          // $("#prev-btn").on("click", function() {
          //     // Navigate previous
          //     $('#smartwizard').smartWizard("prev");
          // });

          // $("#next-btn").on("click", function() {
          //     // Navigate next
          //     $('#smartwizard').smartWizard("next");
          // });

          // $("#theme_selector").on("change", function() {
          //     // Change theme
          //     $('#smartwizard').smartWizard("theme", $(this).val());
          // });

          // // Set selected theme on page refresh
          // $("#theme_selector").change();
      });
</script>

@endpush