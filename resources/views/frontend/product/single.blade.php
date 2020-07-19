@extends('layouts/frontend')
@section('title', $product->name)
@section('content')
    <!-- Hero Section-->
    <section class="hero hero-page gray-bg padding-small">
      <div class="container">
        <div class="row d-flex">
          <div class="col-lg-9 order-2 order-lg-1">
            <h1>{{$product->name}}</h1>
          </div>
          <div class="col-lg-3 text-right order-1 order-lg-2">
            <ul class="breadcrumb justify-content-lg-end">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('shop')}}">Shop</a></li>
              <li class="breadcrumb-item active">{{$product->name}}</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <section class="product-details">
      <div class="container">
        <div class="row">
          <div class="product-images col-lg-6">
            <div class="ribbon-info text-uppercase">Fresh</div>
            <div class="ribbon-primary text-uppercase">Sale</div>
            <div data-slider-id="1" class="owl-carousel items-slider owl-drag">
              @foreach($product->images as $image)
              <div class="item"><img src="{{asset($image->image)}}" alt="{{$product->name}}"></div>
              @endforeach
              
              @foreach($varients as $k => $varientcollection)
                @foreach($varientcollection as $varient)
                  @if($varient->pivot->image) <div class="item"><img src="{{asset($varient->pivot->image)}}" alt="{{$product->name}}"></div> @endif
                @endforeach
              @endforeach
            </div>
            <div data-slider-id="1" class="owl-thumbs">
              @foreach($product->images as $image)
              <button class="owl-thumb-item init-thumb-{{$loop->index}}"><img src="{{asset($image->image)}}" alt="{{$product->name}}"></button>
              @endforeach

              @foreach($varients as $k => $varientcollection)
                @foreach($varientcollection as $varient)
                  @if($varient->pivot->image) <button class="owl-thumb-item thumb-varient-{{$varient->id}}"><img src="{{asset($varient->pivot->image)}}" alt="{{$product->name}}"></button> @endif
                @endforeach
              @endforeach
            </div>
          </div>
          <div id="details" class="details col-lg-6" data-max="{{$product->quantity}}" data-price="{{$product->price}}" data-sell="{{$product->sell_price}}">
            <div class="d-flex align-items-center justify-content-between flex-column flex-sm-row">
              <ul class="price list-inline no-margin">
                <li class="list-inline-item current">{{Shop::frontendItemPrice($product, 'current')}}</li>
                <li class="list-inline-item original">{{Shop::frontendItemPrice($product, 'original')}}</li>
              </ul>
              <div class="review d-flex align-items-center">
                <ul class="rate list-inline">
                  <li class="list-inline-item"><i class="fa fa-star text-primary"></i></li>
                  <li class="list-inline-item"><i class="fa fa-star text-primary"></i></li>
                  <li class="list-inline-item"><i class="fa fa-star text-primary"></i></li>
                  <li class="list-inline-item"><i class="fa fa-star text-primary"></i></li>
                  <li class="list-inline-item"><i class="fa fa-star-o text-primary"></i></li>
                </ul><span class="text-muted">5 reviews</span>
              </div>
            </div>
            @if($product->brand)
            <div class="d-flex flex-column flex-sm-row">
              <b>Brand:</b> <span class="ml-1">{{$product->brand->name}}</span>
            </div>
            @endif
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
                  <option value="" data-price="{{$product->price}}" data-sell_price="{{$product->sell_price}}" data-quantity="{{$product->quantity}}">Select {{ App\Variation::find($k)->name }}</option>
                  @foreach($varientcollection as $varient)
                  <option value="{{$varient->id}}" data-price="{{$varient->pivot->price}}" data-sell_price="{{$varient->pivot->sell_price}}" data-quantity="{{$varient->pivot->quantity}}">{{$varient->name}}</option>
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
      </div>
    </section>
    <section class="product-description no-padding">
      <div class="container">
        <ul role="tablist" class="nav nav-tabs flex-column flex-sm-row">
          <li class="nav-item"><a data-toggle="tab" href="#description" role="tab" class="nav-link active">Description</a></li>
          @if($product->meta)
          <li class="nav-item"><a data-toggle="tab" href="#additional-information" role="tab" class="nav-link">Additional Information</a></li>
          @endif
          <li class="nav-item"><a data-toggle="tab" href="#reviews" role="tab" class="nav-link">Reviews</a></li>
        </ul>
        <div class="tab-content">
          <div id="description" role="tabpanel" class="tab-pane active">
            {!!$product->description!!}
          </div>
          @if($product->meta)
          <div id="additional-information" role="tabpanel" class="tab-pane">
            <table class="table">
              <tbody>
                @foreach(json_decode($product->meta)->data as $data) 
                <tr>
                  <th @if($loop->index == 0) class="border-0" @endif>{{$data->key}}:</th>
                  <td @if($loop->index == 0) class="border-0" @endif>{{$data->value}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endif
          <div id="reviews" role="tabpanel" class="tab-pane">
            <div class="row">
              <div class="col-xl-9">
                <div class="row review">
                  <div class="col-3 text-center"><img src="../../../d19m59y37dris4.cloudfront.net/hub/1-4-3/img/person-1.jpg" alt="Han Solo" class="review-image"><span class="text-uppercase text-muted text-small">Dec 2018</span></div>
                  <div class="col-9 review-text">
                    <h6>Han Solo</h6>
                    <div class="mb-2"><i class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i>
                    </div>
                    <p class="text-muted text-small">One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections</p>
                  </div>
                </div>
                <div class="row review">
                  <div class="col-3 text-center"><img src="../../../d19m59y37dris4.cloudfront.net/hub/1-4-3/img/person-2.jpg" alt="Luke Skywalker" class="review-image"><span class="text-uppercase text-muted text-small">Dec 2018</span></div>
                  <div class="col-9 review-text">
                    <h6>Luke Skywalker</h6>
                    <div class="mb-2"><i class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i class="fa fa-star-o text-primary"></i>
                    </div>
                    <p class="text-muted text-small">The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked. &quot;What's happened to me?&quot; he thought. It wasn't a dream.</p>
                  </div>
                </div>
                <div class="row review">
                  <div class="col-3 text-center"><img src="../../../d19m59y37dris4.cloudfront.net/hub/1-4-3/img/person-3.jpg" alt="Princess Leia" class="review-image"><span class="text-uppercase text-muted text-small">Dec 2018</span></div>
                  <div class="col-9 review-text">
                    <h6>Princess Leia</h6>
                    <div class="mb-2"><i class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i class="fa fa-star-o text-primary"></i><i class="fa fa-star-o text-primary"></i>
                    </div>
                    <p class="text-muted text-small">His room, a proper human room although a little too small, lay peacefully between its four familiar walls. A collection of textile samples lay spread out on the table.</p>
                  </div>
                </div>
                <div class="row review">
                  <div class="col-3 text-center"><img src="../../../d19m59y37dris4.cloudfront.net/hub/1-4-3/img/person-4.jpg" alt="Jabba Hut" class="review-image"><span class="text-uppercase text-muted text-small">Dec 2018</span></div>
                  <div class="col-9 review-text">
                    <h6>Jabba Hut</h6>
                    <div class="mb-2"><i class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i><i class="fa fa-star text-primary"></i>
                    </div>
                    <p class="text-muted text-small">Samsa was a travelling salesman - and above it there hung a picture that he had recently cut out of an illustrated magazine and housed in a nice, gilded frame.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="share-product gray-bg d-flex align-items-center justify-content-center flex-column flex-md-row"><strong class="text-uppercase">Share this on</strong>
          <ul class="list-inline text-center">
            <li class="list-inline-item"><a href="#" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a></li>
            <li class="list-inline-item"><a href="#" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a></li>
            <li class="list-inline-item"><a href="#" target="_blank" title="instagram"><i class="fa fa-instagram"></i></a></li>
            <li class="list-inline-item"><a href="#" target="_blank" title="pinterest"><i class="fa fa-pinterest"></i></a></li>
            <li class="list-inline-item"><a href="#" target="_blank" title="vimeo"><i class="fa fa-vimeo"></i></a></li>
          </ul>
        </div>
      </div>
    </section>

    @if(count($relatedProducts))
    <section class="related-products">
      <div class="container">
        <header class="text-center">
          <h2><small>Similar Items</small>You may also like</h2>
        </header>
        <div class="row">
          @foreach($relatedProducts as $product)
          <div class="item col-lg-3">
            <div class="product is-gray">
              <div class="image d-flex align-items-center justify-content-center">
                @if($product->image)
                  <img src="{{asset($product->image)}}" alt="{{$product->name}}" class="img-fluid">
                @endif
                <div class="hover-overlay d-flex align-items-center justify-content-center">
                  <div class="CTA d-flex align-items-center justify-content-center">
                    @if(!$product->is_variable)
                    <a href="{{route('addToCart', $product->slug)}}" class="add-to-cart"><i class="fa fa-shopping-cart"></i></a>
                    @endif
                    <a href="{{route('product.single', $product->slug)}}" class="visit-product active"><i class="icon-search"></i>View</a>
                    <a href="#" data-url="{{route('product.single', $product->slug)}}" class="quick-view product_popup"><i class="fa fa-arrows-alt"></i></a>
                  </div>
                </div>
              </div>
              <div class="title"><a href="{{route('product.single', $product->slug)}}">
                <h3 class="h6 text-uppercase no-margin-bottom">{{$product->name}}</h3></a><span class="price">{{Shop::frontendItemPrice($product, 'current')}} @if($product->sell_price) <del>{{Shop::frontendItemPrice($product, 'original')}}@endif</del></span></div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif
@endsection