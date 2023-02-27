@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Sliders
  <small>The rotating headers/banners for the website home page.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Sliders</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <button rel="{{url('admin/sliders/create')}}" type="button" 
      class="btn btn-info make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Add Slider">
    <span class="glyphicon glyphicon-plus"></span>Add
    </button>
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
    <?php 
      $counter = 0;
      foreach( $sliders as $slider ){
        $items['id'][$counter] = $slider->id;
        $items['display_order'][$counter] = $slider->display_order;
        $items['image'][$counter] = $slider->image;
        $items['title'][$counter] = $slider->title;
        $counter++;
      }
      ?>
    @if(isset($items))
    <?php
      session(['model'=>'Sliders']);
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
    <table class="table table-bordered table-striped datatable-first-column-desc">
      <thead>
        <tr>
          <th>Order#</th>
          <th>Picture</th>
          <th>Title</th>
          <td></td>
        </tr>
      </thead>
      <tbody>
        @foreach( $sliders as $slider )
        <tr>
          <td>{{$slider->display_order}}</td>
          <td>
            @if(is_file($slider->image))
            <img class="image-100 img-responsive" 
              src="{{asset($slider->image)}}" alt="{{$slider->title}}">
            @endif
          </td>
          <td>{{@$slider->title}}</td>
          <td>
            <a href="#" rel="{{url('/admin/sliders/edit/'.$slider->id)}}" 
              class="iframe-form-open make-modal-large btn btn-default" 
              data-toggle="modal" data-target="#iframeModal" 
              title="Edit Slider: {{$slider->title}}">
            <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a href="javascript:confirmDelete('{{url('/admin/sliders/delete/'.$slider->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
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
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>
@endsection
