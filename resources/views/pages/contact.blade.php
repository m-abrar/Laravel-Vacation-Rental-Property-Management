@extends('layouts.default.start')
<!-- Goes to html>head>title -->
@section('title')
Contact Us - {{$settings->site_title}}
@endsection
<!-- Yields body of the page inside the template -->
@section('contents')
<div class="container page-body">
<!-- Page Heading/Breadcrumbs -->
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">{{trans('eminent.contact-us')}}</h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/')}}">{{trans('eminent.home')}}</a></li>
      <li class="active">
        {{trans('eminent.contact-us')}}
      </li>
    </ol>
  </div>
</div>
<div class="row">
  <div class="col-md-6 col-xs-12">
    <p><strong>{{$settings->site_title}}</strong></p>
    <p>{{$settings->site_address_line_1}}</p>
    <p>{{$settings->site_address_line_2}}</p>
    <p>Phone: {{$settings->site_phone}}</p>
    <p>Email: <a href="mailto:{{$settings->site_email}}">{{$settings->site_email}}</a></p>
    <p>Website: <a href="{{$settings->site_url}}">{{$settings->site_url}}</a></p>
  </div>
  <!--eof left-->
  <div class="col-md-6 col-xs-12">
    <p>
      <iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" 
        src="http://maps.google.com/maps?q={{$settings->latitude}},{{$settings->longitude}}&z=15&output=embed">
      </iframe>
    </p>
  </div>
  <!--eof right column-->
</div>
<!--body_area end-->
@endsection
