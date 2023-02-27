<!-- Yeah, you get here when made a successful reservation -->
@extends('layouts.default.start')
@section('title')
Successfully Reserved | {{$property->title}} - {{$settings->site_title}}
@endsection
@section('contents')
<div class="container page-body">
  <!-- Page Heading/Breadcrumbs -->
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">{{trans('eminent.booking')}} <small>-
        {{ $property->title }}
        </small> 
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php">{{trans('eminent.home')}}</a></li>
        <li><a href="properties.php">{{trans('eminent.booking')}}</a></li>
        <li class="active">
          {{ $property->title }}
        </li>
      </ol>
    </div>
  </div>
  @include('include.alerts')
  <!-- /.row -->

  <div class="row">
    <!-- Left column used for showing the detail of reservation just created. -->
    <div class="col-lg-9">
      <p class="text-success">
      <h2>
        {{ @$message }}
      </h2>
      </p>
      <dl class="dl-horizontal">
        <dt>{{trans('eminent.reservation.property-name')}}</dt>
        <dd>
          {{ $property->title }}
        </dd>
        <dt>{{trans('eminent.reservation.address')}}</dt>
        <dd>
          {{ $property->address }}
        </dd>
        <dt>{{trans('eminent.reservation.city')}}</dt>
        <dd>
          {{ $property->city }}
        </dd>
        <dt>{{trans('eminent.reservation.state')}}</dt>
        <dd>
          {{ $property->location->title }}
        </dd>
        <dt>{{trans('eminent.reservation.zip')}}</dt>
        <dd>
          {{ $property->zip }}
        </dd>
      </dl>
      <p>
        {!! $property->summary !!}
      </p>
    </div>
    <!-- On the right side we show the detail of property which has been just reserved. -->
    <div class="col-md-3">
    <!-- Future is_main -->
      <div id="propertyMainImage"> <img class="img-responsive" src="{{asset($property->images->first()->image)}}" alt="{{$property->title}}" /> </div>
      <br>
      <div class="row">
        <div class="col-md-5 info-cell-small div-gray">
          {{trans('eminent.property.bedrooms')}}
          <div class="pull-right">
            {{ $property->bedrooms }}
          </div>
        </div>
        <div class="col-md-5 info-cell-small div-gray">
          {{trans('eminent.property.bathrooms')}}
          <div class="pull-right">
            {{ $property->bathrooms }}
          </div>
        </div>
        <div class="col-md-5 info-cell-small div-gray">
          {{trans('eminent.property.sleeps')}}
          <div class="pull-right">
            {{ $property->sleeps }}
          </div>
        </div>
        <div class="col-md-5 info-cell-small div-gray">
          {{trans('eminent.property.garages')}}
          <div class="pull-right">
            {{ $property->garages }}
          </div>
        </div>
      </div>
      <!-- Following button by clicking sends you back to the property detail page. -->
      <nav>
        <ul class="pager">
          <li><a href="{{url('show/'.$property->slug)}}"><span aria-hidden="true">&larr;</span> {{trans('eminent.links.property-detail')}}</a></li>
        </ul>
      </nav>
      <!-- End of link button -->
    </div>
  </div>
  <!-- /.row -->
  <hr>
</div>
<!-- /.container -->
@endsection
