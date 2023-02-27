@extends('owner.layouts.default.start')
@section('heading')
<h1>
  Transactions
  <small>Payments for bookings</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{url('/owner/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">Transactions</li>
</ol>
<br/>
@endsection
@section('contents')
@include('owner.layouts.objects.iframe-modal')
<div class="box">
  <div class="box-header">
    <!-- <button rel="{{url('owner/transactions/create')}}" type="button" 
      class="btn btn-info make-modal-large iframe-form-open" 
      data-toggle="modal" data-target="#iframeModal" title="Add transaction">
        <span class="glyphicon glyphicon-plus"></span>Add
      </button> -->
    <button class="btn btn-success reload-page">
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="nav-tabs-custom">
      <!-- Tabs within a box -->
      <ul class="nav nav-tabs pull-right ui-sortable-handle">
        <li class=""><a href="#transactions-due" data-toggle="tab" aria-expanded="false">Due/Pending <span class="badge bg-blue">{{count($transactions_due)}}</span></a></li>
        <li class="active"><a href="#transactions-received" data-toggle="tab" aria-expanded="true">Received <span class="badge bg-green">{{count($transactions_received)}}</span></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="transactions-received" style="margin:10px">
          <table class="table table-bordered table-striped datatable-first-column-desc">
            <thead>
              <tr>
                <th>Received</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Deposit Term</th>
                <th>Guest</th>
                <th>Property</th>
                <td></td>
              </tr>
            </thead>
            <tbody>
              @foreach( $transactions_received as $transaction )
              <tr>
                <td>
                  <?=date('m/d/Y',strtotime($transaction->date_paid))?>
                </td>
                <td>${{$transaction->amount}}
                </td>
                <td>
                  @if($transaction->is_seen=='0')
                  <span class="label label-primary">New</span>
                  @else
                  <span class="label label-success"><?=ceil(abs(strtotime($transaction->date_paid) - time()) / 86400)?> days ago</span>
                  @endif
                </td>
                <td>{{ucwords($transaction->deposit_term)}}</td>
                <td>{{@$transaction->reservation->firstname}} {{@$transaction->reservation->lastname}}</td>
                <td>{{@$transaction->reservation->property->title}}</td>
                <td>
                  <a href="{{url('/owner/reservations/show/'.@$transaction->reservation->id)}}" class="btn btn-default">
                  <span class="glyphicon glyphicon-search"></span>
                  </a>
                  
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>Received</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Deposit Term</th>
                <th>Guest</th>
                <th>Property</th>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="tab-pane" id="transactions-due" style="margin:10px">
          <table class="table table-bordered table-striped datatable-first-column-asc">
            <thead>
              <tr>
                <th>Due</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Deposit Term</th>
                <th>Guest</th>
                <th>Property</th>
                <td></td>
              </tr>
            </thead>
            <tbody>
              @foreach( $transactions_due as $transaction )
              <tr>
                <td>
                  <?=date('m/d/Y',strtotime($transaction->date_due))?> 
                </td>
                <td>${{@$transaction->amount}}</td>
                <td>
                  <?php if(strtotime($transaction->date_due)<time()){?>
                  <span class="label label-danger"> Over Due </span>
                  <?php }else{ ?>
                  <span class="label label-default"><?=ceil(abs(strtotime($transaction->date_due) - time()) / 86400)?> days</span>
                  <?php } ?>
                </td>
                <td>{{ucwords($transaction->deposit_term)}}</td>
                <td>{{@$transaction->reservation->firstname}} {{@$transaction->reservation->lastname}}</td>
                <td>{{@$transaction->reservation->property->title}}</td>
                <td>
                  <a href="{{url('/owner/reservations/show/'.@$transaction->reservation->id)}}" class="btn btn-default">
                  <span class="glyphicon glyphicon-search"></span>
                  </a>
                  
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>Due</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Deposit Term</th>
                <th>Guest</th>
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
