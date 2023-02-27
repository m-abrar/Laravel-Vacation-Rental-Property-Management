@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Housekeepers Reports
  <small>Run Reports to find jobs assigned to housekeepers.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Housekeepers Reports</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <div class="col-md-12">
      <form action="{{ url('/admin/reports/housekeepers') }}" method="get" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div col="col-md-6">
          <div class="form-group">
            <label>Select Housekeeper:</label>
            <select name="housekeeper_id" class="form-control">
            <option value="0" 
            @if ($housekeeper_id=='' or $housekeeper_id==0)) {{ 'selected="selected"' }} @endif>
            - all - 
            </option>
            @foreach ($housekeepers as $housekeeper)
            <option value="{{ $housekeeper->id }}"
            @if ($housekeeper_id == $housekeeper->id) {!!'selected="selected"'!!} 
            @endif>
            {!!$housekeeper->firstname!!} {!!$housekeeper->lastname!!}
            </option>
            @endforeach
            </select>
          </div>
        </div>
        <div col="col-md-6">
          <!-- Date range -->
          <div class="form-group">
            <label>Select Dates:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input 
                type="text"
                name = "search_dates"
                class="date-range form-control pull-right"
                value="@if(old('search_dates')){!! old('search_dates') !!}@elseif(isset($search_dates)){{$search_dates}}@endif"
                />
              <span class="input-group-btn">
              <button type="submit" class="btn btn-info btn-flat" type="button">Go!</button>
              </span>
            </div>
            <!-- /.input group -->
          </div>
        </div>
        <!-- /.form group -->
      </form>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table class="table table-bordered table-striped datatable-first-column-asc">
      <thead>
        <tr>
          <th>Arrival</th>
          <th>Departure</th>
          <th># of days</th>
          <th>Guest</th>
          <th>Property</th>
          <th>Housekeeper</th>
        </tr>
      </thead>
      <tbody>
        @foreach($reports as $report)
        <tr>
          <td>{{date('m/d/Y',strtotime($report->date_start))}}</td>
          <td>{{date('m/d/Y',strtotime($report->date_end))}}</td>
          <td>{{intval( ( strtotime( $report->date_end ) - strtotime( $report->date_start ) ) / 86400 )}}</td>
          <td>{{$report->firstname}} {{$report->lastname}}</td>
          <td>{{$report->property->title}}</td>
          <td>{{$report->property->housekeeper->firstname}} {{$report->property->housekeeper->lastname}}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th>Arrival</th>
          <th>Departure</th>
          <th># of days</th>
          <th>Guest</th>
          <th>Property</th>
          <th>Housekeeper</th>
        </tr>
      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>
@endsection
