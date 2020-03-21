@extends('layouts.dashboard')
@section('content')

<!-- Main content -->
<div class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Products Table</h3>
            <div class="card-tools">
             <form method="get">
               <div class="input-group input-group-sm">
                 <input type="text" name="search" class="form-control float-right" placeholder="Search">
                 <div class="input-group-append">
                   <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                 </div>
               </div>
             </form>
           </div>
         </div>
         <!-- /.card-header -->
         <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>Code</th>
                <th>Product Name</th>
                <th>Image</th>
                <th>Purchase Price</th>
                <th>Sell Price</th>
                <th>Sizes</th>
                <th>Categories</th>
                <th>Brand</th>
                <th>Type</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
             @foreach($products as $product)
             <tr>
              <td>{{$product->code}}</td>
              <td>{{$product->name}}</td>
              <td>@if($product->image)<img src="{{asset($product->image)}}" width="50" height="50">@endif</td>
              <td>{{$product->purchase_price}}</td>
              <td>{{$product->price}}</td>
              <td>@if(count($product->sizes)){{$product->sizes->implode('name', ',')}}@endif</td>
              <td>@if(count($product->categories)){{$product->categories->implode('name', ',')}}@endif</td>
              <td>@if($product->brand){{$product->brand->name}}@endif</td>
              <td>{{$product->variation_values}}</td>
              <td>
                <ul class='nav'>
                  <li><a href="{{route('admin.product.show', $product->slug)}}"><i class='fa fa-eye' aria-hidden='true'></i></a></li>
                  <li><a href="{{route('admin.product.edit', $product->slug)}}"><i class='fa fa-pencil-alt' aria-hidden='true'></i></a></li>
                  <li><a href='#' data-url="{{route('admin.product.destroy', $product->slug)}}" class='sweet_confirm'><i class='fa fa-trash' aria-hidden='true'></i></a></li>
                </ul>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
      <div class="card-tools">
       {{$products->links()}}
     </div>
   </div>
   <!-- /.card -->
 </div>
</div>
<!-- /.row -->



</div><!-- /.container-fluid -->
</div>
<!-- /.content -->

@endsection