@extends('layouts/frontend')
@section('title', 'Order details')
@section('content')
    <!-- Hero Section-->
    <section class="hero hero-page gray-bg padding-small">
      <div class="container">
        <div class="row d-flex">
          <div class="col-lg-9 order-2 order-lg-1">
            <h1>Order #{{$order->code}}</h1><p class="lead">Order #{{$order->code}} was placed on <strong>{{date('d/m/Y', strtotime($order->created_at))}}</strong> and is currently <strong>{{strtoupper($order->status)}}</strong>.</p><p class="text-muted">If you have any questions, please feel free to <a href="{{route('contact')}}">contact us</a>, our customer service center is working for you 24/7.</p>
          </div>
          <div class="col-lg-3 text-right order-1 order-lg-2">
            <ul class="breadcrumb justify-content-lg-end">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('orders', auth()->user()->id)}}">Orders</a></li>
              <li class="breadcrumb-item active">Order #{{$order->code}}</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <section class="padding-small">
      <div class="container">
        <div class="row">
          <!-- Customer Sidebar-->
          <div class="customer-sidebar col-xl-3 col-lg-4 mb-md-5">
            @include('frontend.account.profile')
          </div>
          <div class="col-lg-8 col-xl-9 pl-lg-3">
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

                          @php  $image = $item->product->image; @endphp
                          @if($item->variation && $item->variation->image)
                            @php  $image = $item->variation->image; @endphp
                          @endif

                          @if($image)
                          <img src="{{asset($image)}}" alt="{{$item->product->name}}" class="img-fluid">
                          @endif

                          <div class="title">
                            <a href="{{route('product.single', $item->product->slug)}}">
                            <h6>{{$item->product->name}}</h6>
                            @if($item->variation && $item->variation->variation && $item->variation->variation_value)
                              <span class="text-muted">{{$item->variation->variation->name}}: {{$item->variation->variation_value->name}}</span>
                            @endif
                            </a>
                          </div>


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
            <div class="row addresses">
              <div class="col-sm-6">
                <div class="block-header">
                  <h6 class="text-uppercase">Invoice address</h6>
                </div>
                <div class="block-body">
                  <p>{{$order->first_name}} {{$order->first_name}}<br>{{$order->address}}<br>{{$order->city}}<br>{{$order->post_code}}<br>{{$order->country}}</p>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="block-header">
                  <h6 class="text-uppercase">Shipping address</h6>
                </div>
                <div class="block-body">
                  @if($shipping)
                  @foreach($shipping as $ship)
                    <p>{{$ship->first_name}} {{$ship->first_name}}<br>{{$ship->address}}<br>{{$ship->city}}<br>{{$ship->post_code}}<br>{{$ship->country}}</p>
                    @break
                  @endforeach
                  @else
                  <p>{{$order->first_name}} {{$order->first_name}}<br>{{$order->address}}<br>{{$order->city}}<br>{{$order->post_code}}<br>{{$order->country}}</p>
                  @endif
                </div>
              </div>
            </div>
            <!-- /.addresses                           -->
          </div>
        </div>
      </div>
    </section>
@endsection