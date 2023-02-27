@extends('admin.layouts.default.start')
@section('contents')
<div class="box">
  <div class="box-body">
    <fieldset class="col-md-12">
      <legend>Guest Detail</legend>
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-md-4 control-label">First Name</label>
          <div class="col-md-8">
            {{$reservation->firstname}}
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">Last Name</label>
          <div class="col-md-8">
            {{$reservation->lastname}}
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">Email</label>
          <div class="col-md-8">
            {{$reservation->email}}
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">Phone</label>
          <div class="col-md-8">
            {{$reservation->phone}}
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">Adults</label>
          <div class="col-md-8">{{$reservation->adults}}</div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">Children</label>
          <div class="col-md-8">{{$reservation->children}}</div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">Pets</label>
          <div class="col-md-8">{{$reservation->pets}}</div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-md-4 control-label">Address Line 1</label>
          <div class="col-md-8">
            {{$reservation->address_line_1}}
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">Address Line 2</label>
          <div class="col-md-8">
            {{$reservation->address_line_2}}
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">City</label>
          <div class="col-md-8">
            {{$reservation->city}}
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">State</label>
          <div class="col-md-8">
            {{@$reservation->location->title}}
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">Zip</label>
          <div class="col-md-8">
            {{$reservation->zip}}
          </div>
        </div>
      </div>
    </fieldset>
    <fieldset class="col-md-12 table-bordered">
      <legend>Calendar &amp; Accounts</legend>
      <div class="col-xs-12 col-sm-6">
        <div class="form-group row">
          <label class="col-md-4 control-label">Check-in</label>
          <div class="col-md-8">
            <?=date('m/d/Y',strtotime($reservation->date_start))?>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">Check-out</label>
          <div class="col-md-8">
            <?=date('m/d/Y',strtotime($reservation->date_end))?>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="form-group row">
          <label class="col-md-4 control-label">Lodging:</label>
          <div class="col-md-8">
            ${{$reservation->lodging_amount}}
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">Sub Total</label>
          <div class="col-md-8">
            {!!nl2br($reservation->sub_total_detail)!!}
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">Total</label>
          <div class="col-md-8">
            ${{$reservation->total_amount}}
          </div>
        </div>
      </div>
    </fieldset>
    <fieldset class="col-md-12 table-bordered">
      <legend>For Office Use</legend>
      <div class="col-xs-12 col-md-6">
        <div class="form-group row">
          <label class="col-md-4 control-label">Housekeeper:</label>
          <div class="col-md-8">
            {!!@$reservation->housekeeper->firstname!!} {!!@$reservation->housekeeper->lastname!!}
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">Vendor:</label>
          <div class="col-md-8">
            {!!@$reservation->vendor->firstname!!} {!!@$reservation->vendor->lastname!!}
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 control-label">Status:</label>
          <div class="col-md-8">
            {{$reservation->status}}
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-6">
        <div class="form-group row">
          <label class="col-sm-3col-md-8 control-label">Admin Notes</label>
          <div class="col-sm-9col-md-8">
            {!!$reservation->notes!!}
          </div>
        </div>
      </div>
    </fieldset>
    @foreach($reservation->transactions as $transaction)
    ${{$transaction->amount}} 
    @if($transaction->status=='pending')
    Due: {{$transaction->date_due}} 
    @endif
    @if($transaction->status=='paid')
    Paid: {{$transaction->date_paid}} 
    @endif
    Created: {{$transaction->created_at}} 
    <br/>
    @endforeach
    <form action="{{ url('/admin/reservations/approve') }}" method="post">
      <div class="form-group row">
        <div class="col-md-3"></div>
        <div class="col-md-9">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="{{ $reservation->id }}">
          <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> OK </button>
          <a href="{{url('admin/reservations')}}" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Back </a>
        </div>
      </div>
    </form>
  </div>
  <!-- /.box-body -->
</div>
@endsection
