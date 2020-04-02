@extends('layouts.dashboard')
@section('title', 'Role Edit')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Role Edit</li>
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
          <form role="form" action="{{route('admin.role.update', $role->id)}}" method="POST"  enctype="multipart/form-data">
            @method('PUT')
          {{csrf_field()}}
          <div class="card-header">
            <h3 class="card-title">Edit Role</h3>
            <div class="card-tools">
              <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button>
            </div>
          </div>
            <div class="card-body row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Role name" value="{{$role->name}}" required>
                </div>
                <div class="form-group">
                <strong>Permissions:</strong><br/>
                @foreach($permission as $value)
                  <label>
                    <input type="checkbox" name="permission[]" value="{{$value->id}}"  @if(in_array($value->id, $rolePermissions)) checked @endif >
                    {{ $value->name }}
                  </label><br/>
                @endforeach
                </div>
              </div>

            </div>
          </form>
          <!-- /.card -->
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection