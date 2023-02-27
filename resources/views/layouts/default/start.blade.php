<!-- 
  | Template Main File 
  | Contains commonly required scripts and files 
  | - Bootstrap
  | - jQuery
  | - Datepicker
  | - Preloader
  | - Navigation: Drop Down Menu
  | - LightGallery
  | - Application CSS (eminent.css)
  | - Common CSS code (style.css)
  | - Header: Reserve Online - Commonly included everywhere on the site
  | - Footer - Commonly included everywhere on the site
  | Includes partial files and pieces of results
  | - Browser Title as per the page opened
  | - Main Contents as per the page opened
  | - Javascript as per the page opened
  -->
<!DOCTYPE html>
<html lang="en">

  <head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>@yield('title')</title>
    <!-- Bootstrap -->
    <link href="{{ asset('resources/bootstrap-3.3.5-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src='//code.jquery.com/jquery-2.1.0.js'></script>
    <!-- Fonts -->
    <link href="{{ asset('resources/font-awesome-4.3.0/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
    <!-- /. Fonts -->
    <!-- Page Preloading -->
    <script src="{{asset('resources/plugins/pace/pace.js')}}"></script>
    <link href="{{asset('resources/plugins/pace/themes/green/pace-theme-flat-top.css')}}" rel="stylesheet" />
    <!-- /.Page Preloading -->
    <!-- Date Picker -->
    <script src="{{ asset('resources/plugins/datepicker-eyecon/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <link href="{{ asset('resources/plugins/datepicker-eyecon/css/datepicker.css') }}" rel="stylesheet" type="text/css">
    <!-- /. Date Picker -->
    <!-- Menu -->
    <link href="{{ asset('/css/main-menu-styles.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('/js/main-menu-script.js') }}" type="text/javascript"></script>
    <!-- /.Menu -->


 <!-- Footer --><!-- 
    
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    
    <!-- /.Footer -->
    @yield('head_enqueue_scripts')
    

    <!-- img-preload -->
    <script type="text/javascript" src="{{ asset('resources/plugins/unveil-master/jquery.unveil.js')}}"></script>
    <script>
    $(function() {
    $(".img-preload").unveil(300);
    });
    </script>
    <!-- /.img-preload -->

    <!-- Unit Gallery -->
    <!-- 
    jQuery already included @ jquery-2.1.0.js
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/jquery-11.0.min.js')}}"></script> 
    -->
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-common-libraries.js')}}"></script> 
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-functions.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-thumbsgeneral.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-thumbsstrip.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-touchthumbs.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-panelsbase.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-strippanel.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-gridpanel.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-thumbsgrid.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-tiles.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-tiledesign.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-avia.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-slider.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-sliderassets.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-touchslider.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-zoomslider.js')}}"></script> 
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-video.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-gallery.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-lightbox.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-carousel.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/js/ug-api.js')}}"></script>
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/themes/compact/ug-theme-compact.js')}}"></script>

    <link rel="stylesheet" href="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/css/unite-gallery.css')}}" type="text/css" />
    <script type="text/javascript" src="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/themes/default/ug-theme-default.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('resources/plugins/unitegallery-master/source/unitegallery/themes/default/ug-theme-default.css')}}" type="text/css" />

    <!-- /. Unit Gallery -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/css/eminent-main.css') }}" rel="stylesheet" type="text/css">


    <link id="theme_options_color" rel="stylesheet" type="text/css" href="<?php
        if(isset($_GET['theme_options_color'])){
            echo asset('/css/eminent-theme-'.sprintf("%03d", $_GET['theme_options_color']).'.css');
            setcookie('theme_options_color', asset('/css/eminent-theme-'.sprintf("%03d", $_GET['theme_options_color']).'.css'), time() + (86400 * 30), "/");
        }elseif (null !== @$_COOKIE['theme_options_color']){
            echo $_COOKIE['theme_options_color'];
        }else{
            echo asset('/css/eminent-theme-'.sprintf("%03d", $settings->theme_options_color).'.css');
        }

     ?>" media="screen" />

    {!!$settings->chat_script!!}

  </head>
  <body>


  <?php 
$theme_options_header = $settings->theme_options_header?$settings->theme_options_header:1;
if(isset($_GET['theme_options_header'])){
$theme_options_header = (int)$_GET['theme_options_header'];
setcookie("theme_options_header", $theme_options_header, time()+3600);
}elseif(isset($_COOKIE['theme_options_header'])){
$theme_options_header = $_COOKIE['theme_options_header'];
}


$theme_options_hero = $settings->theme_options_hero?$settings->theme_options_hero:1;
if(isset($_GET['theme_options_hero'])){
$theme_options_hero = (int)$_GET['theme_options_hero'];
setcookie("theme_options_hero", $theme_options_hero, time()+3600);
}elseif(isset($_COOKIE['theme_options_hero'])){
$theme_options_hero = $_COOKIE['theme_options_hero'];
}
?>
@if(@$theme_options_hero!=2)
@include("include.header-00$theme_options_header")
@endif

<!-- Load/Execute the code for contents from the view page. -->
@yield('contents')
    <!-- Footer -->


    <?php 
    $theme_options_footer = $settings->theme_options_footer?$settings->theme_options_footer:1;
    if(isset($_GET['theme_options_footer'])){
    $theme_options_footer = (int)$_GET['theme_options_footer'];
    setcookie("theme_options_footer", $theme_options_footer, time()+3600);
    }elseif(isset($_COOKIE['theme_options_footer'])){
    $theme_options_footer = $_COOKIE['theme_options_footer'];
    }
    ?>
    @include("include.footer-00$theme_options_footer")
    </div>
    <!-- End of Footer -->
    <!-- jQuery required for Bootstrap | already included in the head jquery-2.1.0.js -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('resources/bootstrap-3.3.5-dist/js/bootstrap.min.js') }}"></script>
    <!-- JS -->
    <script src="{{ asset('js/modernizr.custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/toucheffects.js') }}" type="text/javascript"></script>
    <!-- Sliders -->
    <script>
      $('.carousel').carousel({
      
      interval: 5000 //controls the slider speed
      
      })
      
    </script>
    <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
    </script>
    
    
    <!-- End of Customize Date Picker -->
    <!-- Picture Gallery -->
    <!-- jQuery required >= 1.8.0  | jQuery already included in the head jquery-2.1.0.js -->
    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lightgallery.js')}}"></script>
    <!-- A jQuery plugin that adds cross-browser mouse wheel support. (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
    <!-- lightgallery plugins -->
    <script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-fullscreen.js')}}"></script>
    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-thumbnail.js')}}"></script>
    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-video.js')}}"></script>
    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-autoplay.js')}}"></script>
    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-zoom.js')}}"></script>
    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-hash.js')}}"></script>
    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-pager.js')}}"></script>
    <!-- End of Picture Gallery -->

    <!-- Load the javascript code defined in the view page. -->
    @yield('javascript')
    
    {!!$settings->google_analytics!!}
    @if($settings->theme_options_frontend_control==1)
    @include('include.theme-options')
    @endif

  </body>
</html>