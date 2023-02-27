<!-- This view file shows the list of properties matching a specific category the user has clicked -->
@extends('layouts.default.start')
<!-- Goes to html>head>title -->
@section('title')
{{$category->title}} - {{$settings->site_title}}
@endsection
<!-- Yields body of the page inside the template -->
@section('contents')
<!-- Page Content -->
<style type="text/css">
   .page-header-bg:before {
   background-image: url('{{asset($category->image)}}');
   }
</style>
<div class="page-header-bg">
   <div class="container">
      <h1 class="pull-left">
         {{trans('eminent.properties')}} &#10095; {{@$category->title}}
      </h1>
      <ol class="breadcrumb pull-right">
         <li><a href="{{url('/')}}">{{trans('eminent.home')}}</a></li>
         <li><a href="{{url('types/')}}">{{trans('eminent.properties')}}</a></li>
         <li class="active">
            {{@$category->title}}
         </li>
      </ol>
   </div>
</div>
<div class="container page-body box-shadow" >
   @include('include.search-form-horizontal')
   @include('include.alerts')
   <?php
      $filters = array();
      $filters_check = array();
      foreach($properties as $property){
      foreach($property->classez as $class){
        if(!in_array(@$class->theclass->slug, $filters_check)) 
          {
            $filter = (object) ['slug'=>@$class->theclass->slug,'title'=>@$class->theclass->title];
            array_push($filters, $filter);
            array_push($filters_check, @$class->theclass->slug);
          }
      }
      }
      ?>
   @if(count($filters)>0)
   <div class="col-md-12">
      <ul id="filter-options">
         <li><a class="active" href="#" data-group="all">All</a></li>
         @foreach($filters as $filter)
         <li><a href="#" data-group="{{$filter->slug}}">{{$filter->title}}</a></li>
         @endforeach
      </ul>
   </div>
   @endif
   <!-- List of Properties -->
   <main>
      <div class="row" id="filter-results">
         <?php if(count($properties)=='0'){ ?>
         <h2 style="text-align: center">{{trans('eminent.no-results')}}</h2>
         <?php }else{ ?>
         @foreach ($properties as $property)
         @include('properties._type-article')
         @endforeach
         <?php } ?>
      </div>
      <hr/>
   </main>
</div>
<!-- /.container -->
@endsection
@section('javascript')
<script src="{{ asset('js/jquery.shuffle.min.js') }}" type="text/javascript"></script>
<script>
   $(document).ready(function() {
   
     /* initialize shuffle plugin */
     var $grid = $('#filter-results');
   
     $grid.shuffle({
       itemSelector: '.item' // the selector for the items in the grid
     });
   
     /* reshuffle when user clicks a filter item */
     $('#filter-options a').click(function (e) {
       e.preventDefault();
   
       // set active class
       $('#filter-options a').removeClass('active');
       $(this).addClass('active');
   
       // get group name from clicked item
       var groupName = $(this).attr('data-group');
   
       // reshuffle grid
       $grid.shuffle('shuffle', groupName );
     });
   
   });
</script>
@endsection