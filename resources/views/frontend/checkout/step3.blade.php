@extends('frontend.checkout.layout')
@section('checkout-step')
<div class="tab-content">
  <div id="payment-method" class="tab-block">
    <form action="{{route('checkout.store.step3')}}" method="POST" class="payment-form" id="payment_form">
      @csrf
      <input type="hidden" id="payment_type" name="payment[type]" value="{{$payment_type}}">
      <div id="accordion" role="tablist" aria-multiselectable="true">
        <div class="card">
          <div id="headingOne" role="tab" class="card-header">
            <h6><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Stripe</a></h6>
          </div>
          <div id="collapseOne" role="tabpanel" aria-labelledby="headingOne" class="collapse" data-type="stripe">
            <div class="card-body">
              <div class="row">
                <div class='form-group col-md-6'>
                  <label for="stripe_name" class='form-label'>Name on Card</label> 
                  <input id="stripe_name" class="form-control name @error('stripe.name') is-invalid @enderror " size='4' type='text' name="stripe[name]" value="{{{ (isset($stripe['name'])) ? $stripe['name'] : '' }}}">
                </div>
                <div class='form-group col-md-6'>
                  <label for="stripe_number" class='form-label'>Card Number</label> 
                  <input id="stripe_number" autocomplete='off' class="form-control number mask_input @error('stripe.number') is-invalid @enderror " size='20' type='text' data-inputmask="'mask': '9999 9999 9999 9999'" name="stripe[number]" value="{{{ (isset($stripe['number'])) ? $stripe['number'] : '' }}}">
                </div>
                <div class='form-group col-md-4'>
                  <label for="stripe_cvc" class='form-label'>CVC</label> 
                  <input id="stripe_cvc" autocomplete='off' data-inputmask="'mask': '999'" class="form-control cvc mask_input @error('stripe.cvc') is-invalid @enderror " placeholder='ex. 311' size='4' type='text' name="stripe[cvc]" value="{{{ (isset($stripe['cvc'])) ? $stripe['cvc'] : '' }}}">
                </div>
                <div class='form-group col-md-4'>
                  <label for="stripe_exp_month" class='form-label'>Expiration Month</label> 
                  <input id="stripe_exp_month" class="form-control exp_month mask_input @error('stripe.month') is-invalid @enderror " placeholder='MM' size='2' type='text' data-inputmask="'mask': '99'" name="stripe[month]" value="{{{ (isset($stripe['month'])) ? $stripe['month'] : '' }}}">
                </div>
                <div class='form-group col-md-4'>
                  <label for="stripe_exp_year" class='form-label'>Expiration Year</label> 
                  <input id="stripe_exp_year" class="form-control exp_year mask_input @error('stripe.year') is-invalid @enderror " placeholder='YYYY' size='4' type='text' data-inputmask="'mask': '9999'" name="stripe[year]" value="{{{ (isset($stripe['year'])) ? $stripe['year'] : '' }}}">
                </div>
                <input type="hidden" id="cc_token" name="stripe[token]" value="{{{ (isset($stripe['token'])) ? $stripe['token'] : '' }}}">
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div id="headingThree" role="tab" class="card-header">
            <h6><a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="collapsed">Cash on delivery</a></h6>
          </div>
          <div id="collapseThree" role="tabpanel" aria-labelledby="headingThree" class="collapse" data-type="cash">
            <div class="card-body">
              <strong>Cash on Delivery</strong><br><span class="label-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
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

@push('scripts')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
$(document).ready(function(){
  var $form = $('#payment_form');
  var selected_type = $('#payment_type').val() || 'stripe';

  $('.mask_input').inputmask();

  $form.bind('submit', function(e) {

    if (selected_type === 'stripe') {
      e.preventDefault();
      var inputSelector = ['#stripe_name', '#stripe_number', '#stripe_cvc', '#stripe_exp_month', '#stripe_exp_year'].join(', '),
      $inputs = $form.find(inputSelector),
      token = "{{ env('STRIPE_KEY') }}";

      $('.is-invalid').removeClass('is-invalid');
      $inputs.each(function(i) {
        if ($(this).val() === '') {
          $(this).addClass('is-invalid');
          return;
        }
      });

      Stripe.setPublishableKey(token);
      Stripe.createToken({
        name: $('#stripe_name').val(),
        number: $('#stripe_number').val(),
        cvc: $('#stripe_cvc').val(),
        exp_month: $('#stripe_exp_month').val(),
        exp_year: $('#stripe_exp_year').val()
      }, 
      stripeResponseHandler);
    }
  });
  
  function stripeResponseHandler(status, response) {
    if (response.error) {
      $('input.'+response.error.param).removeClass('is-invalid').addClass('is-invalid');
      toastr.error(response.error.message);
    } else {
      $('#cc_token').val(response.id);
      $form.get(0).submit();
    }
  }

  $(document).on('focus', 'input.is-invalid', function(){
    $(this).removeClass('is-invalid');
  })

  $('.collapse').on('shown.bs.collapse', function () {
    let type = $(this).data('type');
    $( ".collapse[data-type!='"+type+"']" ).collapse('hide');
    selected_type = type;
    $('#payment_type').val(type);
  })

  $( ".collapse[data-type='"+selected_type+"']" ).collapse('show');
})
</script>
@endpush