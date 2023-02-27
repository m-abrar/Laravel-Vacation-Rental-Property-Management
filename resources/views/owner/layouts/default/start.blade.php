<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>{!!$settings->site_title!!} | Admin Panel</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Bootstrap 3.3.4 -->
    <link href="{{asset('/admin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https:/maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https:/code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="{{asset('/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{asset('/admin/dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
      page. However, you can choose any other skin. Make sure you
      apply the skin class to the body tag so the changes take effect.
      -->
    <link href="{{asset('/admin/dist/css/skins/skin-green.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Custom Styling -->
    <link href="{{ asset('/admin/_noblesoft/css/style.css') }}" rel="stylesheet" />
    <script src="{{asset('admin/_noblesoft/js/custom-functions.js')}}"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:/ -->
    <!--[if lt IE 9]>
    <script src="https:/oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https:/oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Cropper -->
    <link href="{{asset('admin/_noblesoft/cropper/dist/cropper.css')}}" rel="stylesheet">
    <!-- Preview Settings -->
    <link href="{{asset('admin/_noblesoft/cropper/_noblesoft/css/main.css')}}" rel="stylesheet">
    <script src="{{asset('admin/_noblesoft/cropper/dist/cropper.js')}}"></script>
    <!-- Custom Javascript for Cropping -->
    <script src="{{asset('admin/_noblesoft/cropper/_noblesoft/js/main.js')}}"></script>
    <!-- End Cropper -->
<!--Start of Zendesk Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?3a2NPsJX1Pg2zvBm5tl70E6aMfW1V34t";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zendesk Chat Script-->
  </head>
  <body class="skin-green sidebar-mini">
    <div class="wrapper">
      <!-- Main Header -->
      <header class="main-header">
        <!-- Logo -->
        <a href="http://noble-soft.com/product/eminent" class="logo" target="_blank">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>EM</b>T</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>EMINENT</b>OWNER</span>
        </a>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
          </a>
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <li>
              <a href="{{url('/')}}">{{$settings->site_title}}</a>
            </li>
          </ul>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-info">{{count($notifications->bookings)}}</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">{{count($notifications->bookings)}} Reservations alerts</li>
                  <li>
                    <!-- inner menu: contains the messages -->
                    <ul class="menu">
                      @foreach($notifications->bookings as $newbooking)
                      <li>
                        <!-- start message -->
                        <a href="#">
                          <!-- Message title and timestamp -->
                          <h4>
                            {{$newbooking->firstname}} {{$newbooking->lastname}}
                            <!-- <small><i class="fa fa-clock-o"></i> 5 mins</small> -->
                          </h4>
                          <!-- The message -->
                          <p>Created: <?=date('m/d/Y',strtotime($newbooking->created_at))?></p>
                        </a>
                      </li>
                      <!-- end message -->
                      @endforeach
                    </ul>
                    <!-- /.menu -->
                  </li>
                  <li class="footer"><a href="{{url('owner/reservations')}}">See All Reservations / scroll</a><small></small></li>
                </ul>
              </li>
              <!-- /.messages-menu -->
              <!-- Notifications Menu -->
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">{{count($notifications->transactions)}}</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have {{count($notifications->transactions)}} payment alerts</li>
                  <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul class="menu">
                      @foreach($notifications->transactions as $transaction)
                      <li>
                        <!-- start notification -->
                        <a href="#">
                          <!-- Message title and timestamp -->
                          <h5>
                            <i class="fa-money"></i> ${{$transaction->amount}}
                            <!-- <small><i class="fa fa-clock-o"></i> 5 mins</small> -->
                            <!-- The message -->
                            <small class="pull-right">
                            @if($transaction->status=='paid')
                            <span class="bg-success">Paid: <?=date('m/d/Y',strtotime($transaction->date_paid))?></span>
                            @elseif($transaction->status=='pending')
                            <span class="bg-danger">Pending: <?=date('m/d/Y',strtotime($transaction->date_due))?></span>
                            @endif
                            </small>
                          </h5>
                        </a>
                      </li>
                      <!-- end notification -->
                      @endforeach
                    </ul>
                  </li>
                  <li class="footer"><a href="{{url('owner/transactions')}}">View all transactions/ scroll</a><small></small></li>
                </ul>
              </li>
              <!-- Tasks Menu -->
              <li class="dropdown tasks-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-flag-o"></i>
                <span class="label label-danger">{{count($notifications->arrivals)}}</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have {{count($notifications->arrivals)}} arrivals in next 30 days</li>
                  <li>
                    <!-- Inner menu: contains the tasks -->
                    <ul class="menu">
                      @foreach($notifications->arrivals as $arrival)
                      <li>
                        <!-- start notification -->
                        <!-- Message title and timestamp -->
                        <h4>
                          &nbsp;&nbsp;{{$arrival->firstname}} {{$arrival->lastname}}
                          <!-- <small><i class="fa fa-clock-o"></i> 5 mins</small> -->
                          <!-- The message -->
                          <small class="pull-right"><?=date('l, m/d',strtotime($arrival->date_start))?>&nbsp;&nbsp;</small>
                        </h4>
                      </li>
                      <!-- end notification -->
                      @endforeach
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#">View all tasks</a>
                  </li>
                </ul>
              </li>
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="{{asset($user->avatar)}}" class="user-image" alt="User Image"/>
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs">{{$user->firstname}} {{$user->lastname}}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="{{asset($user->avatar)}}" class="img-circle" alt="User Image" />
                    <p>
                      {{$user->firstname}} {{$user->lastname}} - {{$user->designation}}
                      <small><?=date('F, Y',strtotime($user->created_at))?></small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <!-- <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                    </li> -->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{url('/owner/users')}}" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{url('/auth/logout')}}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="{{url('/owner/settings')}}"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        @include('owner.layouts.default._sidebar')
      </aside>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          @yield('heading')
          @include('owner.layouts.partials.alerts')
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- Your Page Content Here -->
          @yield('contents')
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <!-- Main Footer -->
      <!-- 
      FUTURE
      <footer class="main-footer">
        <strong>Copyright &copy; 2015 <a href="#">Noble-Soft.com</a>.</strong> All rights reserved.
        
        <div class="pull-right hidden-xs">
          <?=date('m/d/Y H:i')?>
        </div>
        
        </footer> -->
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED JS SCRIPTS -->
    <!-- <script src="{{asset('/admin/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script> -->
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{asset('/admin/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <!-- DATA TABLES SCRIPT -->
    <script src="{{asset('/admin/plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/admin/plugins/datatables/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="{{asset('/admin/plugins/slimScroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="{{asset('/admin/plugins/fastclick/fastclick.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('/admin/dist/js/app.min.js')}}" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('/admin/dist/js/demo.js')}}" type="text/javascript"></script>
    <!-- page script -->
    <script type="text/javascript">
      $(function () {
        $(".datatable-full").dataTable();
        $('.datatable-first-column-asc').dataTable({
          "order": [[ 0, 'asc' ]]          
        });
        $('.datatable-first-column-desc').dataTable({
          "order": [[ 0, 'desc' ]]          
        });
      });
    </script>
    <!-- Include Date Range Picker -->
    <!-- Include Required Prerequisites -->
    <!--<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>-->
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <!--<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/latest/css/bootstrap.css" />-->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <script type="text/javascript">
      $(function() {
          $('.date-range').daterangepicker({
              "autoApply": true
          }, function(start, end, label) {
            console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
          });
      });
    </script>
    <!-- End of Date Picker -->
    <script type="text/javascript">
      {!! @$js !!}
    </script>
    <script type="text/javascript" charset="utf-8">
      //<![CDATA[
      jQuery(function() {
        jQuery('.sidebar-menu li').each(function() {
          var href = jQuery(this).find('a').attr('href');
          if (href === window.location.href) {
            jQuery(this).addClass('active');
          }
        });
      });  
      //]]>
    </script>
    <script type='text/javascript'>
      $('.reload-page').on('click', function() {
        $('.content').html('<h1>Refreshing...</h1><i class="fa fa-refresh fa-spin"></i>');
        window.location.reload();
      });
      $('#iframeModal, #iframeModalSimple').on('hidden.bs.modal', function() {
        $('.content').html('<h1>Refreshing...</h1><i class="fa fa-refresh fa-spin"></i>');
        window.location.reload();
      })
    </script>
    <script type="text/javascript" src="{{asset('admin/_noblesoft/tinymce/tinymce.min.js')}}"></script>
    <script type="text/javascript">
      tinymce.init({
          /*selector: "textarea",*/
      
          selector: ".mceEditor",
          /*inline: true,*/
      
          plugins: [
              "advlist autolink lists link image charmap print preview anchor",
              "searchreplace visualblocks code fullscreen",
              "insertdatetime media table contextmenu paste"
          ],
          toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
      });
    </script>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-68834369-1', 'auto');
  ga('send', 'pageview');

</script>
  </body>
</html>
