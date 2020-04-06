@extends('layouts.dashboard')
@section('title', 'Stock')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Stocks</li>
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
            <h3 class="card-title">Stocks Table</h3>
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
                    <th>Quantity</th>
                    <th>Created</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
                </tfoot>
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
  $('#product_table').DataTable({
    ajax: '{{route("api.stock.collection")}}',
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
      { data: 'quantity'},
      { data: 'created_at' },
    ],
    "order": [[ 10, "desc" ]],
    "autoWidth": false,
    "lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]],
    'columnDefs': [
      { 'sortable': true, 'searchable': false, 'visible': false, 'type': 'num', 'targets': [10] }
    ],
    "footerCallback": function ( row, data, start, end, display ) {
      var api = this.api(), data;
      // converting to interger to find total
      var intVal = function ( i ) {
        return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
      };
 
      // computing column Total of the complete result 
      var purchaseTotal = api
        .column( 3 )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );
        
      var sellTotal = api
        .column( 4 )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );
        
      var offerTotal = api
        .column( 5 )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );
        
      var quantityTotal = api
        .column( 9 )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );      
        
      // Update footer by showing the total with the reference of the column index 
      $( api.column( 0 ).footer() ).html('Total');
      $( api.column( 3 ).footer() ).html(purchaseTotal.toFixed(2));
      $( api.column( 4 ).footer() ).html(sellTotal.toFixed(2));
      $( api.column( 5 ).footer() ).html(offerTotal.toFixed(2));
      $( api.column( 9 ).footer() ).html(quantityTotal.toFixed(2));
    }
  });


});
</script>
@endpush