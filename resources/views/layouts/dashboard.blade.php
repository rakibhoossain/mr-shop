<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>{{config('settings.site_name')}} | @yield('title' , 'Dashboard')</title>
  <link rel="shortcut icon" href="{{asset(config('settings.site_favicon'))}}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Editor -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">

  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">

  <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">  
  <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/jqColor.css')}}">

  <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/select2-bootstrap4.min.css')}}">
  
  <link rel="stylesheet" href="{{asset('css/cropper.min.css')}}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('css/Admin.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light no-print">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('admin')}}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>
    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{asset('img/user1-128x128.jpg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{asset('img/user8-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{asset('img/user3-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>


      <!-- Admin Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#"><i class="far fa-user"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>
          <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;"> @csrf </form>
        </div>
      </li>


















    </ul>
  </nav>
  <!-- /.navbar -->




  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 no-print">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
      @if(config('settings.site_logo'))
        <img src="{{asset(config('settings.site_logo'))}}" alt="{{config('settings.site_name')}}" class="brand-image elevation-3" style="opacity: .8">
      @endif
      <span class="brand-text font-weight-light">{{config('settings.site_name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('admin')}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          
          @can('product-list')  
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fab fa-product-hunt"></i>
              <p>
                Product
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">{{App\Product::count()}}</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('product-list')
              <li class="nav-item">
                <a href="{{route('admin.product.index')}}" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Product List</p>
                </a>
              </li>
              @endcan
              @can('product-create')
              <li class="nav-item">
                <a href="{{route('admin.product.create')}}" class="nav-link">
                  <i class="fas fa-plus-circle nav-icon"></i>
                  <p>Product Create</p>
                </a>
              </li>
              @endcan

              @can('barcode')
              <li class="nav-item">
                <a href="{{route('admin.barcode.index')}}" class="nav-link">
                  <i class="fa fa-barcode nav-icon"></i>
                  <p>Barcode</p>
                </a>
              </li>
              @endcan
    
              @can('product-category')
              <li class="nav-item">
                <a href="{{route('admin.product.productCategory.index')}}" class="nav-link">
                  <i class="fa fa-th nav-icon"></i>
                  <p>Categories</p>
                </a>
              </li>
              @endcan              

              @can('product-tags')
              <li class="nav-item">
                <a href="{{route('admin.product.productTag.index')}}" class="nav-link">
                  <i class="fas fa-tags nav-icon"></i>
                  <p>Tags</p>
                </a>
              </li>
              @endcan

              @can('product-brand')
              <li class="nav-item">
                <a href="{{route('admin.product.brand.index')}}" class="nav-link">
                  <i class="fas fa-gem nav-icon"></i>
                  <p>Brand</p>
                </a>
              </li>
              @endcan
              @can('product-varient')
              <li class="nav-item">
                <a href="{{route('admin.product.variation.index')}}" class="nav-link">
                  <i class="fas fa-cubes nav-icon"></i>
                  <p>Variation</p>
                </a>
              </li>
              @endcan



            </ul>
          </li>
          @endcan


          @can('stock')
          <li class="nav-item">
            <a href="{{route('admin.stocks')}}" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>Stocks</p>
            </a>
          </li>
          @endcan
          @can('settings')
          <li class="nav-item">
            <a href="{{route('admin.settings.store')}}" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>Settings</p>
            </a>
          </li>
          @endcan        

          @can('user-list')
          <li class="nav-item">
            <a href="{{route('user.index')}}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>User <span class="badge badge-info right">{{App\User::count()}}</span></p>
            </a>
          </li>
          @endcan

          @can('admin-list')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Admins
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">{{App\Admin::count()}}</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('admin-list')
              <li class="nav-item">
                <a href="{{route('admin.index')}}" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Admin List</p>
                </a>
                @endcan
              </li>
              @can('role-list')
              <li class="nav-item">
                <a href="{{route('admin.role.index')}}" class="nav-link">
                  <i class="nav-icon fas fa-tasks"></i>
                  <p>Roles</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan









        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  @yield('content')
  </div>
  <!-- /.content-wrapper -->



  @include('alert')
  <!-- Main Footer -->
  <footer class="main-footer no-print">
    {!!config('settings.footer_copyright_text')!!}
    <div class="float-right d-none d-sm-inline-block">
      <b>Developed by <a href="https://github.com/rakibhoossain" target="_blank">Rakib Hossain</a></b>
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>

<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>

<script src="{{asset('js/sweetalert2.min.js')}}"></script>

<script src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('plugins/jquery-validation/additional-methods.min.js')}}"></script>

<script src="{{ asset('js/color.all.min.js') }}"></script>
<script src="{{ asset('js/jqColor.js') }}"></script>

<script src="{{asset('js/cropper.min.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>


<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>

<script src="{{asset('js/Admin.js')}}"></script>
@stack('scripts')
</body>
</html>