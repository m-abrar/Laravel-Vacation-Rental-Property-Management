@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Properties/Listings
  <small>Your properties to be displayed for booking, sale and/or other purposes.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Properties</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <button rel="{{url('admin/properties/create')}}" type="button" 
      class="btn btn-info make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Add Property">
    <span class="glyphicon glyphicon-plus"></span>Add
    </button>
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
    <?php 
      $counter = 0;
      foreach( $properties as $property ){
        $items['id'][$counter] = $property->id;
        $items['display_order'][$counter] = $property->display_order;
        $items['image'][$counter] = @$property->images->first()->image;
        $items['title'][$counter] = $property->title;
        $counter++;
      }
      ?>
    @if(isset($items))
    <?php
      session(['model'=>'Properties']);
      session(['counter' => $counter]);
      session(['items' => http_build_query($items, '$item_')]);
      ?>
    <button rel="{{url('admin/sortable')}}" type="button" 
      class="btn btn-default make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Update Display Order">
    <span class="glyphicon glyphicon-sort"></span>Sort
    </button>
    @endif
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table class="table table-bordered table-striped datatable-first-column-asc">
      <thead>
        <tr>
          <th>Order#</th>
          <th></th>
          <th>Name</th>
          <td>Status</td>
          <td></td>
          <td></td>
        </tr>
      </thead>
      <tbody>
        @foreach( $properties as $property )
        <tr>
          <td>
            {{$property->display_order}}
          </td>
          <td>
            @if(isset($property->images->first()->image_small))
            <img class="image-100 img-responsive" src="{{asset($property->images->first()->image_small)}}" alt="{{$property->title}}">
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
          <td><a href="#" rel="{{url('admin/reservations/create/'.$property->slug)}}" 
            class="iframe-form-open make-modal-large btn btn-success" 
            data-toggle="modal" data-target="#iframeModal" 
            title="Add Reservation to: {{$property->title}}">
            <span class="fa fa-plane"></span>
            </a>
          </td>
          <td>
            <a href="#" rel="{{url('admin/properties/edit/'.$property->id)}}" 
              class="iframe-form-open make-modal-large btn btn-default" 
              data-toggle="modal" data-target="#iframeModal" 
              title="Edit Property: {{$property->title}}">
            <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a href="javascript:confirmDelete('{{url('/admin/properties/delete/'.$property->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
            <span class="glyphicon glyphicon-remove"></span>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th>Order#</th>
          <th></th>
          <th>Name</th>
          <td>Status</td>
          <th></th>
          <th></th>
        </tr>
      </tfoot>
    </table>
    <span class="bg-danger">Note:</span> Maximum 6 featured properties can show on the home page.<br/>
    Only active properties will be available for frontend use.
  </div>
  <!-- /.box-body -->
</div>
@endsection
