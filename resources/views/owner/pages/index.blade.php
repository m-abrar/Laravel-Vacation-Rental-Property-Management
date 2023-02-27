@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Pages
  <small>Site contents; includes pages, news, events, blogs, etc.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Pages</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
@include('admin.layouts.objects.iframe-modal-simple')
<div class="box">
  <div class="box-header">
    <button rel="{{url('admin/pages/create')}}" type="button" 
      class="btn btn-info make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Add Property">
    <span class="glyphicon glyphicon-plus"></span>Add
    </button>
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
    <?php 
      $counter = 0;
      foreach( $pages as $page ){
        $items['id'][$counter] = $page->id;
        $items['display_order'][$counter] = $page->display_order;
        $items['image'][$counter] = $page->images->first()->image;
        $items['title'][$counter] = $page->title;
        $counter++;
      }
      ?>
    @if(isset($items))
    <?php
      session(['model'=>'Pages']);
      session(['counter' => $counter]);
      session(['items' => http_build_query($items, '$item_')]);
      ?>
    <button rel="{{url('admin/sortable')}}" type="button" 
      class="btn btn-default make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModalSimple" title="Update Display Order">
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
        </tr>
      </thead>
      <tbody>
        @foreach( $pages as $page )
        <tr>
          <td>{{$page->display_order}}</td>
          <td>
            @if(isset($page->images->first()->image))
            <img class="image-100 img-responsive" src="{{asset($page->images->first()->image)}}" alt="{{$page->title}}">
            ({{count($page->images)}})
            @endif
          </td>
          <td>
            <h4>{{$page->title}}</h4>
            <p>{{@$page->category->title}}</p>
          </td>
          <td>
            <ul>
              @if($page->is_active=='1')
              <li>Active</li>
              @endif
              @if($page->is_featured=='1')
              <li>Featured</li>
              @endif
              @if($page->is_new=='1')
              <li>New</li>
              @endif
              @if($page->is_home=='1')
              <li>Home page</li>
              @endif
            </ul>
          </td>
          <td>
            <a href="#" rel="{{url('admin/pages/edit/'.$page->id)}}" 
              class="iframe-form-open make-modal-large btn btn-default" 
              data-toggle="modal" data-target="#iframeModal" 
              title="Edit Property: {{$page->title}}">
            <span class="glyphicon glyphicon-pencil"></span>
            </a>
            <a href="javascript:confirmDelete('{{url('/admin/pages/delete/'.$page->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
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
        </tr>
      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>
@endsection
