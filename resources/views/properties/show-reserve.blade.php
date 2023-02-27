<!-- This view file shows the detailed information of a property the user landed in -->
@extends('layouts.default.start')
<!-- Goes to html>head>title -->
@section('title')
{{$property->title}} - {{$settings->site_title}}
@endsection
<!-- Yields body of the page inside the template -->
@section('contents')
<!-- Page Content -->
<style type="text/css">
  .page-header-bg:before {
    background-image: url('{{asset($property->images->first()->image)}}');

}
</style>
   <div class="page-header-bg">
   <div class="container">
         <h1 class="pull-left">
            {!!$property->title!!}
         </h1>
         <ol class="breadcrumb pull-right">
            <li><a href="{{url('/')}}">{{trans('eminent.home')}}</a></li>
            <li><a href="{{url('types/')}}">{{trans('eminent.properties')}}</a></li>
            <li><a href="{{url('type/'.$property->category->slug)}}">
               {{$property->category->title}}
               </a>
            </li>
            <li class="active">
               {!!$property->title!!}
            </li>
         </ol>
   </div>
   </div>


<div class="container page-body box-shadow">
   @include('include.alerts')
   <!-- /.row -->
   <!-- Property Detail -->
   <div class="row">
      @if($property->is_vacation=='1')
      <!-- Left/Middle Column :: Property Images/Description/Amenities/Features/Rates/Map -->
      <div class="col-md-7 property-description">
         @include('properties._show-images')
         @include('properties._show-quick-detail')
         @include('properties._show-description')
         @if($property->is_vacation=='1')
          @if($property->is_rates=='1')
          <div class="row">
            @include('properties._show-rates')
          </div>
          @endif
         @endif
      </div>
      <!-- Right Column :: Property Detail -->
      <div class="col-md-5 booking-form">
         @include('properties._show-booking-calendar')
         <br/><br/>
         <div class="row">
            <h3>{{trans('eminent.headings.admin-reviews')}}</h3>
         </div>
         <div class="row">
            <div class="col-md-12">
               {!!$property->reviews!!}
            </div>
         </div>
         <br/>
         @if($property->is_vacation=='1')
         @if($settings->is_rental_policies==1)
         <div class="row">
            <h3>{{trans('eminent.headings.rental-policies')}}</h3>
         </div>
         <div class="row">
            <div class="col-md-12">
               {!!$settings->rental_policies!!}
            </div>
         </div>
         @endif
         @endif
      </div>
      @else
      <!-- Left Column :: Property Detail -->
      <div class="col-md-6">
         @include('properties._show-images')
      </div>
      <!-- Middle Column :: Property Detail -->
      <div class="col-md-6">
         @include('properties._show-description')
      </div>
      @endif
      
   </div>
   <!-- /.row -->
   <!-- Map of proerty -->
      <div class="row">
         <iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" 
            src="http://maps.google.com/maps?q={{$property->latitude}},{{$property->longitude}}&z=15&output=embed">
         </iframe>
      </div>
</div>
<!-- /.container -->
<script>
   $(document).ready(function() {
   
       var $lineitems = [];
       @foreach($lineitems as $lineitem)
       $lineitems.push({
           id: "{{$lineitem->id}}",
           title: "{{$lineitem->title}}",
           slug: "{{$lineitem->slug}}",
           is_required: "{{$lineitem->is_required}}",
           value_type: "{{$lineitem->value_type}}",
           apply_on: "{{$lineitem->apply_on}}",
           value: "{{$lineitem->value}}"
       });
       @endforeach
   
       var calendar = new PropertyCalendar("{{url('/')}}", "{{$property->slug}}", "NA", 'NA');
       <?php
      $pre_select_date_start = (null!==\Session::get('dates_searched')) ? min(\Session::get('dates_searched')):'NA';
      $pre_select_date_end = (null!==\Session::get('dates_searched')) ? max(\Session::get('dates_searched')):'NA';
      $year = ($pre_select_date_start!='NA')?date('Y',strtotime($pre_select_date_start)):date('Y',strtotime('+2 days')); 
      $month = ($pre_select_date_start!='NA')?date('n',strtotime($pre_select_date_start)):date('n',strtotime('+2 days')); 
      ?>
   
       window.onload = calendar.loadCalendar("{{$year}}", "{{$month}}", "{{$pre_select_date_start}}", "{{$pre_select_date_end}}");
   
       $(document).on('click', '.calendar-navigate', function() {
           var $year = $(this).data("year");
           var $month = $(this).data("month");
           calendar.loadCalendar($year, $month);
       });
   
       <?php if('NA'!==$pre_select_date_start and 'NA'!==$pre_select_date_end ){ ?>
         calendar.preBookingMessage("{{$pre_select_date_start}}", "{{$pre_select_date_end}}");
         calendar.calculatePrice("{{$pre_select_date_start}}", "{{$pre_select_date_end}}");
       <?php } ?>
   
       window.lastClickCycleID = 0;
       window.lastClickedDateValue = 0;
   
       $(document).on('click', '.date-available', function() {
           var $id = $(this).data("cycle");
           var $date = $(this).data("date");
           calendar.selectDates($id, $date, window.lastClickCycleID, window.lastClickedDateValue);
           calendar.saveDatesSearchedToSession($date, window.lastClickedDateValue);
           calendar.preBookingMessage($date, window.lastClickedDateValue);
           calendar.calculatePrice($date, window.lastClickedDateValue);        
           window.lastClickCycleID = $id;
           window.lastClickedDateValue = $date;
       });
   });
   
</script>
<script src="{{asset('js/reservations.js')}}"></script>
@endsection
