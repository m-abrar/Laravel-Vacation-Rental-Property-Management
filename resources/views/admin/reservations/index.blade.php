@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Reservations
  <small>Manage Guests/Property Bookings</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Reservations</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <a href="{{url('admin/reservations/search')}}" type="button" 
      class="btn btn-info" title="Add Reservation">
    <span class="glyphicon glyphicon-plus"></span> Add
    </a>
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="nav-tabs-custom">
      <!-- Tabs within a box -->
      <ul class="nav nav-tabs pull-right ui-sortable-handle">
        <li class=""><a href="#reservations-all" data-toggle="tab" aria-expanded="false"><strong>All</strong> <span class="badge bg-gray">{{count($reservations_all)}}</span>  </a></li>
        <li class=""><a href="#reservations-history" data-toggle="tab" aria-expanded="false"><strong>History</strong> <span class="badge bg-orange">{{count($reservations_history)}}</span>  </a></li>
        <li class=""><a href="#reservations-current" data-toggle="tab" aria-expanded="false"><strong>Current</strong> <span class="badge bg-green">{{count($reservations_current)}}</span>  </a></li>
        <li class="active"><a href="#reservations-new" data-toggle="tab" aria-expanded="true"><strong>New</strong> <span class="badge bg-blue">{{count($reservations_new)}}</span> </a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="reservations-new" style="margin:10px">
        <!-- NEW -->
          <table class="table table-bordered table-striped datatable-first-column-desc">
            <thead>
              <tr>
                <th>Created</th>
                <th>In</th>
                <th>Out</th>
                <th>Guest</th>
                <th>Status</th>
                <th>Property</th>
                <td></td>
              </tr>
            </thead>
            <tbody>
              @foreach( $reservations_new as $reservation )
              <tr>
                <td><?=date('m/d/Y H:i',strtotime($reservation->created_at))?></td>
                <td><?=date('m/d/Y',strtotime($reservation->date_start))?></td>
                <td><?=date('m/d/Y',strtotime($reservation->date_end))?></td>
                <td>
                  {{$reservation->firstname}} {{$reservation->lastname}}<br/>
                  {{$reservation->email}}<br/>
                  {{$reservation->phone}}
                </td>
                <td>
                  @if($reservation->is_seen=='0')
                  <span class="label label-primary">New</span>
                  @elseif($reservation->status=='booked')
                  <span class="label label-success">Booked</span>
                  @elseif($reservation->status=='pending')
                  <span class="label label-warning">Pending</span>
                  @endif
                </td>
                <td>{{@$reservation->property->title}}</td>
                <td>
                  <a href="{{url('/admin/reservations/show/'.$reservation->id)}}" class="btn btn-default">
                  <span class="glyphicon glyphicon-search"></span>
                  </a>
                  <a href="#" rel="{{url('admin/reservations/edit/'.$reservation->id)}}" 
                    class="iframe-form-open make-modal-large btn btn-default" 
                    data-toggle="modal" data-target="#iframeModal" 
                    title="Edit Reservation: {{$reservation->firstname}} {{$reservation->lastname}}">
                  <span class="glyphicon glyphicon-pencil"></span>
                  </a>
                  <a href="javascript:confirmDelete('{{url('/admin/reservations/delete/'.$reservation->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
                  <span class="glyphicon glyphicon-remove"></span>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>Created</th>
                <th>In</th>
                <th>Out</th>
                <th>Guest</th>
                <th>Status</th>
                <th>Property</th>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="tab-pane" id="reservations-current" style="margin:10px">
          <table class="table table-bordered table-striped datatable-first-column-asc">
            <thead>
              <tr>
                <th>In</th>
                <th>Out</th>
                <th>Guest</th>
                <th>Status</th>
                <th>Property</th>
                <td></td>
              </tr>
            </thead>
            <tbody>
              @foreach( $reservations_current as $reservation )
              <tr>
                <td><?=date('m/d/Y',strtotime($reservation->date_start))?></td>
                <td><?=date('m/d/Y',strtotime($reservation->date_end))?></td>
                <td>
                  {{$reservation->firstname}} {{$reservation->lastname}}<br/>
                  {{$reservation->email}}<br/>
                  {{$reservation->phone}}
                </td>
                <td>
                  @if($reservation->is_seen=='0')
                  <span class="label label-primary">New</span>
                  @elseif($reservation->status=='booked')
                  <span class="label label-success">Booked</span>
                  @elseif($reservation->status=='pending')
                  <span class="label label-warning">Pending</span>
                  @endif
                </td>
                <td>{{@$reservation->property->title}}</td>
                <td>
                  <a href="{{url('/admin/reservations/show/'.$reservation->id)}}" class="btn btn-default">
                  <span class="glyphicon glyphicon-search"></span>
                  </a>
                  <a href="#" rel="{{url('admin/reservations/edit/'.$reservation->id)}}" 
                    class="iframe-form-open make-modal-large btn btn-default" 
                    data-toggle="modal" data-target="#iframeModal" 
                    title="Edit Reservation: {{$reservation->firstname}} {{$reservation->lastname}}">
                  <span class="glyphicon glyphicon-pencil"></span>
                  </a>
                  <a href="javascript:confirmDelete('{{url('/admin/reservations/delete/'.$reservation->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
                  <span class="glyphicon glyphicon-remove"></span>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>In</th>
                <th>Out</th>
                <th>Guest</th>
                <th>Status</th>
                <th>Property</th>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="tab-pane" id="reservations-history" style="margin:10px">
          <table class="table table-bordered table-striped datatable-first-column-desc">
            <thead>
              <tr>
                <th>Out</th>
                <th>In</th>
                <th>Guest</th>
                <th>Status</th>
                <th>Property</th>
                <td></td>
              </tr>
            </thead>
            <tbody>
              @foreach( $reservations_history as $reservation )
              <tr>
                <td><?=date('m/d/Y',strtotime($reservation->date_end))?></td>
                <td><?=date('m/d/Y',strtotime($reservation->date_start))?></td>
                <td>
                  {{$reservation->firstname}} {{$reservation->lastname}}<br/>
                  {{$reservation->email}}<br/>
                  {{$reservation->phone}}
                </td>
                <td>
                  @if($reservation->is_seen=='0')
                  <span class="label label-primary">New</span>
                  @elseif($reservation->status=='booked')
                  <span class="label label-success">Booked</span>
                  @elseif($reservation->status=='pending')
                  <span class="label label-warning">Pending</span>
                  @endif
                </td>
                <td>{{@$reservation->property->title}}</td>
                <td>
                  <a href="{{url('/admin/reservations/show/'.$reservation->id)}}" class="btn btn-default">
                  <span class="glyphicon glyphicon-search"></span>
                  </a>
                  <a href="#" rel="{{url('admin/reservations/edit/'.$reservation->id)}}" 
                    class="iframe-form-open make-modal-large btn btn-default" 
                    data-toggle="modal" data-target="#iframeModal" 
                    title="Edit Reservation: {{$reservation->firstname}} {{$reservation->lastname}}">
                  <span class="glyphicon glyphicon-pencil"></span>
                  </a>
                  <a href="javascript:confirmDelete('{{url('/admin/reservations/delete/'.$reservation->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
                  <span class="glyphicon glyphicon-remove"></span>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>Out</th>
                <th>In</th>
                <th>Guest</th>
                <th>Status</th>
                <th>Property</th>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="tab-pane" id="reservations-all" style="margin:10px">
          <table class="table table-bordered table-striped datatable-first-column-desc">
            <thead>
              <tr>
                <th>Created</th>
                <th>Out</th>
                <th>In</th>
                <th>Guest</th>
                <th>Status</th>
                <th>Property</th>
                <td></td>
              </tr>
            </thead>
            <tbody>
              @foreach( $reservations_all as $reservation )
              <tr>
                <td><?=date('m/d/Y',strtotime($reservation->created_at))?></td>
                <td><?=date('m/d/Y',strtotime($reservation->date_end))?></td>
                <td><?=date('m/d/Y',strtotime($reservation->date_start))?></td>
                <td>
                  {{$reservation->firstname}} {{$reservation->lastname}}<br/>
                  {{$reservation->email}}<br/>
                  {{$reservation->phone}}
                </td>
                <td>
                  @if($reservation->is_seen=='0')
                  <span class="label label-primary">New</span>
                  @elseif($reservation->status=='booked')
                  <span class="label label-success">Booked</span>
                  @elseif($reservation->status=='pending')
                  <span class="label label-warning">Pending</span>
                  @endif
                </td>
                <td>{{@$reservation->property->title}}</td>
                <td>
                  <a href="{{url('/admin/reservations/show/'.$reservation->id)}}" class="btn btn-default">
                  <span class="glyphicon glyphicon-search"></span>
                  </a>
                  <a href="#" rel="{{url('admin/reservations/edit/'.$reservation->id)}}" 
                    class="iframe-form-open make-modal-large btn btn-default" 
                    data-toggle="modal" data-target="#iframeModal" 
                    title="Edit Reservation: {{$reservation->firstname}} {{$reservation->lastname}}">
                  <span class="glyphicon glyphicon-pencil"></span>
                  </a>
                  <a href="javascript:confirmDelete('{{url('/admin/reservations/delete/'.$reservation->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
                  <span class="glyphicon glyphicon-remove"></span>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>Created</th>
                <th>Out</th>
                <th>In</th>
                <th>Guest</th>
                <th>Status</th>
                <th>Property</th>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
@endsection
