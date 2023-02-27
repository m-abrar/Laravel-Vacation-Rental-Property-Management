<!-- Button trigger modal: Reserve Online -->
<button type="button" class="btn btn-oval" data-toggle="modal" data-target="#reserve-online"> {{trans('eminent.popup.reserve_online')}} </button>
<!-- Modal: Reserve Online -->
<div class="modal fade" id="reserve-online" tabindex="-1" role="dialog" aria-labelledby="reserve-onlineLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" role="form" action="{{url('rental/search/redirect')}}" method="get">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="reserve-onlineLabel">{{trans('eminent.popup.heading')}}</h4>
        </div>
        <div class="modal-body">
        
          <div class="reserve-online-box">
            <div class="form-group">
              <label for="checkin">{{trans('eminent.form.arrival')}}</label>
              <div class="input-group">
                <input class="form-control" type="text" id="checkin" name="arrival" value="{{@$date_start}}" placeholder="mm/dd/yyyy" required />
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> 
              </div>
            </div>
            <div class="form-group">
              <label for="checkout">{{trans('eminent.form.departure')}}</label>
              <div class="input-group">
                <input class="form-control" type="text" id="checkout" name="departure" value="{{@$date_end}}" placeholder="mm/dd/yyyy" required />
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> 
              </div>
            </div>
            <div class="form-group">
              <label for="sleeps">{{trans('eminent.form.sleeps')}}</label>
              <select name="sleeps" class="form-control">
              <option value="1" @if(!isset($sleeps) or $sleeps=='0') selected="selected" @endif > {{trans('eminent.form.select')}} </option>
              <option value="1" @if(isset($sleeps) and $sleeps=='1') selected="selected" @endif>1 + </option>
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
            <label for="category">{{trans('eminent.category')}}</label>

              <select name="category" class="form-control">
                <option value="all"
                @if (@$type == "all") {{ 'selected="selected"' }} @endif
                > {{trans('eminent.form.all')}} </option>
                @foreach ($categories as $category)
                <option value="{{ $category->slug }}"
                @if (@$type == $category->slug) {!!'selected="selected"'!!} 
                @endif
                >{!!$category->title!!}</option>
                @endforeach
              </select>
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-oval"><span class="glyphicon glyphicon-search"></span> {{trans('eminent.search')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>