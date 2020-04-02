@extends('layouts.dashboard')
@section('title', 'Admin')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Admins</li>
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
            <h3 class="card-title">Admins Table</h3>
            <div class="card-tools">
              <a class="btn btn-success" href="{{route('admin.create')}}"> Create New Admin</a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="admin_table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($admins as $admin)
                  <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                      @if(!empty($admin->getRoleNames()))
                        @foreach($admin->getRoleNames() as $v)
                           <label class="badge badge-success">{{ $v }}</label>
                        @endforeach
                      @endif
                    </td>

                    <td>
                      <ul class="nav tbl_btns">
                        <li><a href="{{route('admin.show', $admin->id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                        <li><a href="{{route('admin.edit', $admin->id)}}"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a></li>
                        <li><a href="#" data-url="{{route('admin.destroy', $admin->id)}}" class="sweet_confirm"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                      </ul>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              {!! $admins->links() !!}
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
  $('#admin_table').delegate('.sweet_confirm', 'click', function(e){
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

  // $('#product_table').DataTable({
  //   ajax: '{{route("api.product.collection")}}',
  //   columns: [
  //     { data: 'code' },
  //     { data: 'name' },
  //     { data: 'image', 'searchable': false, 'orderable': false },
  //     { data: 'purchase_price' },
  //     { data: 'sell_price' },
  //     { data: 'offer_price' },
  //     { data: 'categories' },
  //     { data: 'brand' },
  //     { data: 'type' },
  //     { data: 'action', 'searchable': false, 'orderable': false },
  //     { data: 'created_at' },
  //   ],
  //   "order": [[ 10, "desc" ]],
  //   "autoWidth": false,
  //   "lengthMenu": [[50, 100, 500, -1], [50, 100, 500, "All"]],
  //   'columnDefs': [
  //     { 'sortable': true, 'searchable': false, 'visible': false, 'type': 'num', 'targets': [10] }
  //   ],
  // });
});
</script>
@endpush