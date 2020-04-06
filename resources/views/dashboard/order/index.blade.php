@extends('layouts.dashboard')
@section('title', 'Orders')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Orders</li>
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
            <h3 class="card-title">Orders Table</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="order_table">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Customer Name</th>
                    <th>Price</th>
                    <th>Status</th>
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
  $('#order_table').delegate('.sweet_confirm', 'click', function(e){
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

  $('#order_table').DataTable({
    ajax: '{{route("api.order.collection")}}',
    columns: [
      { data: 'code' },
      { data: 'name' },
      { data: 'price' },
      { data: 'status' },
      { data: 'action', 'searchable': false, 'orderable': false },
      { data: 'created_at' },
    ],
    "order": [[ 5, "desc" ]],
    "autoWidth": false,
    "lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]],
    'columnDefs': [
      { 'sortable': true, 'searchable': false, 'visible': false, 'type': 'num', 'targets': [5] }
    ],
  });
});
</script>
@endpush