<!-- This view file shows resulted items in response of user's search -->
@extends('layouts.default.start')
<!-- Goes to html>head>title -->
@section('title')
{{trans('eminent.headings.search-results')}} - {{$settings->site_title}}
@endsection
<!-- Yields body of the page inside the template -->
@section('contents')
<!-- Page Content -->
<style type="text/css">
   .page-header-bg:before {
   <?php if(count($properties)>'0'){ ?>
   background-image: url('{{asset($properties[0]->images->first()->image)}}');
   <?php } ?>
   }
</style>
<div class="page-header-bg">
   <div class="container">
      <h1 class="pull-left">
         {{trans('eminent.rental-results-found', ['count' => count($properties)])}}
      </h1>
      <ol class="breadcrumb pull-right">
         <li><a href="{{url('/')}}">{{trans('eminent.home')}}</a></li>
         <li><a href="{{url('types/')}}">{{trans('eminent.properties')}}</a></li>
         <li class="active">
            {{trans('eminent.search')}}
         </li>
      </ol>
   </div>
</div>
<div class="container page-body box-shadow">
   @include('include.search-form-horizontal')
   <!-- /.row -->
   <main>
      @include('include.alerts')
      <?php
         $filters = array();
         $filters_check = array();
         foreach($properties as $property){
         foreach($property->classez as $class){
           if(!in_array($class->theclass->slug, $filters_check)) 
             {
               $filter = (object) ['slug'=>$class->theclass->slug,'title'=>$class->theclass->title];
               array_push($filters, $filter);
               array_push($filters_check, $class->theclass->slug);
             }
         }
         }
         ?>
      @if(count($filters)>0)
      <div class="col-md-12">
         <ul id="filter-options">
            <li><a class="active" href="#" data-group="all">{{trans('eminent.form.all')}}</a></li>
            @foreach($filters as $filter)
            <li><a href="#" data-group="{{$filter->slug}}">{{$filter->title}}</a></li>
            @endforeach
         </ul>
      </div>
      @endif
      <!-- List of Properties -->
      <section class="row" id="filter-results">
         <?php if(count($properties)=='0'){ ?>
         <h2 style="text-align: center">{{trans('eminent.no-results')}}</h2>
         <?php }else{ ?>
         @foreach ($properties as $property)
         @include('properties._search-rental-article')
         @endforeach
         <?php } ?>
      </section>
      <!-- End List of Properties -->
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