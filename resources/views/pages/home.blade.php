@extends('layouts.default.start')
<!-- Goes to html>head>title -->
@section('title')
{{trans('eminent.welcome')}} - {{$settings->site_title}}
@endsection
@section('head_enqueue_scripts')
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

@endsection
<!-- Yields body of the page inside the template -->
@section('contents')

<?php
$theme_options_hero = $settings->theme_options_hero?$settings->theme_options_hero:1;
if(isset($_GET['theme_options_hero'])){
$theme_options_hero = (int)$_GET['theme_options_hero'];
setcookie("theme_options_hero", $theme_options_hero, time()+3600);
}elseif(isset($_COOKIE['theme_options_hero'])){
$theme_options_hero = $_COOKIE['theme_options_hero'];
}
?>
@include("include.hero-00$theme_options_hero")
@if(@$theme_options_hero!=3 AND @$theme_options_hero!=5)
@include('include.search-form-horizontal')
@endif


<?php
$theme_options_home = $settings->theme_options_home?$settings->theme_options_home:1;
if(isset($_GET['theme_options_home'])){
$theme_options_home = (int)$_GET['theme_options_home'];
setcookie("theme_options_home", $theme_options_home, time()+3600);
}elseif(isset($_COOKIE['theme_options_home'])){
$theme_options_home = $_COOKIE['theme_options_home'];
}
?>
@include("pages.home-00$theme_options_home")

@endsection