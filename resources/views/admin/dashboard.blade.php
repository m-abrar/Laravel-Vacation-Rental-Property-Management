@extends('admin.layouts.default.start')
@section('heading')
<h1>
  Dashboard
  <small>Control Panel</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Dashboard</li>
</ol>



@endsection
@section('contents')
<div class="row">
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>{{$dashboard->bookings}}</h3>
        <p>New Bookings</p>
      </div>
      <div class="icon">
        <i class="ion-ios-personadd-outline"></i>
      </div>
      <a href="{{url('admin/reservations')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>{{$dashboard->transactions}}</h3>
        <p>Transactions</p>
      </div>
      <div class="icon">
        <i class="ion-social-usd-outline"></i>
      </div>
      <a href="{{url('admin/transactions')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{$dashboard->arrivals}}</h3>
        <p>Arrivals</p>
      </div>
      <div class="icon">
        <i class="ion-ios-download-outline"></i>
      </div>
      <a href="{{url('admin/reservations')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3>{{$dashboard->departures}}</h3>
        <p>Departures</p>
      </div>
      <div class="icon">
        <i class="ion-ios-upload-outline"></i>
      </div>
      <a href="{{url('admin/reservations')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>
<div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Note!</strong>
  The demo data is publicly accessed, we therefore refresh it every hour.
</div>


<section>
  <div class="box">
    <div class="box-body">
      <!-- PAGE BODY STARTS -->
      <div class="col-md-12 text-right">
        <a href="{{url('admin/reservations/search')}}" class="btn btn-info btn-lg">
        <span class="glyphicon glyphicon-plus"></span> Add Reservation
        </a>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
</section>
<section>
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Newest Reservations</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Guest</th>
            <th>Email</th>
            <th>Dates</th>
            <th>Reserved</th>
            <th></th>
            <th>Property</th>
          </tr>
        </thead>
        <tbody>
          @foreach($reservations_new as $reservation)
          <tr>
            <td>{{$reservation->firstname}} {{$reservation->lastname}}</td>
            <td>{{$reservation->email}}</td>
            <td><?=date('m/d/Y',strtotime($reservation->date_start))?> - <?=date('m/d/Y',strtotime($reservation->date_end))?></td>
            <td><?=date('m/d/Y h:i a',strtotime($reservation->created_at))?></td>
            <td><a href="{{url('admin/reservations/show/'.$reservation->id)}}">view</a></td>
            <td>{{@$reservation->property->title}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Arrivals</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Guest</th>
                <th>Property</th>
                <th>Check-in</th>
              </tr>
            </thead>
            <tbody>
              @foreach(@$arrivals as $arrival)
              <tr>
                <td>
                  {{@$arrival->firstname}} {{@$arrival->lastname}}
                </td>
                <td>{{@$arrival->property->title}}</td>
                <td><?=date('m/d/Y',strtotime(@$arrival->date_start))?></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Departures</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Guest</th>
                <th>Property</th>
                <th>Check-out</th>
              </tr>
            </thead>
            <tbody>
              @foreach($departures as $departure)
              <tr>
                <td>
                  {{$departure->firstname}} {{$departure->lastname}}
                </td>
                <td>{{@$departure->property->title}}</td>
                <td><?=date('m/d/Y',strtotime($departure->date_end))?></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Payments Received</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Guest</th>
                <th>Amount</th>
                <th>Received on</th>
              </tr>
            </thead>
            <tbody>
              @foreach($transactions_received as $transaction)
              <tr>
                <td>
                  {{$transaction->reservation->firstname}} 
                  {{$transaction->reservation->lastname}}
                </td>
                <td>${{$transaction->amount}}</td>
                <td><?=date('m/d/Y',strtotime($transaction->date_paid))?></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Payments Coming</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Guest</th>
                <th>Amount</th>
                <th>Due on</th>
              </tr>
            </thead>
            <tbody>
              @foreach($transactions_coming as $transaction)
              <tr>
                <td>
                  {{@$transaction->reservation->firstname}} 
                  {{@$transaction->reservation->lastname}}
                </td>
                <td>${{@$transaction->amount}}</td>
                <td>{{date('m/d/Y',strtotime(@$transaction->date_due))}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
  <!-- PAGE BODY ENDS -->
</section>
@endsection
