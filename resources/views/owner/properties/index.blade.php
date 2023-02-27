@extends('owner.layouts.default.start')
@section('heading')
<h1>
  Properties/Listings
  <small>Your properties to be displayed for booking, sale and/or other purposes.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/owner/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Properties</li>
</ol>
<br/>
@endsection
@section('contents')
@include('owner.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <button rel="{{url('owner/properties/create')}}" type="button" 
      class="btn btn-info make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Add Property">
    <span class="glyphicon glyphicon-plus"></span>Add
    </button>
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>

  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table class="table table-bordered table-striped datatable-first-column-asc">
      <thead>
        <tr>
          <th></th>
          <th>Name</th>
          <td>Status</td>
         
          <td></td>
        </tr>
      </thead>
      <tbody>
        @foreach( $properties as $property )
        <tr>
          <td>
            @if(isset($property->images->first()->image))
            <img class="image-100 img-responsive" src="{{asset($property->images->first()->image)}}" alt="{{$property->title}}">
            ({{count($property->images)}})
            @endif<br/>
          </td>
          <td>
            <h3>
              {{$property->title}} <small>#{{$property->code}}</small>
            </h3>
            <p>{{$property->category->title}}</p>
            <p> <span>Bedrooms:
              <?= $property->bedrooms ?>
              </span> | <span>Bathrooms:
              <?= $property->bathrooms ?>
              </span> | <span>Sleeping Capacity:
              <?= $property->sleeps ?>
              </span> 
            </p>
          </td>
          <td>
            <ul>
              @if($property->is_active=='1')
              <li>Active</li>
              @endif
              @if($property->is_featured=='1')
              <li>Featured</li>
              @endif
              @if($property->is_new=='1')
              <li>New</li>
              @endif
              @if($property->is_vacation=='1')
              <li>Vacation</li>
              @endif
              @if($property->is_sale=='1')
              <li>Sale</li>
              @endif
              @if($property->is_rates=='1')
              <li>Show Rates</li>
              @endif
            </ul>
          </td>
          
          <td>
            <a href="#" rel="{{url('owner/properties/edit/'.$property->id)}}" 
              class="iframe-form-open make-modal-large btn btn-default" 
              data-toggle="modal" data-target="#iframeModal" 
              title="Edit Property: {{$property->title}}">
            <span class="glyphicon glyphicon-pencil"></span>
            </a>
            
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th></th>
          <th>Name</th>
          <td>Status</td>
          
          <th></th>
        </tr>
      </tfoot>
    </table>

  </div>
  <!-- /.box-body -->
</div>
@endsection
