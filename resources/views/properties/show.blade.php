<!-- This view file shows the detailed information of a property the user landed in -->
@extends('layouts.default.start')
<!-- Goes to html>head>title -->
@section('title')
{{$property->title}} - {{$settings->site_title}}
@endsection
@section('head_enqueue_scripts')

<link href="{{ asset('resources/plugins/jquery-awesomePOI/src/awesomePOI.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('resources/plugins/jquery-awesomePOI/src/skins/skin1.css') }}" rel="stylesheet" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
@endsection
<!-- Yields body of the page inside the template -->
@section('contents')
<!-- Page Content -->
<style type="text/css">
   .page-header-bg:before {
   background-image: url('{{asset(@$property->images->first()->image)}}');
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
      <!-- Left/Middle Column :: Property Images/Description/Amenities/Features/Rates/Map -->
      <div class="col-md-7 property-description">
         @include('properties._show-images')
         <div class="row text-center" style="padding-bottom: 14px;">
            <div class="col-md-3 col-sm-6 col-xs-12 share-label"><i class="fa fa-share fa-lg"></i> Share:</div>
            <div class="col-md-3 col-sm-6 col-xs-4 share-option fb"><a href="https://www.facebook.com/sharer/sharer.php?u=http://noble-soft.com/eminent/demo/public/show/eastland-bungalow" target="_blank"><i class="fa fa-facebook fa-lg"></i>Facebook</a></div>
            <div class="col-md-3 col-sm-6 col-xs-4 share-option twitter"><a href="https://twitter.com/share?url=http://noble-soft.com/eminent/demo/public/show/eastland-bungalow" target="_blank"><i class="fa fa-twitter fa-lg"></i>Twitter</a></div>
            <div class="col-md-3 col-sm-6 col-xs-4 share-option gplus"><a href="https://plus.google.com/share?url=http://noble-soft.com/eminent/demo/public/show/eastland-bungalow" target="_blank"><i class="fa fa-google-plus fa-lg"></i>Google</a></div>
         </div>
         @if($property->is_sale=='1')
         <div class="row property-for-sale-info">
            <div class="col-md-6">
               <i>For Sale:</i>
               <h3>${{$property->sale_price}}</h3>
            </div>
            <div class="col-md-6 text-right">{{$property->address}}<br/>{{$property->city}}<br/>{{$property->zip}}, {{$property->location->title}}</div>
         </div>
         @endif
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
         @if($property->is_vacation=='1')
         @include('properties._show-booking-calendar')
         @endif
         @if($property->is_sale=='1')
         @include('properties._show-send-buying-offer')
         @endif
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
         @if($property->is_sale=='1')
         @if($settings->is_sale_policies==1)
         <div class="row">
            <h3>{{trans('eminent.headings.sale-policies')}}</h3>
         </div>
         <div class="row">
            <div class="col-md-12">
               {!!$settings->sale_policies!!}
            </div>
         </div>
         @endif
         @endif
      </div>
   </div>
   <!-- /.row -->
   <!-- Map of proerty -->
   
   <section class="apoi-section">
      <!-- MARKUP -->
      <!-- FILTERS -->
      <div class="apoi-filter-container">
         <div class="apoi-filter" data-types="atm"><span class="apoi-map-icon map-icon-atm"></span>ATM</div>
         <div class="apoi-filter" data-types="restaurant"><span class="apoi-map-icon map-icon-restaurant"></span>Restaurant</div>
         <div class="apoi-filter" data-types="hospital"><span class="apoi-map-icon map-icon-hospital"></span>Hospital</div>
      </div>
      <!-- PLACES LIST CONTAINER -->
      <div id="apoi-list"></div>
      <!-- PLACE DETAILS CONTAINER -->
      <div id="apoi-details-container"></div>
      <!-- AUTOCOMPLETE INPUT -->
      <div class="apoi-autocomplete-container">
         <input id="apoi-autocomplete" type="text" placeholder="Enter a location" />
         <a href="#" id="apoi-geolocation"><span class="apoi-map-icon map-icon-crosshairs"></span></a>
      </div>
      <!-- TRANSPORT MODE -->
      <div class="apoi-transport-modes">
         <input id="apoi-driving" type="radio" name="apoi-mode" value="DRIVING" checked /><label for="apoi-driving"><span class="apoi-map-icon map-icon-taxi-stand"></span></label>
         <input id="apoi-bicycling" type="radio" name="apoi-mode" value="BICYCLING" /><label for="apoi-bicycling"><span class="apoi-map-icon map-icon-bicycling"></span></label> 
         <input id="apoi-transit" type="radio" name="apoi-mode" value="TRANSIT" /><label for="apoi-transit"><span class="apoi-map-icon map-icon-bus-station"></span></label>
         <input id="apoi-walking" type="radio" name="apoi-mode" value="WALKING" /><label for="apoi-walking"><span class="apoi-map-icon map-icon-walking"></span></label>
      </div>
      <!-- MAP / STREET VIEW SWITCH -->
      <a href="#" id="apoi-switch-street"><span class="apoi-map-icon map-icon-male"></span></a>  
      <a href="#" id="apoi-switch-map"><span class="apoi-map-icon map-icon-map-pin"></span></a>     
      <!-- ROUTE TIME -->
      <div id="apoi-route-time"></div>
      <!-- MAP CONTAINER -->
      <div id="apoi-maps-container"></div>
   </section>
   @section('javascript')
   <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDkJgWmx1PGNLDl5my-EEgeYIEOtI5ij2w&sensor=false&libraries=places"></script>
   <script src="{{ asset('resources/plugins/jquery-awesomePOI/src/jquery.awesomePOI.js') }}"></script>
   <script>
      $( window ).load(function() {
        $('#apoi-maps-container').awesomePOI({
          start: "point",address: "{!!@$property->title!!}",pyrmont: {lat: {!!@$property->latitude!!}, lng: {!!@$property->longitude!!}},radius: "1500",streetView: true,autocomplete: true,userLocation: true,routeMode: true,placesList: true,placeDetails: true,routeTime: true,route: true,multiple: true,iconSize: "large",iconColor: "gold",cluster: true,zoom: 15,wheelScroll: true,   });       
      });   
   </script> 
   @endsection
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