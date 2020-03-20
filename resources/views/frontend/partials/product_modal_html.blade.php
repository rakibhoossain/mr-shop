<!-- <div class="ribbon-primary text-uppercase">Sale</div> -->
<div class="row d-flex align-items-center">
  <div class="image col-lg-5">
  @if($product->image)
    <img src="{{asset($product->image)}}" alt="{{$product->name}}" class="img-fluid d-block">
  @endif
  </div>
  <div class="details col-lg-7">
    <h2>{{$product->name}}</h2>
    <ul class="price list-inline">
      <li class="list-inline-item current">${{$product->price}}</li>
      <li class="list-inline-item original">$90.00</li>
    </ul>
    <p>{{$product->sort_description}}</p>
    <div class="d-flex align-items-center">
      <div class="quantity d-flex align-items-center">
        <div class="dec-btn">-</div>
        <input type="text" value="1" class="quantity-no">
        <div class="inc-btn">+</div>
      </div>

      @if(count($product->sizes))
      <select id="size" class="bs-select">
        @foreach($product->sizes as $size)
        <option value="{{$size->id}}">{{$size->name}}</option>
        @endforeach
      </select>
      @endif
    </div>
    <ul class="CTAs list-inline">
      <li class="list-inline-item"><a href="#" class="btn btn-template wide"> <i class="fa fa-shopping-cart"></i>Add to Cart</a></li>
      <li class="list-inline-item"><a href="#" class="visit-product active btn btn-template-outlined wide"> <i class="icon-heart"></i>Add to wishlist</a></li>
    </ul>
  </div>
</div>