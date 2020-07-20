  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">

            <div class="basket basket-customer-order">
              <div class="basket-holder">
                <div class="basket-header">
                  <div class="row">
                    <div class="col-6">Product</div>
                    <div class="col-2">Price</div>
                    <div class="col-2">Quantity</div>
                    <div class="col-2 text-right">Total</div>
                  </div>
                </div>
                <div class="basket-body">
                  <!-- Product-->
                  @foreach($order->items as $item)
                  <div class="item">
                    <div class="row d-flex align-items-center">
                      <div class="col-6">
                        <div class="d-flex align-items-center">
                          @if($item->product)
                          @php  $image = $item->product->image; @endphp
                          @if($item->variation && $item->variation->image)
                            @php  $image = $item->variation->image; @endphp
                          @endif

                          @if($image)
                          <img src="{{asset($image)}}" alt="{{$item->product->name}}" class="img-fluid" width="50" height="50">
                          @endif

                          <div class="title">
                            <a href="{{route('product.single', $item->product->slug)}}">
                            <h6>{{$item->product->name}}</h6>
                            @if($item->variation && $item->variation->variation && $item->variation->variation_value)
                              <span class="text-muted">{{$item->variation->variation->name}}: {{$item->variation->variation_value->name}}</span>
                            @endif
                            </a>
                          </div>
                          @endif


                        </div>
                      </div>
                      <div class="col-2"><span>{{Shop::frontendPrice($item->price)}}</span></div>
                      <div class="col-2">{{$item->quantity}}</div>
                      <div class="col-2 text-right"><span>{{Shop::frontendPrice($item->total_price)}}</span></div>
                    </div>
                  </div>
                  @endforeach
                </div>
                <div class="basket-footer">
                  <div class="item">
                    <div class="row">
                      <div class="offset-md-6 col-4"> <strong>Order subtotal</strong></div>
                      <div class="col-2 text-right"><strong>{{Shop::frontendPrice($order->total_price)}}</strong></div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="row">
                      <div class="offset-md-6 col-4"> <strong>Shipping and handling</strong></div>
                      <div class="col-2 text-right"><strong>{{Shop::frontendPrice($order->charge)}}</strong></div>
                    </div>
                  </div>
                  <div class="item">
                    <div class="row">
                      <div class="offset-md-6 col-4"> <strong>Total</strong></div>
                      <div class="col-2 text-right"><strong>{{Shop::frontendPrice($order->grand_total_price)}}</strong></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>