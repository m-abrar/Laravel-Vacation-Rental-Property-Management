@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Property Classes
  <small>Categories of your Properties, like Homes, Condominiums, Apartments.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Property Classes</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <button rel="{{url('admin/property-classes/create')}}" type="button" 
      class="btn btn-info make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Add Property Class">
    <span class="glyphicon glyphicon-plus"></span>Add
    </button>
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
    <?php 
      $counter = 0;
      foreach( $propertyclasses as $propertyclass ){
        $items['id'][$counter] = $propertyclass->id;
        $items['display_order'][$counter] = $propertyclass->display_order;
        $items['image'][$counter] = $propertyclass->image;
        $items['title'][$counter] = $propertyclass->title;
        $counter++;
      }
      ?>
    @if(isset($items))
    <?php
      session(['model'=>'PropertyClasses']);
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
        @foreach($propertyclasses as $propertyclass )
        <tr>
          <td>{{$propertyclass->display_order}}</td>
          <td>
            @if(is_file($propertyclass->image))
            <img class="image-100 img-responsive" 
              src="{{asset($propertyclass->image)}}" alt="{{$propertyclass->title}}">
            @endif
          </td>
          <td>{{$propertyclass->title}}</td>
          <td>
            <a href="#" rel="{{url('admin/property-classes/edit/'.$propertyclass->id)}}" 
              class="iframe-form-open make-modal-large btn btn-default" 
              data-toggle="modal" data-target="#iframeModal" 
              title="Edit Property class: {{$propertyclass->title}}">
            <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a href="javascript:confirmDelete('{{url('/admin/property-classes/delete/'.$propertyclass->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
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
