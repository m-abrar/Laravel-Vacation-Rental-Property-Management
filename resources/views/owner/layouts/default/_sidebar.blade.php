<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
  <!-- Sidebar Menu -->
  <ul class="sidebar-menu">
    <li class="header"><span class="pull-left"><img src="{{asset('admin/img/'.$settings->avatar)}}" class="img-circle image-50" alt="{{$settings->site_title}}" /></span><span class="pull-right">MENU</span></li>
    <!-- Optionally, you can add icons to the links -->
    <li class="treeview" id="treeview-business">
      <a href="#"><i class='fa fa-dollar'></i> <span>Business</span> <i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
        <li><a href="{{url('/owner/reservations')}}"><i class='fa fa-plane'></i> <span>Reservations</span></a></li>
        <li><a href="{{url('/owner/transactions')}}"><i class='fa fa-money'></i> <span>Transactions</span></a></li>
        
        <li><a href="{{url('/owner/dashboard')}}"><i class='fa fa-tachometer'></i> <span>Dashboard</span></a></li>
      </ul>
    </li>
    <li class="treeview" id="treeview-properties">
      <a href="#"><i class='fa fa-building-o'></i> <span>Properties</span> <i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
        <li><a href="{{url('/owner/properties')}}"><i class='fa fa-home'></i> <span>Properties</span></a></li>
        
      </ul>
    </li>

    
    <li class="treeview" id="treeview-settings">
      <a href="#"><i class='fa fa-gears'></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">

        <li><a href="{{url('/owner/users')}}"><i class='fa fa-user'></i> <span>My Profile</span></a></li>

        
      </ul>
    </li>
  </ul>
  <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->


