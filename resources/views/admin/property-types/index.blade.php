@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Property Types
  <small>Categories of your Properties, like Homes, Condominiums, Apartments.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Property Types</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <button rel="{{url('admin/property-types/create')}}" type="button" 
      class="btn btn-info make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Add Property Type">
    <span class="glyphicon glyphicon-plus"></span>Add
    </button>
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
    <?php 
      $counter = 0;
      foreach( $propertytypes as $propertytype ){
        $items['id'][$counter] = $propertytype->id;
        $items['display_order'][$counter] = $propertytype->display_order;
        $items['image'][$counter] = $propertytype->image;
        $items['title'][$counter] = $propertytype->title;
        $counter++;
      }
      ?>
    @if(isset($items))
    <?php
      session(['model'=>'PropertyTypes']);
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
          <td></td>
        </tr>
      </thead>
      <tbody>
        @foreach($propertytypes as $propertytype )
        <tr>
          <td>{{$propertytype->display_order}}</td>
          <td>
            @if(is_file($propertytype->image))
            <img class="image-100 img-responsive" 
              src="{{asset($propertytype->image)}}" alt="{{$propertytype->title}}">
            @endif
          </td>
          <td>{{$propertytype->title}}</td>
          <td>
            <a href="#" rel="{{url('admin/property-types/edit/'.$propertytype->id)}}" 
              class="iframe-form-open make-modal-large btn btn-default" 
              data-toggle="modal" data-target="#iframeModal" 
              title="Edit Property Type: {{$propertytype->title}}">
            <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a href="javascript:confirmDelete('{{url('/admin/property-types/delete/'.$propertytype->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
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
