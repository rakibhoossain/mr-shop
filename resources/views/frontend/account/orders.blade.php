@extends('layouts/frontend')
@section('content')
  <!-- Hero Section-->
  <section class="hero hero-page gray-bg padding-small">
    <div class="container">
      <div class="row d-flex">
        <div class="col-lg-9 order-2 order-lg-1">
          <h1>Your orders</h1><p class="lead">Your orders in one place.</p>
        </div>
        <div class="col-lg-3 text-right order-1 order-lg-2">
          <ul class="breadcrumb justify-content-lg-end">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active">Orders</li>
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
          @if(isset($orders) && !empty($orders))
          <table class="table table-hover table-responsive-md">
            <thead>
              <tr>
                <th>Order</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
              <tr>
                <th>{{$order->code}}</th>
                <td>{{date('d/m/Y', strtotime($order->created_at))}}</td>
                <td>{{$order->total_price}}</td>
                <td>{!! Helper::getLabelByStatus($order->status, 'badge') !!}</td>
                <td><a href="{{route('order.view', [auth()->user()->id, $order->id])}}" class="btn btn-primary btn-sm">View</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @endif
        </div>
      </div>
    </div>
  </section>
@endsection