@extends('layouts/frontend')
@section('title', 'Shop')
@section('content')
    <!-- Hero Section-->
    <section class="hero hero-page gray-bg padding-small">
      <div class="container">
        <div class="row d-flex">
          <div class="col-lg-9 order-2 order-lg-1">
            <h1>Shop</h1><p class="lead text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
          </div>
          <div class="col-lg-3 text-right order-1 order-lg-2">
            <ul class="breadcrumb justify-content-lg-end">
              <li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
              <li class="breadcrumb-item active">Shop</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <main>
      <form method="POST" action="{{route('shop.filter')}}">
      {{csrf_field()}}
      <div class="container">
        <div class="row">
          <!-- Sidebar-->
          <div class="sidebar col-xl-3 col-lg-4 sidebar">
            <div class="block">
              <h6 class="text-uppercase">Product Categories</h6>
              <ul class="list-unstyled">
                @foreach(App\ProductCategory::whereNull('product_category_id')->has('products')->select('name')->withCount('products')->latest()->get() as $category)


                <li @if($loop->index == 0) class="active" @endif >
                  <a href="#" class="d-flex justify-content-between align-items-center"><span>{{$category->name}}</span><small>{{$category->products_count}}</small></a>
                  @if(count($category->children))
                  <ul class="list-unstyled">
                    @foreach($category->children()->has('products')->select('name')->withCount('products')->get() as $child_category)
                    <li> <a href="#" class="d-flex justify-content-between align-items-center"><span>{{$child_category->name}}</span><small>{{$child_category->products_count}}</small></a></li>
                    @endforeach
                  </ul>
                  @endif
                </li>



                @endforeach
              </ul>
            </div>
            <div class="block">
              <h6 class="text-uppercase">Filter By Price  </h6>
              <div id="slider-snap" data-min="{{Shop::productMinPrice()}}" data-max="{{Shop::productMaxPrice()}}" data-start="@if(!empty($_GET['price'])){{$_GET['price']}}@endif"></div>
              <div class="value d-flex justify-content-between">
                <div class="min">From <span id="slider-snap-value-lower" class="example-val"></span>{!!Shop::currency()!!}</div>
                <div class="max">To <span id="slider-snap-value-upper" class="example-val"></span>{!!Shop::currency()!!}</div>
              </div>
              <input type="hidden" name="price_range" id="range_price" value="@if(!empty($_GET['price'])){{$_GET['price']}}@endif">
              <button type="submit" class="filter-submit">Filter</button>
            </div>
            <div class="block">
              <h6 class="text-uppercase">Brands </h6>

                @if(!empty($_GET['brand'])) @php $filter_brands = explode(',', $_GET['brand']); @endphp @endif
                @foreach($brands as $brand)
                <div class="form-group mb-1">
                  <input id="brand{{$loop->index}}" type="checkbox" name="brand[]" @if(!empty($filter_brands) && in_array($brand->slug, $filter_brands)) checked @endif onchange="this.form.submit();" value="{{$brand->slug}}" class="checkbox-template">
                  <label for="brand{{$loop->index}}">{{$brand->name}} <small>({{$brand->products_count}})</small></label>
                </div>
                @endforeach
              
            </div>

             @if(!empty($_GET['varient'])) @php $filter_varient = explode(',', $_GET['varient']); @endphp @endif
            @foreach(App\Variation::has('variation_values')->select('id', 'name')->get() as $variation)
            <div class="block"> 
              <h6 class="text-uppercase">{{$variation->name}}</h6>
              @foreach($variation->values()->has('products')->select('id', 'name')->withCount('products')->get() as $value)
              <div class="form-group mb-1">
                <input id="{{$value->name}}{{$loop->index}}" type="checkbox" name="varient[]" value="{{$value->id}}" @if(!empty($filter_varient) && in_array($value->id, $filter_varient)) checked @endif onchange="this.form.submit();" class="checkbox-template">
                <label for="{{$value->name}}{{$loop->index}}">{{$value->name}} <small>({{$value->products_count}})</small></label>
              </div>
              @endforeach
            </div>
            @endforeach
          </div>
          <!-- /Sidebar end-->
          <!-- Grid -->
          <div class="products-grid col-xl-9 col-lg-8 sidebar-left">
            <header class="d-flex justify-content-between align-items-start"><span class="visible-items">Showing <strong>{{ $products->firstItem() }}-{{ $products->lastItem() }} </strong>of <strong>{{ $products->total() }} </strong>results</span>
              <select id="sorting" class="bs-select" name="sortBy" onchange="this.form.submit();">
                <option value="newest" @if( !empty($_GET['sortBy']) && $_GET['sortBy'] =='newest' ) selected @endif >Newest</option>
                <option value="oldest" @if( !empty($_GET['sortBy']) && $_GET['sortBy'] =='oldest' ) selected @endif >Oldest</option>
                <option value="lowest-price" @if( !empty($_GET['sortBy']) && $_GET['sortBy'] =='lowest-price' ) selected @endif >Low Price</option>
                <option value="heigh-price" @if( !empty($_GET['sortBy']) && $_GET['sortBy'] =='heigh-price' ) selected @endif >High Price</option>
              </select>
            </header>
            <div class="row">
              <!-- item-->

              @foreach($products as $product)
              <div class="item col-xl-4 col-md-6">
                <div class="product is-gray">
                  <div class="image d-flex align-items-center justify-content-center">
                    <div class="ribbon ribbon-success text-uppercase">New</div>
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
                  <div class="title"><small class="text-muted">{{$product->categories->implode('name', ',')}}</small>
                    <a href="{{route('product.single', $product->slug)}}"><h3 class="h6 text-uppercase no-margin-bottom">{{$product->name}}</h3></a><span class="price text-muted">{{Shop::frontendItemPrice($product, 'current')}} @if($product->sell_price) <del>{{Shop::frontendItemPrice($product, 'original')}}@endif</del></span>
                  </div>
                </div>
              </div>
              @endforeach


            </div>
            <nav aria-label="page navigation example" class="d-flex justify-content-center">
              {!!$products->appends($_GET)->links()!!}



<!--               <ul class="pagination pagination-custom">
                <li class="page-item"><a href="#" aria-label="Previous" class="page-link"><span aria-hidden="true">Prev</span><span class="sr-only">Previous</span></a></li>
                <li class="page-item"><a href="#" class="page-link active">1       </a></li>
                <li class="page-item"><a href="#" class="page-link">2       </a></li>
                <li class="page-item"><a href="#" class="page-link">3       </a></li>
                <li class="page-item"><a href="#" class="page-link">4       </a></li>
                <li class="page-item"><a href="#" class="page-link">5 </a></li>
                <li class="page-item"><a href="#" aria-label="Next" class="page-link"><span aria-hidden="true">Next</span><span class="sr-only">Next     </span></a></li>
              </ul> -->
            </nav>
          </div>
          <!-- / Grid End-->
        </div>
      </div>
      </form>
    </main>
@endsection
@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
  let min = parseInt($('#slider-snap').data('min')) || 0;
  let max = parseInt($('#slider-snap').data('max')) || 0;

  let get_start = $('#slider-snap').data('start');

  let st, se;
  if(get_start){
    let temp = get_start.split("-");
    st = temp[0];
    se = temp[1];
  }else{
    st = min;
    se = max;
  }

  var snapSlider = document.getElementById('slider-snap');
  
  noUiSlider.create(snapSlider, {
    start: [ st , se ],
    snap: false,
    connect: true,
      step: 1,
    range: {
      'min': min,
      'max': max
    }
  });
  var snapValues = [
    document.getElementById('slider-snap-value-lower'),
    document.getElementById('slider-snap-value-upper')
  ];
  snapSlider.noUiSlider.on('update', function( values, handle ) {
    $("#range_price").val(values[0] + "-" + values[1]);
    console.log(values);
    snapValues[handle].innerHTML = values[handle];
  });
})

</script>
@endpush