@extends('layouts.default.start')
<!-- Goes to html>head>title -->
@section('title')
{{$category->title}} - {{$settings->site_title}}
@endsection
<!-- Yields body of the page inside the template -->
@section('contents')
<div class="container page-body page-body-cms">
   <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header">{{$category->title}}</h1>
      </div>
      @foreach($pages as $page)
      <div class="col-md-6">
         <article>
            <figure class="col-sm-12 col-md-6 pull-left">
               <a href="{{url($category->slug.'/'.$page->slug)}}">
                  @if($page->is_new==1)
                  <div class="label-circle-new"></div>
                  @endif
                  @if(isset($page->images->first()->image) and is_file($page->images->first()->image))
                  <img class="img-responsive img-hover" 
                     src="{{asset(@$page->images->first()->image_small)}}" 
                     alt="{{$page->title}}"> 
                  @endif
               </a>
            </figure>
            <div class="col-sm-12 col-md-6 pull-right">
               <h4>{{$page->title}}</h4>
               <p>
                  {!! $page->summary !!}
               </p>
               <a class="btn btn-small btn-info" href="{{url($category->slug.'/'.$page->slug)}}">
               {{trans('eminent.readmore')}} <span class="glyphicon glyphicon-chevron-right"></span> </a>
            </div>
         </article>
      </div>
      @endforeach
   </div>
   <!-- /.row -->
</div>
@endsection