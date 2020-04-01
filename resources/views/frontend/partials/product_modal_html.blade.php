<!-- <div class="ribbon-primary text-uppercase">Sale</div> -->
<div class="row d-flex align-items-center">
  <div class="image col-lg-5">
  @if($product->image)
    <img src="{{asset($product->image)}}" alt="{{$product->name}}" class="img-fluid d-block" id="image_product">
  @endif
  </div>
  <div class="details col-lg-7" id="details" data-max="{{$product->quantity}}" data-price="{{$product->price}}" data-sell="{{$product->sell_price}}" data-img="{{$product->image}}">
    <h2>{{$product->name}}</h2>
    <ul class="price list-inline">
      <li class="list-inline-item current">${{$product->price}}</li>
      <li class="list-inline-item original">$90.00</li>
    </ul>
    <p>{{$product->sort_description}}</p>
    <form action="{{route('addToCart', $product->slug)}}" method="POST">
      @csrf
      <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
        <div class="quantity d-flex align-items-center">
          <div class="dec-btn">-</div>
          <input type="text" value="1" name="quantity" class="quantity-no" id="quantity">
          <div class="inc-btn">+</div>
        </div>
        @foreach($varients as $k => $varientcollection)
        <select id="varient-{{$k}}" name="varient" class="bs-select variation_select">
          <option value="" data-price="{{$product->price}}" data-sell_price="{{$product->sell_price}}" data-quantity="{{$product->quantity}}" data-img="{{$product->image}}">Select {{ App\Variation::find($k)->name }}</option>
          @foreach($varientcollection as $varient)
          <option value="{{$varient->id}}" data-price="{{$varient->pivot->price}}" data-sell_price="{{$varient->pivot->sell_price}}" data-quantity="{{$varient->pivot->quantity}}" data-img="{{$varient->pivot->image}}" >{{$varient->name}}</option>
          @endforeach
        </select>
        @endforeach
      </div>
      <ul class="CTAs list-inline">
        <li class="list-inline-item">
          <button type="submit" class="btn btn-template wide"><i class="icon-cart"></i>Add to Cart</button>
        </li>
      </ul>
    </form>
  </div>
</div>