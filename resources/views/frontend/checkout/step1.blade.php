@extends('frontend.checkout.layout')
@section('checkout-step')
<div class="tab-content">
  <div id="address" class="active tab-block">
    <form action="{{route('checkout.store.step1')}}" method="POST">
      @csrf
      <!-- Invoice Address-->
      <div class="block-header mb-5">
        <h6>Invoice address</h6>
      </div>
      <div class="row">
        <div class="form-group col-md-6">
          <label for="firstname" class="form-label">First Name<span class="text-danger" title="This field is required">*</span></label>
          <input id="firstname" type="text" name="invoice[first_name]" placeholder="Enter you first name" class="form-control @error('invoice.first_name') is-invalid @enderror " value="{{{ (isset($invoice['first_name'])) ? $invoice['first_name'] : old('invoice.first_name') }}}">
        </div>
        <div class="form-group col-md-6">
          <label for="lastname" class="form-label">Last Name<span class="text-danger" title="This field is required">*</span></label>
          <input id="lastname" type="text" name="invoice[last_name]" placeholder="Enter your last name" class="form-control @error('invoice.last_name') is-invalid @enderror " value="{{{ (isset($invoice['last_name'])) ? $invoice['last_name'] : old('invoice.last_name') }}}">
        </div>
        <div class="form-group col-md-6">
          <label for="phone-number" class="form-label">Phone Number<span class="text-danger" title="This field is required">*</span></label>
          <input id="phone-number" type="tel" name="invoice[phone_number]" placeholder="Your phone number" class="form-control @error('invoice.phone_number') is-invalid @enderror " value="{{{ (isset($invoice['phone_number'])) ? $invoice['phone_number'] : old('invoice.phone_number') }}}">
        </div>
        <div class="form-group col-md-6">
          <label for="alternative-phone-number" class="form-label">Alternative Phone Number</label>
          <input id="alternative-phone-number" type="tel" name="invoice[alternative_number]" placeholder="Your alternative phone number" class="form-control @error('invoice.alternative_number') is-invalid @enderror " value="{{{ (isset($invoice['alternative_number'])) ? $invoice['alternative_number'] : old('invoice.alternative_number') }}}">
        </div>
        <div class="form-group col-md-4">
          <label for="country" class="form-label">Country<span class="text-danger" title="This field is required">*</span></label>
          <input id="country" type="text" name="invoice[country]" placeholder="Your country" class="form-control @error('invoice.country') is-invalid @enderror " value="{{{ (isset($invoice['country'])) ? $invoice['country'] : old('invoice.country', 'Bangladesh') }}}">
        </div>
        <div class="form-group col-md-4">
          <label for="city" class="form-label">City<span class="text-danger" title="This field is required">*</span></label>
          <input id="city" type="text" name="invoice[city]" placeholder="Your city" class="form-control @error('invoice.city') is-invalid @enderror " value="{{{ (isset($invoice['city'])) ? $invoice['city'] : old('invoice.city') }}}">
        </div>
        <div class="form-group col-md-4">
          <label for="post_code" class="form-label">Post code<span class="text-danger" title="This field is required">*</span></label>
          <input id="post_code" type="text" name="invoice[post_code]" placeholder="Your post code" class="form-control @error('invoice.post_code') is-invalid @enderror " value="{{{ (isset($invoice['post_code'])) ? $invoice['post_code'] : old('invoice.post_code') }}}">
        </div>
        <div class="form-group col-md-12">
          <label for="invoice_address" class="form-label">Address<span class="text-danger" title="This field is required">*</span></label>
          <textarea id="invoice_address" placeholder="Your Address" class="form-control @error('invoice.address') is-invalid @enderror " name="invoice[address]" >{{{ (isset($invoice['address'])) ? $invoice['address'] : old('invoice.address') }}}</textarea>
        </div>

        <div class="form-group col-12 mt-3 ml-3">
          <input id="another-address" type="checkbox" class="checkbox-template" name="invoice[another]" value="1" @error('shipping.*') checked @enderror @if(isset($invoice['another'])) checked @endif  >
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
            <label for="shipping_firstname" class="form-label">First Name<span class="text-danger" title="This field is required">*</span></label>
            <input id="shipping_firstname" type="text" name="shipping[first_name]" placeholder="Enter you first name" class="form-control @error('shipping.first_name') is-invalid @enderror " value="{{{ (isset($shipping['first_name'])) ? $shipping['first_name'] : old('shipping.first_name') }}}">
          </div>
          <div class="form-group col-md-6">
            <label for="shipping_lastname" class="form-label">Last Name<span class="text-danger" title="This field is required">*</span></label>
            <input id="shipping_lastname" type="text" name="shipping[last_name]" placeholder="Enter your last name" class="form-control @error('shipping.last_name') is-invalid @enderror " value="{{{ (isset($shipping['last_name'])) ? $shipping['last_name'] : old('shipping.last_name') }}}">
          </div>
          <div class="form-group col-md-6">
            <label for="shipping_phone-number" class="form-label">Phone Number<span class="text-danger" title="This field is required">*</span></label>
            <input id="shipping_phone-number" type="tel" name="shipping[phone_number]" placeholder="Your phone number" class="form-control @error('shipping.phone_number') is-invalid @enderror " value="{{{ (isset($shipping['phone_number'])) ? $shipping['phone_number'] : old('shipping.phone_number') }}}">
          </div>

          <div class="form-group col-md-6">
            <label for="shipping_alternative-number" class="form-label">Alternative Phone Number</label>
            <input id="shipping_alternative-number" type="tel" name="shipping[alternative_number]" placeholder="Your alternative phone number" class="form-control @error('shipping.alternative_number') is-invalid @enderror " value="{{{ (isset($shipping['alternative_number'])) ? $shipping['alternative_number'] : old('shipping.alternative_number') }}}">
          </div>
          <div class="form-group col-md-4">
            <label for="shipping_country" class="form-label">Country<span class="text-danger" title="This field is required">*</span></label>
            <input id="shipping_country" type="text" name="shipping[country]" placeholder="Your country" class="form-control @error('shipping.country') is-invalid @enderror " value="Bangladesh" value="{{{ (isset($shipping['country'])) ? $shipping['country'] : old('shipping.country', 'Bangladesh') }}}">
          </div>
          <div class="form-group col-md-4">
            <label for="shipping_city" class="form-label">City<span class="text-danger" title="This field is required">*</span></label>
            <input id="shipping_city" type="text" name="shipping[city]" placeholder="Your city" class="form-control @error('shipping.city') is-invalid @enderror " value="{{{ (isset($shipping['city'])) ? $shipping['city'] : old('shipping.city') }}}">
          </div>
          <div class="form-group col-md-4">
            <label for="shipping_post_code" class="form-label">Post code<span class="text-danger" title="This field is required">*</span></label>
            <input id="shipping_post_code" type="text" name="shipping[post_code]" placeholder="Your post code" class="form-control @error('shipping.post_code') is-invalid @enderror " value="{{{ (isset($shipping['post_code'])) ? $shipping['post_code'] : old('shipping.post_code') }}}">
          </div>
          <div class="form-group col-md-12">
            <label for="shipping_address" class="form-label">Address<span class="text-danger" title="This field is required">*</span></label>
            <textarea id="shipping_address" placeholder="Your Address" class="form-control @error('shipping.address') is-invalid @enderror " name="shipping[address]" >{{{ (isset($shipping['address'])) ? $shipping['address'] : old('shipping.address') }}}</textarea>
          </div>
        </div>
      </div>
      <!-- /Shipping Address-->
      <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
        <a href="{{route('cart')}}" class="btn btn-template-outlined wide prev"><i class="fa fa-angle-left"></i>Back to basket</a>
        <button type="submit" class="btn btn-template wide next">Choose delivery method<i class="fa fa-angle-right"></i></button>
      </div>
    </form>
  </div>
</div>

@endsection
@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
  if($('#another-address').is(':checked')) $('#shippingAddress').removeClass('show').addClass('show');
})
</script>

@endpush