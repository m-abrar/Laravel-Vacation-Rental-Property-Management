<!-- This view file shows the list of available categories of properties -->
@extends('layouts.default.start')
<!-- Goes to html>head>title -->
@section('title')
Property Types - {{$settings->site_title}}
@endsection
<!-- Yields body of the page inside the template -->
@section('contents')
<!-- Page Content -->
<div class="container page-body">
  <!-- Page Heading/Breadcrumbs -->
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">{{trans('eminent.property-types')}} </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}">{{trans('eminent.home')}}</a></li>
        <li class="active">{{trans('eminent.properties')}}</li>
      </ol>
    </div>
  </div>
  <!-- /.row -->
  @include('include.alerts')
  <!-- List of Categories -->
  <main>
    <section class="row">
      <?php
        foreach ($categories as $category) {
        ?>
      <article class="col-md-4 img-portfolio">
        <a href="{{url('type/'.$category->slug)}}">
        @if(is_file($category->image))
        <img class="img-responsive img-hover" src="{{asset($category->image_small)}}" alt="{{$category->title}}">
        @else
        <img class="img-responsive img-hover" src="{{asset('pictures/placeholder.png')}}" alt="No Image Available">
        @endif
        </a>
        <h3 class="text-center"> <a href="{{url('type/'.$category->slug)}}">
          {{$category->title}} ({{count($category->properties)}})
          </a> 
        </h3>
      </article>
      <?php
        }
        ?>
    </section>
    <hr>
  </main>
</div>
<!-- /.container -->
@endsection
