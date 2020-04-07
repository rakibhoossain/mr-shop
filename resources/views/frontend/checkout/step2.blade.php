@extends('frontend.checkout.layout')
@section('checkout-step')
<div class="tab-content">
  <div id="delivery-method" class="tab-block">
    <form action="{{route('checkout.store.step2')}}" method="POST" class="shipping-form" id="shipping_form">
      @csrf
      <div class="row">
        @foreach(App\ShippingMethod::orderBy('price')->get() as $ship_item)
        <div class="form-group col-md-6">
          <input type="radio" name="shippping_method" id="shipping_method_{{$loop->index}}" class="radio-template"
           value="{{$ship_item->id}}" {{{ (isset($shippping_method['id']) && $shippping_method['id'] == $ship_item->id ) ? 'checked' : '' }}} >
          <label for="shipping_method_{{$loop->index}}">
            <strong>{{$ship_item->name}} {{{ ($ship_item->shipping_charge>0)? '('.Helper::frontendPrice($ship_item->shipping_charge).')' : ''}}}</strong>
            <br><span class="label-description">{{$ship_item->description}}</span>
          </label>
        </div>        
        @endforeach
      </div>
      <div class="CTAs d-flex justify-content-between flex-column flex-lg-row">
        <a href="{{route('checkout')}}" class="btn btn-template-outlined wide prev"><i class="fa fa-angle-left"></i>Back to Address</a>
        <button type="submit" class="btn btn-template wide next">Choose payment method<i class="fa fa-angle-right"></i></button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
  var $form = $('#shipping_form');

  $form.bind('submit', function(e) {
    e.preventDefault();
    if($("input[name='shippping_method']:checked").length){
      $form.get(0).submit();
    }else{
      toastr.error('Please select a delivary method!');
    }
  });

})
</script>
@endpush