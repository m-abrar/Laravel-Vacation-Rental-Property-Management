@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Locations
  <small>Add the provinces/states you want to work with.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Locations</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <button rel="{{url('admin/locations/create')}}" type="button" 
      class="btn btn-info make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Add Location">
    <span class="glyphicon glyphicon-plus"></span>Add
    </button>
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
    <?php 
      $counter = 0;
      foreach( $locations as $location ){
        $items['id'][$counter] = $location->id;
        $items['display_order'][$counter] = $location->display_order;
        $items['image'][$counter] = $location->image;
        $items['title'][$counter] = $location->title;
        $counter++;
      }
      ?>
    @if(isset($items))
    <?php
      session(['model'=>'locations']);
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
          <th>Picture</th>
          <th>Title</th>
          <th>Status</th>
          <td></td>
        </tr>
      </thead>
      <tbody>
        @foreach($locations as $location )
        <tr>
          <td>{{$location->display_order}}</td>
          <td>
            @if(is_file($location->image))
            <img class="image-100 img-responsive" 
              src="{{asset($location->image)}}" alt="{{$location->title}}">
            @endif
          </td>
          <td>{{$location->title}}</td>
          <td>{{$location->is_active==1?'Active':'Disabled'}}</td>
          <td>
            <a href="#" rel="{{url('admin/locations/edit/'.$location->id)}}" 
              class="iframe-form-open make-modal-large btn btn-default" 
              data-toggle="modal" data-target="#iframeModal" 
              title="Edit Location: {{$location->title}}">
            <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a href="javascript:confirmDelete('{{url('/admin/locations/delete/'.$location->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
            <span class="glyphicon glyphicon-remove"></span>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th>Order#</th>
          <th>Picture</th>
          <th>Title</th>
          <th>Status</th>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>
@endsection
