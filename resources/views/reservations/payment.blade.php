<!-- 
1. Enter credit card information to finishe a new reservation created
2. Also helps the customer to come on this page and deposit balance payment if any.
-->

@extends('layouts.default.start')
@section('title')
Payment | {{$property->title}} - {{$settings->site_title}}
@endsection
@section('contents')
<div class="container page-body">
  <!-- Page Heading/Breadcrumbs -->
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">{{trans('eminent.booking')}} <small>-
        <?= $property->title ?>
        </small> 
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php">{{trans('eminent.home')}}</a></li>
        <li><a href="properties.php">{{trans('eminent.booking')}}</a></li>
        <li class="active">
          <?= $property->title ?>
        </li>
      </ol>
    </div>
  </div>
  @include('include.alerts')
  <!-- /.row -->
  <div class="row">
    <div class="col-md-3">
      <div id="propertyMainImage"> <img class="img-responsive" src="{{asset($property->images->first()->image)}}" alt="{{$property->title}}" /> </div>
      <br>
      <div class="col-md-12">
        <div class="col-md-5 info-cell-small">
          {{trans('eminent.property.bedrooms')}}
          <div class="pull-right">
            <?= $property->bedrooms ?>
          </div>
        </div>
        <div class="col-md-5 info-cell-small">
          {{trans('eminent.property.bathrooms')}}
          <div class="pull-right">
            <?= $property->bathrooms ?>
          </div>
        </div>
        <div class="col-md-5 info-cell-small">
          {{trans('eminent.property.sleeps')}}
          <div class="pull-right">
            <?= $property->sleeps ?>
          </div>
        </div>
        <div class="col-md-5 info-cell-small">
          {{trans('eminent.property.garages')}}
          <div class="pull-right">
            <?= $property->garages ?>
          </div>
        </div>
        <div class="text-center"> 
            @foreach($property->classez as $class)
              <div class="col-md-6">
                <i class="glyphicon glyphicon-ok"></i>
                {{$class->theclass->title}}
              </div>
            @endforeach
          </div>
      </div>
      <nav>
        <ul class="pager">
          <li><a href="{{url('show/'.$property->slug)}}"><span aria-hidden="true">&larr;</span> {{trans('eminent.links.property-detail')}}</a></li>
        </ul>
      </nav>
    </div>
    <div class="col-md-5">
      <h3>{{trans('eminent.reservation.confirm-detail')}}</h3>
      <dl class="dl-horizontal">
        <dt>{{trans('eminent.reservation.first-name')}}</dt>
        <dd>
          <?= $reservation->firstname ?>
        </dd>
        <dt>{{trans('eminent.reservation.last-name')}}</dt>
        <dd>
          <?= $reservation->lastname ?>
        </dd>
        <dt>{{trans('eminent.reservation.email')}}</dt>
        <dd>
          <?= $reservation->email ?>
        </dd>
        <dt>{{trans('eminent.reservation.phone')}}</dt>
        <dd>
          <?= $reservation->phone ?>
        </dd>
        <dt>{{trans('eminent.reservation.city')}}</dt>
        <dd>
          <?= $reservation->city ?>
        </dd>
        <dt>{{trans('eminent.reservation.state')}}</dt>
        <dd>
          <?= @$reservation->location->title ?>
        </dd>
        <dt>{{trans('eminent.reservation.zip')}}</dt>
        <dd>
          <?= $reservation->zip ?>
        </dd>
      </dl>
      <dl class="dl-horizontal">
        <dt>{{trans('eminent.reservation.property-name')}}</dt>
        <dd>
          <?= $property->title ?>
        </dd>
        <dt>{{trans('eminent.reservation.date-of-arrival')}}</dt>
        <dd>
          <?= date("m/d/Y", strtotime($reservation->date_start)) ?>
        </dd>
        <dt>{{trans('eminent.reservation.date-of-departure')}}</dt>
        <dd>
          <?= date("m/d/Y", strtotime($reservation->date_end)) ?>
        </dd>
      </dl>
      <dl class="dl-horizontal">
        <dt>{{trans('eminent.reservation.lodging-amount')}}</dt>
        <dd>${{number_format($reservation->lodging_amount,2)}}
        </dd>
        @foreach ($reservation->services as $addon)
        <dt>
          <?= $addon->service->title ?>
        </dt>
        <dd>
        @if($addon->quantity>'0')
          ${{number_format($addon->price/$addon->quantity,2)}} x {{$addon->quantity}}
        @else
          {{trans('eminent.nill')}}
        @endif
        </dd>

        @endforeach
        @foreach ($lineitems as $lineitem)
        <dt>
          <?= $lineitem->title ?>
        </dt>
        <dd>${{number_format($lineitem->value,2)}}
        </dd>
        @endforeach
        <dt>{{trans('eminent.reservation.total-amount')}}</dt>
        <dd>${{number_format($reservation->total_amount,2)}}
        </dd>
      </dl>

      <?php 
        $amount_payable = 0;
        ?>
      @foreach ($transactions as $transaction)
      <dl class="dl-horizontal">
        <dt>{{trans('eminent.reservation.payment')}}</dt>
        <dd>${{number_format($transaction->amount,2)}}
        </dd>
        <dt>{{trans('eminent.reservation.deposit-term')}}</dt>
        <dd>
          <?= ucwords($transaction->deposit_term) ?>
        </dd>
        <dt>{{trans('eminent.reservation.status')}}Status</dt>
        <dd>
          <?= ucwords($transaction->status) ?>
        </dd>
        <dt>{{trans('eminent.reservation.date-due')}}</dt>
        <dd>
          <?php
            echo (date("Y-m-d",strtotime($transaction->date_due)) == date('Y-m-d')) ? '<span class="bg-danger">Today</span>' : date("m/d/Y",strtotime($transaction->date_due));
            ?>
        </dd>
        <?php
          if ($transaction->date_due <= date('Y-m-d') AND $transaction->status=='pending') {
              $payment_id = $transaction->id;
              $amount_payable += $transaction->amount;
          }
          ?>
      </dl>
      @endforeach
      </dl>
    </div>
    <div class="col-md-4 booking-form">
      @if($amount_payable>0)
      <div class="row">
        <h3>{{trans('eminent.reservation.paying-now')}} ${{number_format($amount_payable,2)}}</h3>
        </div>
      @include('reservations._checkout')
      @else
      {{trans('eminent.reservation.nothing-due')}}
      @endif
      <br/> <br/> <br/>
    </div>
  </div>
  <!-- /.row -->
  <!-- /.row -->
  <hr>
</div>
<!-- /.container -->
@endsection
