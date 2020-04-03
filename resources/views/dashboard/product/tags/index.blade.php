@extends('layouts.dashboard')
@section('title', 'Product Tags')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Product Tags</li>
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
            <h3 class="card-title">Product Tags Table</h3>
            <div class="card-tools">
              @can('product-tags')
              <a class="btn btn-success" href="#" data-url="{{route('admin.product.productTag.create')}}" id="add_product_tag"> Create New Product Tag</a>
              @endcan
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="tags_table">
                <thead>
                  <tr>
                    <th style="width: 25px;">No</th>
                    <th>Name</th>
                    <th style="width: 55px;">Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach (\App\ProductTag::latest()->get() as $tag)
                <tr>
                    <td>{{ $loop->index + 1}}</td>
                    <td>{{ $tag->name }}</td>
                    <td>
                    	<ul class="nav tbl_btns">
                    		<li><a href ="#" data-url="{{route('admin.product.productTag.edit', $tag->slug)}}" class="tag_edit"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a></li>
                    		<li><a href="#" data-url="{{route('admin.product.productTag.destroy', $tag->slug)}}" class="sweet_confirm"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
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
<div class="modal fade" id="productTagModal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
	var $modal = $('#productTagModal');

  $('#tags_table').delegate('.sweet_confirm', 'click', function(e){
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

  $(document).on('click', '#add_product_tag', function(e){
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

  $(document).on('click', '#tags_table .tag_edit', function(e){
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

  $('#tags_table').dataTable();

});
</script>
@endpush