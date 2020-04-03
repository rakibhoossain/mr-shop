@extends('layouts.dashboard')
@section('title', 'Print Barcode')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Print Barcode</li>
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
            <h3 class="card-title">Print Barcode</h3>
          </div>
          <div class="card-body">


<h1>Barcode</h1>


          </div>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
@push('scripts')
<script type="text/javascript">
$(document).ready(function() {

  // $(document).on('click', '#add_brand', function(e){
  //   e.preventDefault();
  //   let url = $(this).data('url');
  //   $.ajax({
  //     type: "GET",
  //     url,
  //     success: function(response) {
  //       if (response.success) {
  //         $modal.find('.modal-content').html(response.html);
  //         $modal.modal('show');
  //       } else {
  //         Swal.fire('Error!', 'Something went wrong!','error');
  //       }
  //     }
  //   });    
  // })


});
</script>
@endpush