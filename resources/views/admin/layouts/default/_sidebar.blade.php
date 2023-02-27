<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
  <!-- Sidebar Menu -->
  <ul class="sidebar-menu">
    <li class="header"><span class="pull-left"><img src="{{asset('admin/img/'.$settings->avatar)}}" class="img-circle image-50" alt="{{$settings->site_title}}" /></span><span class="pull-right">MENU</span></li>
    <!-- Optionally, you can add icons to the links -->
    <li class="treeview" id="treeview-business">
      <a href="#"><i class='fa fa-dollar'></i> <span>Business</span> <i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
        <li><a href="{{url('/admin/reservations')}}"><i class='fa fa-plane'></i> <span>Reservations</span></a></li>
        <li><a href="{{url('/admin/calendar-view')}}"><i class='fa fa-calendar'></i> <span>Calendar View</span></a></li>
        <li><a href="{{url('/admin/transactions')}}"><i class='fa fa-money'></i> <span>Transactions</span></a></li>
        <!-- <li><a href="{{url('/admin/maintenance-jobs')}}"><i class='fa fa-wrench'></i> <span>Maintenance Jobs</span></a></li> -->
        <li class="treeview" id="treeview-reports">
          <a href="#"><i class='fa fa-file-text-o'></i> <span>Run Reports</span><i class="fa fa-angle-left pull-right"></i></a>
          <ul class="treeview-menu">
            <li><a href="{{url('/admin/reports/owners')}}"><i class='fa fa-file-text-o'></i> <span>Owners</span></a></li>
            <li><a href="{{url('/admin/reports/housekeepers')}}"><i class='fa fa-file-text-o'></i> <span>Housekeepers</span></a></li>
            <li><a href="{{url('/admin/reports/vendors')}}"><i class='fa fa-file-text-o'></i> <span>Vendors</span></a></li>
          </ul>
        </li>
        <li><a href="{{url('/admin/dashboard')}}"><i class='fa fa-tachometer'></i> <span>Dashboard</span></a></li>
      </ul>
    </li>
    <li class="treeview" id="treeview-properties">
      <a href="#"><i class='fa fa-building-o'></i> <span>Properties</span> <i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
        <li><a href="{{url('/admin/properties')}}"><i class='fa fa-home'></i> <span>Properties</span></a></li>
        <li><a href="{{url('/admin/amenities')}}"><i class='fa fa-adjust'></i> <span>Amenities</span></a></li>
        <li><a href="{{url('/admin/features')}}"><i class='fa fa-bolt'></i> <span>Features</span></a></li>
        <li><a href="{{url('/admin/services')}}"><i class='fa fa-glass'></i> <span>Addons/Services</span></a></li>
        <li><a href="{{url('/admin/line-items')}}"><i class='fa fa-level-up'></i> <span>Line Items</span></a></li>
        <li><a href="{{url('/admin/seasons')}}"><i class='fa fa-sun-o'></i> <span>Seasons</span></a></li>
        <li><a href="{{url('/admin/property-types')}}"><i class='fa fa-filter'></i> <span>Types</span></a></li>
        <li><a href="{{url('/admin/property-classes')}}"><i class='fa fa-pie-chart'></i> <span>Classes</span></a></li>
        <li><a href="{{url('/admin/locations')}}"><i class='fa fa-map'></i> <span>Locations</span></a></li>
      </ul>
    </li>
    <li class="treeview" id="treeview-people">
      <a href="#"><i class='fa fa-group'></i> <span>People</span> <i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
        <li><a href="{{url('/admin/facilitators')}}"><i class='fa fa-truck'></i> <span>Facilitators</span></a></li>
        <li><a href="{{url('/admin/owners')}}"><i class='fa fa-user-secret'></i> <span>Owners</span></a></li>
      </ul>
    </li>
    <li class="treeview" id="treeview-website">
      <a href="#"><i class='fa fa-laptop'></i> <span>Website</span> <i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
        <li><a href="{{url('/admin/sliders')}}"><i class='fa fa-image'></i> <span>Sliders</span></a></li>
        <li><a href="{{url('/admin/pages/index')}}"><i class='fa fa-file-text'></i> <span>Pages</span></a></li>
        <!-- <li class="treeview"><a href="#"><i class='fa fa-life-ring'></i> <span>Help Desk</span><i class="fa fa-angle-left pull-right"></i></a>
          <ul class="treeview-menu">
            <li><a href="{{url('/admin/help-desk/tickets')}}"><i class='fa fa-ticket'></i> <span>Tickets</span></a></li>
            <li><a href="{{url('/admin/help-desk/articles')}}"><i class='fa fa-file-text'></i> <span>Articles</span></a></li>
            <li><a href="{{url('/admin/help-desk/categories')}}"><i class='fa fa-pie-chart'></i> <span>Categories</span></a></li>
            <li><a href="{{url('/admin/help-desk/staff')}}"><i class='fa fa-group'></i> <span>Staff</span></a></li>
            <li><a href="{{url('/admin/help-desk/customers')}}"><i class='fa fa-group'></i> <span>Customers</span></a></li>
          </ul>
          
          
          </li> -->
      </ul>
    </li>
    <li class="treeview" id="treeview-settings">
      <a href="#"><i class='fa fa-gears'></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
        <li><a href="{{url('/admin/email-templates')}}"><i class='fa fa-envelope-o'></i> <span>Email Templates</span></a></li>
        <li><a href="{{url('/admin/users')}}"><i class='fa fa-user'></i> <span>Admin Profile</span></a></li>
        <li><a href="{{url('/admin/settings')}}"><i class='fa fa-laptop'></i> <span>Site Settings</span></a></li>
        <li><a href="{{url('/admin/navigation/top-bar')}}"><i class='fa fa-sitemap'></i> <span>Navigation</span></a></li>
      </ul>
    </li>
  </ul>
  <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->


