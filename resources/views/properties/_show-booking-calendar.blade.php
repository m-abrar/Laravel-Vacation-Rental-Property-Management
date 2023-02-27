<!-- Calendar for showing property availability and clicking and booking the desired dates of reservation -->
<div class="row">
   <h3 class="text-center">{{trans('eminent.calendar.select-dates')}}</h3>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="col-md-12">
         <form id="select-the-dates-form" class="form-horizontal" role="form" 
            action="{{url('reserve/'.$property->slug)}}/redirect" 
            method="get">
            <div class="form-group">
               <span id="property-calendar-select-dates">
                  <p>{{trans('eminent.calendar.loading')}}</p>
                  <i class="fa fa-refresh fa-spin"></i>
               </span>
            </div>
            <div class="form-group" >
               <span class="pull-right"><mark>
               {{trans('eminent.calendar.minimum-stay')}} {{$property->minimum_stay_nights}} @if($property->minimum_stay_nights==1) {{trans('eminent.night_singular')}} @else {{trans('eminent.nights_plural')}} @endif
               </mark></span>
            </div>
            <!-- upgrade - 12/10/2016 - minimum_nights -->
            <input type="hidden" name="dates_searched" id="dates-searched" 
               value="<?= @implode(',', ((array)\Session::get('dates_searched')) ) ?>">
            <div class="form-group" id="booking-availability-message">
               <!-- AJAX PRICE RESULT SHOWN HERE FOR SELECTED DATES -->
            </div>
            <div class="form-group">
               <span id="calculated-lodging-price">
                  <!-- calculated-lodging-price -->
               </span>
            </div>
            <div class="form-group hidden" id="calculation-error-container">
               <div class="alert alert-danger">
                  <span id="calculation-error-message">
                     <!-- Calculation Error Message -->
                  </span>
               </div>
            </div>
            <!--Let the user fill the form and start booking a reservation-->
            <div class="form-group">
               <label for="firstname">{{trans('eminent.reservation.first-name')}}</label>
               <input class="form-control" type="text" id="firstname" name="firstname" value="@if(old('firstname')){!! old('firstname') !!}@endif" placeholder="{{trans('eminent.reservation.first-name-placeholder')}}" required />
            </div>
            <div class="form-group">
               <label for="firstname">{{trans('eminent.reservation.last-name')}}</label>
               <input class="form-control" type="text" id="lastname" name="lastname" value="@if(old('lastname')){!! old('lastname') !!}@endif" placeholder="{{trans('eminent.reservation.last-name-placeholder')}}" required />
            </div>
            <div class="form-group">
               <label for="firstname">{{trans('eminent.reservation.email')}}</label>
               <input class="form-control" type="email" id="email" name="email" value="@if(old('email')){!! old('email') !!}@endif" placeholder="{{trans('eminent.reservation.email-placeholder')}}" required />
            </div>
            <div class="pull-right">
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <button type="submit" class="btn btn-info btn-block"> {{trans('eminent.reservation.reserve')}} <span class="glyphicon glyphicon-chevron-right"></span> </button>
            </div>
            <br />
            <br />
         </form>
      </div>
   </div>
</div>