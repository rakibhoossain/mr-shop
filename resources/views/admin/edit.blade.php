@extends('layouts.dashboard')
@section('title', 'Admin Edit')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Admin Edit</li>
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
          <form role="form" action="{{route('admin.update', $admin->id)}}" method="POST">
            @method('PUT')
          {{csrf_field()}}
          <div class="card-header">
            <h3 class="card-title">Edit Admin</h3>
            <div class="card-tools">
              <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button>
            </div>
          </div>
            <div class="card-body row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="name">{{ __('Name') }}</label>
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $admin->name }}" required autocomplete="name" autofocus>
                </div>                

                <div class="form-group">
                  <label for="email">{{ __('E-Mail Address') }}</label>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $admin->email }}" required autocomplete="email">
                </div>                

                <div class="form-group">
                  <label for="password">{{ __('Password') }}</label>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                </div>

                <div class="form-group">
                  <label for="password-confirm">{{ __('Confirm Password') }}</label>
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                </div>

                <div class="form-group">
                  <label for="roles">{{ __('Role') }}</label>
                  <select class="form-control select2" id="roles" name="roles[]" multiple style="width: 100%" data-placeholder="Select Role">
                    @foreach($roles as $role)
                    <option value="{{$role}}" @if(in_array($role, $userRole)) selected @endif >{{$role}}</option>
                    @endforeach
                  </select>
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