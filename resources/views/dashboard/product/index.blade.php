@extends('layouts.dashboard')
@section('title', 'Products')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Products</li>
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
            <h3 class="card-title">Products Table</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="product_table">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Product Name</th>
                    <th>Image</th>
                    <th>Purchase Price</th>
                    <th>Sell Price</th>
                    <th>Offer Price</th>
                    <th>Categories</th>
                    <th>Brand</th>
                    <th>Type</th>
                    <th>Action</th>
                    <th>Created</th>
                  </tr>
                </thead>
              </table>
            </div>
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
  $('#product_table').delegate('.sweet_confirm', 'click', function(e){
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

  $('#product_table').DataTable({
    ajax: '{{route("api.product.collection")}}',
    columns: [
      { data: 'code' },
      { data: 'name' },
      { data: 'image', 'searchable': false, 'orderable': false },
      { data: 'purchase_price' },
      { data: 'sell_price' },
      { data: 'offer_price' },
      { data: 'categories' },
      { data: 'brand' },
      { data: 'type' },
      { data: 'action', 'searchable': false, 'orderable': false },
      { data: 'created_at' },
    ],
    "order": [[ 10, "desc" ]],
    "autoWidth": false,
    "lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]],
    'columnDefs': [
      { 'sortable': true, 'searchable': false, 'visible': false, 'type': 'num', 'targets': [10] }
    ],
  });
});
</script>
@endpush