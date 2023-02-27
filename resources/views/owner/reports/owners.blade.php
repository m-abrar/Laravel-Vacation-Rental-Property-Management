@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Owner Reports
  <small>Run Reports to find Total Lodging amount minus the commission paid to owners of properties Booked</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Owner Reports</li>
</ol>
<br/>
@endsection
@section('contents')
@include('admin.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <div class="col-md-12">
      <form action="{{ url('/admin/reports/owners') }}" method="get" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div col="col-md-6">
          <div class="form-group">
            <label>Select Owner:</label>
            <select name="owner_id" class="form-control">
            <option value="0" 
            @if ($owner_id=='' or $owner_id==0)) {{ 'selected="selected"' }} @endif>
            - all - 
            </option>
            @foreach ($owners as $owner)
            <option value="{{ $owner->id }}"
            @if ($owner_id == $owner->id) {!!'selected="selected"'!!} 
            @endif>
            {!!$owner->firstname!!} {!!$owner->lastname!!}
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
          <th><strong>Date</strong></th>
          <th><strong>Guest</strong></th>
          <th><strong>Property</strong></th>
          <th><strong># of days</strong></th>
          <th><strong>Owner</strong></th>
          <th><strong>Lodging Total</strong></th>
          <th><strong>Commission</strong></th>
          <th><strong>Amount</strong></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $total_amount_lodging = 0;
          $total_amount_commission = 0;
          $total_amount_owner = 0;
          ?>
        @foreach($reports as $report)
        <?php
          $owner_id = 0;
          $lodging_amount = $report->lodging_amount;
          $commission = $report->property->is_commission==1?$report->lodging_amount*$report->property->commission_value/100:0;
          $owner_amount = $lodging_amount - $commission;
          $total_amount_lodging += $lodging_amount;
          $total_amount_commission += $commission;
          $total_amount_owner += $owner_amount;
          ?>
        <tr>
          <td>{{date('m/d/Y',strtotime($report->date_start))}}</td>
          <td>{{$report->firstname}} {{$report->lastname}}</td>
          <td>{{$report->property->title}}</td>
          <td>{{intval( ( strtotime( $report->date_end ) - strtotime( $report->date_start ) ) / 86400 )}}</td>
          <td>{{$report->property->owner->firstname}} {{$report->property->owner->lastname}}</td>
          <td>${{number_format($lodging_amount)}}</td>
          <td>${{number_format($commission)}} &nbsp;&nbsp;&nbsp; ({{$report->property->commission_value}}%)</td>
          <td>${{number_format($owner_amount)}}</td>
        </tr>
        @endforeach
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>Total:</td>
          <td>${{number_format($total_amount_lodging)}}</td>
          <td>${{number_format($total_amount_commission)}}</td>
          <td>${{number_format($total_amount_owner)}}</td>
        </tr>
      </tbody>
    </table>
    <div calss="row">
      <strong>Total Lodging:</strong> ${{number_format($total_amount_lodging,2)}}<br/>
      <strong>Total Commission:</strong> ${{number_format($total_amount_commission,2)}}<br/>
      <strong>Total Owner:</strong> ${{number_format($total_amount_owner,2)}}<br/>
    </div>
  </div>
  <!-- /.box-body -->
</div>
@endsection
