@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Seasons
  <small>Sections of year for rental rates at different dates.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Seasons</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <button rel="{{url('admin/seasons/create')}}" type="button" 
      class="btn btn-info make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Add Season">
    <span class="glyphicon glyphicon-plus"></span>Add
    </button>
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
    <?php 
      $counter = 0;
      foreach( $seasons as $season ){
        $items['id'][$counter] = $season->id;
        $items['display_order'][$counter] = $season->display_order;
        $items['image'][$counter] = $season->image;
        $items['title'][$counter] = $season->title;
        $counter++;
      }
      ?>
    @if(isset($items))
    <?php
      session(['model'=>'Seasons']);
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
          <th>Title</th>
          <td></td>
        </tr>
      </thead>
      <tbody>
        @foreach( $seasons as $season )
        <tr>
          <td>{{$season->display_order}}</td>
          <td>{{$season->title}}</td>
          <td>
            <a href="#" rel="{{url('admin/seasons/edit/'.$season->id)}}" 
              class="iframe-form-open make-modal-large btn btn-default" 
              data-toggle="modal" data-target="#iframeModal" 
              title="Edit Season: {{$season->title}}">
            <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a href="javascript:confirmDelete('{{url('/admin/seasons/delete/'.$season->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
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
