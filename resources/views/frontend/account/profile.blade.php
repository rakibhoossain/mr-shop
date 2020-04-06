<div class="customer-profile"><a href="#" class="d-inline-block"><img src="../../../d19m59y37dris4.cloudfront.net/hub/1-4-3/img/person-3.jpg" class="img-fluid rounded-circle customer-image"></a>
  <h5>{{auth()->user()->name}}</h5>
  <p class="text-muted text-small">Ostrava, Czech republic</p>
</div>
<nav class="list-group customer-nav">
  <a href="{{route('orders', auth()->user()->id)}}" class="{{request()->routeIs('order*') ? 'active' : '' }} list-group-item d-flex justify-content-between align-items-center"><span><span class="icon icon-bag"></span>Orders</span><small class="badge badge-pill badge-primary">{{auth()->user()->orders->count()}}</small></a>



  <a href="{{route('account.index')}}" class="{{request()->routeIs('account.index') ? 'active' : '' }} list-group-item d-flex justify-content-between align-items-center"><span><span class="icon icon-profile"></span>Profile</span></a>
<!--   <a href="customer-addresses.html" class="{{request()->routeIs('account.index') ? 'active' : '' }} list-group-item d-flex justify-content-between align-items-center"><span><span class="icon icon-map"></span>Addresses</span></a> -->

  <a href="#" class="list-group-item d-flex justify-content-between align-items-center" onclick="event.preventDefault(); document.getElementById('account-logout-form').submit();"><span><span class="fa fa-sign-out"></span>{{ __('Logout') }}</span></a>
  <form id="account-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>



</nav>


