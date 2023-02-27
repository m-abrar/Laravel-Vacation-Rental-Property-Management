<style type="text/css">
  header {
  background-image: url('http://localhost/eminent/public/img/header-bg.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center center;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  background-size: cover;
  -o-background-size: cover;
  text-align: center;
  color: white;
}
header .intro-text {
  padding-top: 100px;
  padding-bottom: 50px;
}
header .intro-text .intro-lead-in {
  font-family: "Droid Serif", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-style: italic;
  font-size: 22px;
  line-height: 22px;
  margin-bottom: 25px;
}
.intro-heading {
  font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
  text-transform: uppercase;
  font-weight: 700;
  font-size: 60px;
  line-height: 50px;
  margin-bottom: 25px;
  text-align:left;
}
.r-form-1-top{
  padding: 11px;
}
.form-group{
  margin: 0 0 15px -15px;
}
.r-form-1-bottom {

    padding: 25px;

    background: #444;

    background: rgba(0, 0, 0, 0.5);

    text-align: left;

    -moz-border-radius: 0 0 4px 4px;

    -webkit-border-radius: 0 0 4px 4px;

    border-radius: 0;

}

.r-form-1-box input[type="text"], .r-form-1-box textarea, .r-form-1-box textarea.form-control {

    height: 50px;

    margin: 0;

    padding: 0 20px;

    vertical-align: middle;

    background: #fff;

    border: 3px solid #fff;

    font-family: 'Raleway', sans-serif;

    font-size: 15px;

    font-weight: 400;

    line-height: 50px;

    color: #888;

    -moz-border-radius: 4px;

    -webkit-border-radius: 4px;

    border-radius: 4px;

    -moz-box-shadow: none;

    -webkit-box-shadow: none;

    box-shadow: none;

    -o-transition: all .3s;

    -moz-transition: all .3s;

    -webkit-transition: all .3s;

    -ms-transition: all .3s;

    transition: all .3s;

}



.btn-xl {

  color: white;

  /*background-color: #fed136;

  border-color: #fed136;*/

  background-color: #db241d;

    border-color: #c1140e;

  font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;

  text-transform: uppercase;

  font-weight: 700;

  border-radius: 3px;

  font-size: 18px;

  padding: 20px 40px;

}

.btn-xl:hover,

.btn-xl:focus,

.btn-xl:active,

.btn-xl.active,

.open .dropdown-toggle.btn-xl {

  color: white;

   background-color: #e82821;

    border-color: #c1140e;

   

  /*background-color: #fec503;

  

   border-color: #f6bf01;*/

  

 

}

.btn-xl:active,

.btn-xl.active,

.open .dropdown-toggle.btn-xl {

  background-image: none;

}

.btn-property-search {

    width: 100%;

    height: 50px;

    margin: 0;

    padding: 0 20px;

    vertical-align: middle;

    background: #db241d;

    border: 0;

    font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;

    font-size: 15px;

    font-weight: 400;

    line-height: 50px;

    color: #fff;

    -moz-border-radius: 4px;

    -webkit-border-radius: 4px;

    border-radius: 4px;

    text-shadow: none;

    -moz-box-shadow: none;

    -webkit-box-shadow: none;

    box-shadow: none;

    -o-transition: all .3s;

    -moz-transition: all .3s;

    -webkit-transition: all .3s;

    -ms-transition: all .3s;

    transition: all .3s;

}

.btn-property-search:hover{

  

  color: white;

    background-color: #e82821;

    border-color: #c1140e;

  }

.radius-none{ border-radius:0 !important;}



</style>

<header style="background-image: url('{{asset(@$page_home->images->first()->image)}}');">
         <div class="container">
            <div class="col-md-8">
               <div class="intro-text wow slideInRight animated animated" data-wow-delay="2s" style="visibility: visible; animation-delay: 2s; animation-name: slideInRight;">
                  <div class="intro-heading">Welcome To <span class="theme-red">Vacation</span> Rental</div>
                  <div class="intro-lead-in">Great Stay Affordable Price</div>
                  <a href="http://localhost/budgethotel/public/pages/welcome" class="page-scroll btn btn-xl">Tell Me More</a>
               </div>
            </div>
            <div class="col-md-4 wow slideInLeft animated animated" data-wow-delay="2s" style="visibility: visible; animation-delay: 2s; animation-name: slideInLeft;">
               <div class="r-form-1-top">
                  <div class="col-md-12 r-form-1-top-left">
                     <h3>Search Property</h3>
                     <p>Fill in the form to get instant results:</p>
                  </div>
               </div>
               <div class="r-form-1-bottom">
                  <form class="form" role="form" action="{{url('rental/search/redirect')}}" method="get">


                  <div class="row form-group">
                                 <label for="arrival" class="col-md-4">{{trans('eminent.form.arrival')}}</label>
                                 <div class="col-md-8 input-group date">
                                    <input class="form-control radius-none" type="text" id="arrival" name="arrival" value="" placeholder="mm/dd/yyyy" required="">
                                    <span class="input-group-addon radius-none"><i class="glyphicon glyphicon-calendar"></i></span> 
                                 </div>
               </div>
               <div class="row form-group">
                  <label for="departure" class="col-md-4">{{trans('eminent.form.departure')}}</label>
                  <div class="col-md-8 input-group date">
                     <input class="form-control radius-none" type="text" id="departure" name="departure" value="" placeholder="mm/dd/yyyy" required="">
                     <span class="input-group-addon radius-none"><i class="glyphicon glyphicon-calendar"></i></span> 
                  </div>
               </div>
<div class="row form-group">
                  <label for="sleeps" class="col-md-4">{{trans('eminent.form.sleeps')}}</label>
                  <div class="col-md-8 nopadding">
                  <select name="sleeps" class="form-control radius-none">
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
               </div>
               <div class="row form-group">
                  <label for="category" class="col-md-4">{{trans('eminent.form.category')}}</label>
                  <div class="col-md-8 nopadding">
                  <select name="category" class="form-control radius-none">
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

               </div>

               <button type="submit" class="btn btn-property-search radius-none"><i class="fa fa-search"></i>{{trans('eminent.form.search')}}</button>

            </form>

<!---NEW-->


<style>
.nopadding {
    padding: 0;
}
</style>

<!--/NEW-->

<!--             <form role="form" action="" method="post">
                     <div class="form-group">
                        <label class="sr-only" for="r-form-1-first-name">First name</label>
                        <input type="text" name="r-form-1-first-name" placeholder="First name..." class="r-form-1-first-name form-control radius-none">
                     </div>
                     <div class="form-group">
                        <label class="sr-only" for="r-form-1-last-name">Last name</label>
                        <input type="text" name="r-form-1-last-name" placeholder="Last name..." class="r-form-1-last-name form-control radius-none">
                     </div>
                     <div class="form-group">
                        <label class="sr-only" for="r-form-1-email">Email</label>
                        <input type="text" name="r-form-1-email" placeholder="Email..." class="r-form-1-email form-control radius-none">
                     </div>
                     <button type="submit" class="btn btn-property-search radius-none"><i class="fa fa-search"></i> Search Property</button>
                  </form> -->
               </div>
            </div>
         </div>
      </header>


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