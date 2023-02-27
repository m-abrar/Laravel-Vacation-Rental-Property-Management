@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Services
  <small>Attributes to make your property prominent. Can show, dimentions, area, etc.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Services</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <button rel="{{url('admin/services/create')}}" type="button" 
      class="btn btn-info make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Add Service">
    <span class="glyphicon glyphicon-plus"></span>Add
    </button>
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
    <?php 
      $counter = 0;
      foreach( $services as $service ){
        $items['id'][$counter] = $service->id;
        $items['display_order'][$counter] = $service->display_order;
        $items['image'][$counter] = $service->image;
        $items['title'][$counter] = $service->title;
        $counter++;
      }
      ?>
    @if(isset($items))
    <?php
      session(['model'=>'Services']);
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
          <th>Price</th>
          <td></td>
        </tr>
      </thead>
      <tbody>
        @foreach( $services as $service )
        <tr>
          <td>{{$service->display_order}}</td>
          <td>@if(is_file($service->image))
            <img class="image-100 img-responsive" 
              src="{{asset($service->image)}}" alt="{{$service->title}}">
            @endif</td>
          <td>{{$service->title}}
          </td>
          <td>
          ${{number_format($service->price,2)}}
          </td>
          <td>
            <a href="#" rel="{{url('admin/services/edit/'.$service->id)}}" 
              class="iframe-form-open make-modal-large btn btn-default" 
              data-toggle="modal" data-target="#iframeModal" 
              title="Edit Service: {{$service->title}}">
            <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a href="javascript:confirmDelete('{{url('/admin/services/delete/'.$service->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
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
          <th>Price</th>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>
@endsection
