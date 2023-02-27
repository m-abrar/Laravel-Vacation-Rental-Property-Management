@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Add Ons
  <small>Addons with Reservation Bookings. Can include both mandatory and optional extra services, purchases, taxes.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Add Ons</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <button rel="{{url('admin/line-items/create')}}" type="button" 
      class="btn btn-info make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Add Add On">
    <span class="glyphicon glyphicon-plus"></span>Add
    </button>
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
    <?php 
      $counter = 0;
      foreach( $lineitems as $lineitem ){
        $items['id'][$counter] = $lineitem->id;
        $items['display_order'][$counter] = $lineitem->display_order;
        $items['image'][$counter] = $lineitem->image;
        $items['title'][$counter] = $lineitem->title;
        $counter++;
      }
      ?>
    @if(isset($items))
    <?php
      session(['model'=>'LineItems']);
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
        @foreach( $lineitems as $lineitem )
        <tr>
          <td>{{$lineitem->display_order}}</td>
          <td>{{$lineitem->title}}</td>
          <td>
            <a href="#" rel="{{url('admin/line-items/edit/'.$lineitem->id)}}" 
              class="iframe-form-open make-modal-large btn btn-default" 
              data-toggle="modal" data-target="#iframeModal" 
              title="Edit Add On: {{$lineitem->title}}">
            <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a href="javascript:confirmDelete('{{url('/admin/line-items/delete/'.$lineitem->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
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
