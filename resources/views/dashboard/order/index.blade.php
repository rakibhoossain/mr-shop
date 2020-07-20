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
            <ul class="nav justify-content-center">
                <li class="nav-item">
                  <a class="nav-link order-filter-link" href="#" data-url="{{route('api.order.collection')}}">All Order</a>
                </li>
                @foreach(\App\Order::select('status')->distinct()->get()->toArray() as $status)
                <li class="nav-item">
                  <a class="nav-link order-filter-link" href="#" data-url="{{route('api.order.collection')}}?status={{$status['status']}}">{{\Str::title($status['status'])}}</a>
                </li>
                @endforeach
            </ul>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="order_table">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Customer Name</th>
                    <th>Price</th>
                    <th>Charge</th>
                    <th>Order Status</th>
                    <th>Payment Status</th>
                    <th style="width: 75px;">Action</th>
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

<!-- Order overview modal -->
<div class="modal fade" id="orderPreviewModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"></div>

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

  var order_table = $('#order_table').DataTable({
    ajax: '{{route("api.order.collection")}}',
    columns: [
      { data: 'code' },
      { data: 'name' },
      { data: 'price' },
      { data: 'charge' },
      { data: 'status' },
      { data: 'payment_status' },
      { data: 'action', 'searchable': false, 'orderable': false },
      { data: 'created_at' },
    ],
    "order": [[ 7, "desc" ]],
    "autoWidth": false,
    "lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]],
    'columnDefs': [
      { 'sortable': true, 'searchable': false, 'visible': false, 'type': 'num', 'targets': [7] }
    ],
  });

  $(document).on('click', '.order-filter-link', function(e){
    e.preventDefault();
    var url = $(this).data('url');
    order_table.ajax.url(url).load();
  })  

  $(document).on('click', 'td:first-child', function(){
    var url = "{{route('admin')}}/order-preview/"+$(this).text();
    $.ajax({
      type: "POST",
      url,
      success: function(response) {
        if (response.success) {
          $('#orderPreviewModal').html(response.html);
          $('#orderPreviewModal').modal('show');
        }
      }
    });
  })

});
</script>
@endpush