<section class="row" id="search-form-horizontal">
   <div class="container">
      
      <form class="form-inline text-center" role="form" action="{{url('rental/search/redirect')}}" method="get">
               <div class="form-group">
                  <label for="arrival" class="index-label">Arrival1:</label>
                  <div class="input-group date">
                     <input class="form-control search-index" type="text" id="arrival" name="arrival" value="{{@$date_start}}" placeholder="mm/dd/yyyy" required />
                     <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> 
                  </div>
               </div>
               <div class="form-group">
                  <label for="departure" class="index-label">Departure:</label>
                  <div class="input-group date">
                     <input class="form-control search-index" type="text" id="departure" name="departure" value="{{@$date_end}}" placeholder="mm/dd/yyyy" required />
                     <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> 
                  </div>
               </div>
               <div class="form-group">
                  <label for="sleeps" class="index-label">Sleeps:</label>
                  <select name="sleeps" class="form-control search-index">
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
                  <label for="category" class="index-label">Category:</label>
                  <select name="category" class="form-control search-index">
                  <option value="all"
                  @if (@$selectedtype == "all") {{ 'selected="selected"' }} @endif
                  > All </option>
                  @foreach ($categories as $category)
                  <option value="{{ $category->slug }}"
                  @if (@$selectedtype == $category->slug) {!!'selected="selected"'!!} 
                  @endif
                  >{!!$category->title!!}</option>
                  @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <button type="submit" class="btn btn-oval"><span class="glyphicon glyphicon-search"></span> Search</button>
               </div>
            </form>
   </div>
   <div class="middle-down-arrow">&nbsp;</div>
</section>
