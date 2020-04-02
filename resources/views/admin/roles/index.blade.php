@extends('layouts.dashboard')
@section('title', 'Roles')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Roles</li>
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
            <h3 class="card-title">Roles Table</h3>
            <div class="card-tools">
              @can('role-create')
              <a class="btn btn-success" href="{{ route('admin.role.create') }}"> Create New Role</a>
              @endcan
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="admin_table">
                <thead>
                  <tr>
                    <th style="width: 25px;">No</th>
                    <th>Name</th>
                    <th style="width: 110px;">Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                      <ul class="nav tbl_btns">
                        <li><a href="{{route('admin.role.show', $role->id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                        @can('role-edit')
                        <li><a href="{{route('admin.role.edit', $role->id)}}"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a></li>
                        @endcan
                        @can('role-delete')
                        <li><a href="#" data-url="{{route('admin.role.destroy', $role->id)}}" class="sweet_confirm"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                        @endcan
                      </ul>
                    </td>
                </tr>
                @endforeach

                </tbody>
              </table>
              {!! $roles->links() !!}
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

});
</script>
@endpush