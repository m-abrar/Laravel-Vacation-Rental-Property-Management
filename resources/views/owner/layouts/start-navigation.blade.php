<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>Site Navigation Control</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
  <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
  <link href="{{asset('/admin/_noblesoft/css/navigation.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('/admin/_noblesoft/css/style.css')}}" rel="stylesheet" type="text/css" />
  <!-- Bootstrap 3.3.4 -->
  <link href="{{asset('/admin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
  <!--[if lt IE 9]>
  <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <script src="{{asset('admin/_noblesoft/js/custom-functions.js')}}"></script>
  <script src="{{asset('admin/_noblesoft/js/jquery.nestable.js')}}"></script>
</head>
<body>
  <div class="ajax-spinner-center page-center-spinner"></div>
  <div id="ajaxresponse"></div>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Eminent Property Management</a>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbar-group-name">
        <!-- <ul class="nav navbar-nav">
          <li><a href="#"><strong>Navigation Group:</strong></a></li>
          <li><a href="{{url('admin/navigation/top-bar')}}">Top Bar</a></li>
          <li><a href="{{url('admin/navigation/left-bar')}}">Left Bar</a></li>
          <li><a href="{{url('admin/navigation/footer')}}">Footer</a></li>
          </ul> -->
        <ul class="nav navbar-nav navbar-right">
          <li><a href="{{url('admin/dashboard')}}"><span class="glyphicon glyphicon-menu-right"></span>Dashboard</a></li>
          <li><a href="{{url('/')}}" target="_blank"><span class="glyphicon glyphicon-menu-right"></span>Frontend</a></li>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
  </nav>
  @include('admin.layouts.partials.alerts')
  @yield('contents')
  <script type="text/javascript" charset="utf-8">
    //<![CDATA[
    jQuery(function() {
      jQuery('.navbar-nav li').each(function() {
        var href = jQuery(this).find('a').attr('href');
        if (href === window.location.href) {
          jQuery(this).addClass('active');
        }
      });
    });  
    //]]>
  </script>
</body>
</html>
