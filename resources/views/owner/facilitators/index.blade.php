@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Facilitators
  <small>Housekeepers, Maintenance Vendors.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Facilitators</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <button rel="{{url('admin/facilitators/create')}}" type="button" 
      class="btn btn-info make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Add Facilitator">
    <span class="glyphicon glyphicon-plus"></span>Add
    </button>
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="nav-tabs-custom">
      <!-- Tabs within a box -->
      <ul class="nav nav-tabs pull-right ui-sortable-handle">
        <li class=""><a href="#facilitators-vendors" data-toggle="tab" aria-expanded="false">Vendors <span class="badge bg-blue">{{count($facilitators_vendor)}}</span></a></li>
        <li class="active"><a href="#facilitators-housekeepers" data-toggle="tab" aria-expanded="true">Housekeepers <span class="badge bg-green">{{count($facilitators_housekeeper)}}</span></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="facilitators-housekeepers" style="margin:10px">
          <table class="table table-bordered table-striped datatable-first-column-asc">
            <thead>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
                <th>Email</th>
                <td></td>
              </tr>
            </thead>
            <tbody>
              @foreach( $facilitators_housekeeper as $facilitator )
              <tr>
                <td>{{$facilitator->firstname}}</td>
                <td>{{$facilitator->lastname}}</td>
                <td>{{ucwords($facilitator->role)}}</td>
                <td>{{$facilitator->email}}</td>
                <td>
                  <a href="#" rel="{{url('admin/facilitators/edit/'.$facilitator->id)}}" 
                    class="iframe-form-open make-modal-large btn btn-default" 
                    data-toggle="modal" data-target="#iframeModal" 
                    title="Edit Facilitator: {{$facilitator->firstname}} {{$facilitator->lastname}}">
                  <span class="glyphicon glyphicon-pencil"></span>
                  </a>
                  <a href="javascript:confirmDelete('{{url('/admin/facilitators/delete/'.$facilitator->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
                  <span class="glyphicon glyphicon-remove"></span>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
                <th>Email</th>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="tab-pane" id="facilitators-vendors" style="margin:10px">
          <table class="table table-bordered table-striped datatable-first-column-asc">
            <thead>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
                <th>Email</th>
                <td></td>
              </tr>
            </thead>
            <tbody>
              @foreach( $facilitators_vendor as $facilitator )
              <tr>
                <td>{{$facilitator->firstname}}</td>
                <td>{{$facilitator->lastname}}</td>
                <td>{{ucwords($facilitator->role)}}</td>
                <td>{{$facilitator->email}}</td>
                <td>
                  <a href="#" rel="{{url('admin/facilitators/edit/'.$facilitator->id)}}" 
                    class="iframe-form-open make-modal-large btn btn-default" 
                    data-toggle="modal" data-target="#iframeModal" 
                    title="Edit Facilitator: {{$facilitator->firstname}} {{$facilitator->lastname}}">
                  <span class="glyphicon glyphicon-pencil"></span>
                  </a>
                  <a href="javascript:confirmDelete('{{url('/admin/facilitators/delete/'.$facilitator->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
                  <span class="glyphicon glyphicon-remove"></span>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
                <th>Email</th>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    <small>Display order by first name.</small>
  </div>
  <!-- /.box-body -->
</div>
@endsection
