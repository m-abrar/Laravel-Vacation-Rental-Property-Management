<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Eminent Property Management | Admin Panel</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Bootstrap 3.3.5 -->

    <link href="{{ asset('resources/bootstrap-3.3.5-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https:/maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https:/code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom Styling -->
    <link href="{{ asset('admin/_noblesoft/css/style.css') }}" rel="stylesheet" />
    <!-- Custom JS Functions -->
    <script src="{{asset('admin/_noblesoft/js/custom-functions.js')}}"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:/ -->
    <!--[if lt IE 9]>
    <script src="https:/oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https:/oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Cropper -->
    <link href="{{asset('admin/_noblesoft/cropper/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/_noblesoft/cropper/dist/cropper.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/_noblesoft/cropper/_noblesoft/css/main.css')}}" rel="stylesheet">
    <script src="{{asset('admin/_noblesoft/cropper/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/_noblesoft/cropper/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin/_noblesoft/cropper/dist/cropper.min.js')}}"></script>
    <script src="{{asset('admin/_noblesoft/cropper/_noblesoft/js/main.js')}}"></script>
    <!-- End Cropper -->
    <link href="{{asset('css/eminent-calendar-select-dates.css')}}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{asset('admin/_noblesoft/select2-master/dist/css/select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('admin/_noblesoft/select2-master/dist/js/select2.min.js')}}"></script>
    <!-- End Select2 -->

  </head>
  <body>
    <div class="wrapper">
      <div class="content-wrapper">
        @include('admin.layouts.partials.alerts')
        @yield('contents')
      </div>
    </div>
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
