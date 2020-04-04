@extends('layouts.dashboard')
@section('title', 'Barcode')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Barcode</li>
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
            <h3 class="card-title">Barcode Table</h3>
            <div class="card-tools">
              @can('barcode')
              <a class="btn btn-success" href="#" data-url="{{route('admin.product.barcode.create')}}" id="add_barcode"> Create New Barcode</a>
              @endcan
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="barcode_table">
                <thead>
                  <tr>
                    <th style="width: 25px;">No</th>
                    <th>Name</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Paper Width</th>
                    <th>Paper Height</th>
                    <th>Continuous</th>
                    <th style="width: 55px;">Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach (\App\Barcode::latest()->get() as $barcode)
                <tr @if($barcode->is_default) class="bg-success" @endif >
                    <td>{{ $loop->index + 1}}</td>
                    <td>{{ $barcode->name }}</td>
                    <td>{{ $barcode->width }}</td>
                    <td>{{ $barcode->height }}</td>
                    <td>{{ $barcode->paper_width }}</td>
                    <td>{{ $barcode->paper_height }}</td>
                    <td>{{ $barcode->is_continuous }}</td>
                    <td>
                    	<ul class="nav tbl_btns">
                    		<li><a href ="#" data-url="{{route('admin.product.barcode.edit', $barcode->slug)}}" class="barcode_edit"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a></li>
                    		<li><a href="#" data-url="{{route('admin.product.barcode.destroy', $barcode->slug)}}" class="sweet_confirm"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
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
<div class="modal fade" id="barcodeModal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
	var $modal = $('#barcodeModal');

  $('#barcode_table').delegate('.sweet_confirm', 'click', function(e){
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

  $(document).on('click', '#add_barcode', function(e){
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

  $(document).on('click', '#barcode_table .barcode_edit', function(e){
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

  $('#barcode_table').dataTable();

});
</script>
@endpush