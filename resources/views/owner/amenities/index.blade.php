@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Amenities
  <small>The available facilities at your property. For example, Internet, Air Conditioning, Washers &amp; Dryer.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Amenities</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <button rel="{{url('admin/amenities/create')}}" type="button" 
      class="btn btn-info make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Add Amenity">
    <span class="glyphicon glyphicon-plus"></span>Add
    </button>
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
    <?php 
      $counter = 0;
      foreach( $amenities as $amenity ){
        $items['id'][$counter] = $amenity->id;
        $items['display_order'][$counter] = $amenity->display_order;
        $items['image'][$counter] = $amenity->image;
        $items['title'][$counter] = $amenity->title;
        $counter++;
      }
      ?>
    @if(isset($items))
    <?php
      session(['model'=>'Amenities']);
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
          <th>Title</th>
          <td></td>
        </tr>
      </thead>
      <tbody>
        @foreach( $amenities as $amenity )
        <tr>
          <td>{{$amenity->display_order}}</td>
          <td>{{$amenity->title}}</td>
          <td>
            <a href="#" rel="{{url('admin/amenities/edit/'.$amenity->id)}}" 
              class="iframe-form-open make-modal-large btn btn-default" 
              data-toggle="modal" data-target="#iframeModal" 
              title="Edit Amenity: {{$amenity->title}}">
            <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a href="javascript:confirmDelete('{{url('/admin/amenities/delete/'.$amenity->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
            <span class="glyphicon glyphicon-remove"></span>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th>Order#</th>
          <th>Title</th>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>
@endsection
