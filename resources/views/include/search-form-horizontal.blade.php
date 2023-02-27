<style type="text/css">
.radius-none{ border-radius:0 !important;}
</style>
<?php
if(@$searchedtab=='sale'){
   $rentaltabclass = '';
   $saletabclass = 'active';
}else{
   $rentaltabclass = 'active';
   $saletabclass = '';
}
?>
<section class="col-md-12" id="search-form-horizontal">
   <div class="container">
      <ul class="nav nav-tabs">
         <li class="tab-button <?=$rentaltabclass?>"><a href="#search-form-properties-for-rent" data-toggle="tab" aria-expanded="true">{{trans('eminent.form.rental')}}</a></li>
         <li class="tab-button <?=$saletabclass?>"><a href="#search-form-properties-for-sale" data-toggle="tab" aria-expanded="false">{{trans('eminent.form.sale')}}</a></li>
      </ul>
      <div class="tab-content">
         <div class="tab-pane <?=$rentaltabclass?> fade in" id="search-form-properties-for-rent" style="margin:20px">
            <!-- Search Bar RENTAL -->
            <form class="form-inline text-center" role="form" action="{{url('rental/search/redirect')}}" method="get">
               <div class="form-group">
                  <label for="arrival" class="index-label">{{trans('eminent.form.arrival')}}</label>
                  <div class="input-group date">
                     <input class="form-control radius-none search-index" type="text" id="arrival" name="arrival" value="{{@$date_start}}" placeholder="mm/dd/yyyy" required readonly />
                     <span class="input-group-addon radius-none"><i class="glyphicon glyphicon-calendar"></i></span> 
                  </div>
               </div>
               <div class="form-group">
                  <label for="departure" class="index-label">{{trans('eminent.form.departure')}}</label>
                  <div class="input-group date">
                     <input class="form-control radius-none search-index" type="text" id="departure" name="departure" value="{{@$date_end}}" placeholder="mm/dd/yyyy" required readonly />
                     <span class="input-group-addon radius-none"><i class="glyphicon glyphicon-calendar"></i></span> 
                  </div>
               </div>
               <div class="form-group">
                  <label for="sleeps" class="index-label">{{trans('eminent.form.sleeps')}}</label>
                  <select name="sleeps" class="form-control radius-none search-index">
                  <option value="1" @if(!isset($sleeps) or $sleeps=='0' or $sleeps=='1') selected="selected" @endif>1 + </option>
                  <option value="2" @if(isset($sleeps) and $sleeps=='2') selected="selected" @endif>2 + </option>
                  <option value="3" @if(isset($sleeps) and $sleeps=='3') selected="selected" @endif>3 + </option>
                  <option value="4" @if(isset($sleeps) and $sleeps=='4') selected="selected" @endif>4 + </option>
                  <option value="5" @if(isset($sleeps) and $sleeps=='5') selected="selected" @endif>5 + </option>
                  <option value="6" @if(isset($sleeps) and $sleeps=='6') selected="selected" @endif>6 + </option>
                  <option value="7" @if(isset($sleeps) and $sleeps=='7') selected="selected" @endif>7 + </option>
                  <option value="8" @if(isset($sleeps) and $sleeps=='8') selected="selected" @endif>8 + </option>
                  <option value="9" @if(isset($sleeps) and $sleeps=='9') selected="selected" @endif>9 + </option>
                  <option value="10" @if(isset($sleeps) and $sleeps=='10') selected="selected" @endif>10 + </option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="category" class="index-label">{{trans('eminent.form.category')}}</label>
                  <select name="category" class="form-control radius-none search-index">
                  <option value="all"
                  @if (@$selectedtype == "all") {{ 'selected="selected"' }} @endif
                  > {{trans('eminent.form.all')}} </option>
                  @foreach ($categories as $category)
                  <option value="{{ $category->slug }}"
                  @if (@$selectedtype == $category->slug) {!!'selected="selected"'!!} 
                  @endif
                  >{!!$category->title!!}</option>
                  @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <button type="submit" class="btn btn-oval"><span class="glyphicon glyphicon-search"></span> {{trans('eminent.form.search')}}</button>
               </div>
            </form>
            <!-- /Search Bar RENTAL -->
         </div>
         <div class="tab-pane <?=$saletabclass?> fade in" id="search-form-properties-for-sale" style="margin:20px">
            <!-- Search Bar SALE -->
            <form class="form-inline text-center" role="form" action="{{url('sale/search/redirect')}}" method="get">
               <div class="form-group">
                  <label for="sleeps" class="index-label">{{trans('eminent.form.sleeps')}}</label>
                  <select name="sleeps" class="form-control radius-none search-index">
                  <option value="1" @if(!isset($sleeps) or $sleeps=='0' or $sleeps=='1') selected="selected" @endif>1 + </option>
                  <option value="2" @if(isset($sleeps) and $sleeps=='2') selected="selected" @endif>2 + </option>
                  <option value="3" @if(isset($sleeps) and $sleeps=='3') selected="selected" @endif>3 + </option>
                  <option value="4" @if(isset($sleeps) and $sleeps=='4') selected="selected" @endif>4 + </option>
                  <option value="5" @if(isset($sleeps) and $sleeps=='5') selected="selected" @endif>5 + </option>
                  <option value="6" @if(isset($sleeps) and $sleeps=='6') selected="selected" @endif>6 + </option>
                  <option value="7" @if(isset($sleeps) and $sleeps=='7') selected="selected" @endif>7 + </option>
                  <option value="8" @if(isset($sleeps) and $sleeps=='8') selected="selected" @endif>8 + </option>
                  <option value="9" @if(isset($sleeps) and $sleeps=='9') selected="selected" @endif>9 + </option>
                  <option value="10" @if(isset($sleeps) and $sleeps=='10') selected="selected" @endif>10 + </option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="category" class="index-label">{{trans('eminent.form.category')}}</label>
                  <select name="category" class="form-control radius-none search-index">
                  <option value="all"
                  @if (@$selectedtype == "all") {{ 'selected="selected"' }} @endif
                  > {{trans('eminent.form.all')}} </option>
                  @foreach ($categories as $category)
                  <option value="{{ $category->slug }}"
                  @if (@$selectedtype == $category->slug) {!!'selected="selected"'!!} 
                  @endif
                  >{!!$category->title!!}</option>
                  @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label for="location" class="index-label">{{trans('eminent.form.location')}}</label>
                  <select name="location" class="form-control radius-none search-index">
                  <option value="all"
                  @if (@$selectedlocation == "all") {{ 'selected="selected"' }} @endif
                  > {{trans('eminent.form.all')}} </option>
                  @foreach ($locations as $location)
                  <option value="{{ $location->slug }}"
                  @if (@$selectedlocation == $location->slug) {!!'selected="selected"'!!} 
                  @endif
                  >{!!$location->title!!}</option>
                  @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <button type="submit" class="btn btn-oval"><span class="glyphicon glyphicon-search"></span> {{trans('eminent.form.search')}}</button>
               </div>
            </form>
            <!-- /Search Bar RENTAL -->
         </div>
      </div>
   </div>
   <div class="middle-down-arrow">&nbsp;</div>
</section>

<!-- Customize Date Picker -->
<script>
   $(window).load(function(){
     var nowTemp = new Date();
     var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
     var checkin = $('#checkin').datepicker({
       onRender: function(date) {
         return date.valueOf() < now.valueOf() ? 'disabled' : '';
       }
     }).on('changeDate', function(ev) {
     if (ev.date.valueOf() > checkout.date.valueOf()) {
         var newDate = new Date(ev.date)
         newDate.setDate(newDate.getDate() + 1);
         checkout.setValue(newDate);
       }
       checkin.hide();
       $('#checkout')[0].focus();
     }).data('datepicker');
     var checkout = $('#checkout').datepicker({
       onRender: function(date) {
         return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
       }
     }).on('changeDate', function(ev) {
       checkout.hide();
     }).data('datepicker');
   });
   /* Config Date Picker */
   $(window).load(function(){
   var nowTemp = new Date();
   var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
   var checkin = $('#arrival').datepicker({
   onRender: function(date) {
     return date.valueOf() < now.valueOf() ? 'disabled' : '';
   }
   }).on('changeDate', function(ev) {
   if (ev.date.valueOf() > checkout.date.valueOf()) {
     var newDate = new Date(ev.date)
     newDate.setDate(newDate.getDate() + 1);
     checkout.setValue(newDate);
   }
   
   checkin.hide();
   $('#departure')[0].focus();
   }).data('datepicker');
   
   var checkout = $('#departure').datepicker({
   onRender: function(date) {
     return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
   }

   }).on('changeDate', function(ev) {
   checkout.hide();
   }).data('datepicker');
   });

   /* End Config Date Picker SET-2 */
</script>
<!-- End of Customize Date Picker -->