@extends('layouts.dashboard')
@section('title', 'Brands')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Brands</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Brand Table</h3>
            <div class="card-tools">
              @can('product-brand')
              <a class="btn btn-success" href="#" data-url="{{route('admin.product.brand.create')}}" id="add_brand"> Create New Brand</a>
              @endcan
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="brand_table">
                <thead>
                  <tr>
                    <th style="width: 25px;">No</th>
                    <th>Name</th>
                    <th style="width: 60px">Image</th>
                    <th>Description</th>
                    <th style="width: 80px;">Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach (\App\Brand::latest()->get() as $brand)
                <tr>
                    <td>{{ $loop->index + 1}}</td>
                    <td>{{ $brand->name }}</td>
                    <td>@if($brand->image) <img src="{{asset($brand->image)}}" height="50" width="50" alt="{{ $brand->name }}">  @endif </td>
                    <td>{{ $brand->description }}</td>
                    <td>
                    	<ul class="nav tbl_btns">
                    		<li><a href ="#" data-url="{{route('admin.product.brand.edit', $brand->slug)}}" class="brand_edit"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a></li>
                    		<li><a href="#" data-url="{{route('admin.product.brand.destroy', $brand->slug)}}" class="sweet_confirm"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                    	</ul>
                    </td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<!-- Modal Product Image -->
<div class="modal fade" id="brandModal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
	var $modal = $('#brandModal');

  $('#brand_table').delegate('.sweet_confirm', 'click', function(e){
    e.preventDefault();
    let url = $(this).data('url');
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "DELETE",
          url: url,
          success: function(response) {
            if (response.success) { // if true (1)
              Swal.fire('Deleted!', response.message,'success');
              setTimeout(function() { // wait for 0.5 secs(2)
                location.reload(); // then reload the page.(3)
              }, 500);
            } else {
              Swal.fire('Error!', response.message,'error');
            }
          }
        });
      }
    })
  });

  $(document).on('click', '#add_brand', function(e){
    e.preventDefault();
    let url = $(this).data('url');
    $.ajax({
      type: "GET",
      url,
      success: function(response) {
        if (response.success) {
          $modal.find('.modal-content').html(response.html);
          $modal.modal('show');
        } else {
          Swal.fire('Error!', 'Something went wrong!','error');
        }
      }
    });    
  })

  $(document).on('click', '#brand_table .brand_edit', function(e){
    e.preventDefault();
    let url = $(this).data('url');
    $.ajax({
      type: "GET",
      url,
      success: function(response) {
        if (response.success) {
          $modal.find('.modal-content').html(response.html);
          $modal.modal('show');
        } else {
          Swal.fire('Error!', 'Something went wrong!','error');
        }
      }
    });    
  }) 

  $(document).on('change', '#brand_image', function(e){
    e.preventDefault();

    let _this = this;
    // let html = $('#image_upload_clone').html();
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#brand_image_preview img').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(_this.files[0]);
        // $('.image_upload').last().after(html);
    }

  })

});
</script>
@endpush