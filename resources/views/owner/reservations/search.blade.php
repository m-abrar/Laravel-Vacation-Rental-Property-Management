@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Search Vacation Properties
  <small>Select date of arrival and departure</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li><a href="{{url('admin/reservations')}}">Reservations</a></li>
  <li class="active">Search</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <form action="{{ url('/admin/reservations/search') }}" method="get">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <!-- Date range -->
      <div class="form-group">
        <label>Select Dates:</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input 
            type="text"
            name = "search_dates"
            class="date-range form-control pull-right"
            value="@if(old('search_dates')){!! old('search_dates') !!}@elseif(isset($search_dates)){{$search_dates}}@endif"
            />
          <span class="input-group-btn">
          <button type="submit" class="btn btn-info btn-flat" type="button">Go!</button>
          </span>
        </div>
        <!-- /.input group -->
      </div>
      <!-- /.form group -->
    </form>
    {{count(@$properties)}} Properties are available!
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="col-md-12">
      @foreach ($properties as $property)
      <article class="col-md-12">
        <div class="col-md-4 col-sm-6"> 
          <img class="image-200 img-responsive img-hover" 
            src="{{asset($property->images->first()->image)}}" alt="{{$property->title}}"> 
        </div>
        <div class="col-md-8 col-sm-6">
          <h3>
            {{$property->title}}
          </h3>
          <p> <span>Bedrooms:
            <?= $property->bedrooms ?>
            </span> | <span>Bathrooms:
            <?= $property->bathrooms ?>
            </span> | <span>Sleeping Capacity:
            <?= $property->sleeps ?>
            </span> 
          </p>
          <button rel="{{url('admin/reservations/create/'.$property->slug.'/'.$date_start.'/'.$date_end)}}" type="button" 
            class="btn btn-info make-modal-large iframe-form-open" 
            data-toggle="modal" data-target="#iframeModal" title="Add Reservation to: {{$property->title}}">
          <span class="glyphicon glyphicon-new-window"></span> Book
          </button>
        </div>
      </article>
      @endforeach
    </div>
  </div>
</div>
@endsection
