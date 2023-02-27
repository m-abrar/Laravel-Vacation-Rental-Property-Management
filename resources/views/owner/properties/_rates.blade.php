<!--this file is part of properties.php-->
<table align="center" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>Daily</th>
      <th>Weekly</th>
      <th>Two Weekly</th>
      <th>Monthly</th>
    </tr>
  </thead>
  </tbody>
  <tr>
    <td colspan="4" class="text-center">
      <div class="col-sm-4 col-xs-12 checkbox"> <strong>Regular Price</strong>: </div>
      <!-- <div class="col-sm-4 col-xs-12">
        <div class="pull-left checkbox">Min Stay:</div>
        <div class="col-xs-7">
          <input name="minimum_stay_nights" type="number" class="form-control" placeholder="#nights" 
            value="@if(old('minimum_stay_nights')){!! old('minimum_stay_nights') !!}@elseif(isset($property->minimum_stay_nights)){!!$property->minimum_stay_nights!!}@endif" 
            />
        </div>
      </div> -->
      <div class="col-sm-4 col-xs-12"> <span class="pull-left checkbox">Final Dues:</span> <span class="col-md-7">
        <input name="final_payment_days" type="number" class="form-control" placeholder="#days" 
          value="@if(old('final_payment_days')){!! old('final_payment_days') !!}@elseif(isset($property->final_payment_days)){!!$property->final_payment_days!!}@endif"
          />
        </span>
        </label>
      </div>
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <div class="input-group"><span class="input-group-addon">$</span>
        <input name="price_daily" type="text" class="form-control" placeholder="price daily"
          value="@if(old('price_daily')){!! old('price_daily') !!}@elseif(isset($property->price_daily)){!!$property->price_daily!!}@endif"
          />
        <span class="input-group-addon">
        <input name="is_price_daily" type="checkbox" value="1"
        @if(old('is_price_daily')){{'checked="checked"'}}
        @elseif(isset($property->is_price_daily) and ($property->is_price_daily=='1')){{'checked="checked"'}}@endif />
        </span> 
      </div>
    </td>
    <td>
      <div class="input-group"><span class="input-group-addon">$</span>
        <input name="price_weekly" type="text" class="form-control" placeholder="weekly"
          value="@if(old('price_weekly')){!! old('price_weekly') !!}@elseif(isset($property->price_weekly)){!!$property->price_weekly!!}@endif"
          />
        <span class="input-group-addon">
        <input name="is_price_weekly" type="checkbox" value="1"
        @if(old('is_price_weekly')){{'checked="checked"'}}
        @elseif(isset($property->is_price_weekly) and ($property->is_price_weekly=='1')){{'checked="checked"'}}@endif />
        </span> 
      </div>
    </td>
    <td>
      <div class="input-group"><span class="input-group-addon">$</span>
        <input name="price_two_weekly" type="text" class="form-control" placeholder="two weekly"
          value="@if(old('price_two_weekly')){!! old('price_two_weekly') !!}@elseif(isset($property->price_two_weekly)){!!$property->price_two_weekly!!}@endif"
          />
        <span class="input-group-addon">
        <input name="is_price_two_weekly" type="checkbox" value="1"
        @if(old('is_price_two_weekly')){{'checked="checked"'}}
        @elseif(isset($property->is_price_two_weekly) and ($property->is_price_two_weekly=='1')){{'checked="checked"'}}@endif />
        </span> 
      </div>
    </td>
    <td>
      <div class="input-group"><span class="input-group-addon">$</span>
        <input name="price_monthly" type="text" class="form-control" placeholder="monthly"
          value="@if(old('price_monthly')){!! old('price_monthly') !!}@elseif(isset($property->price_monthly)){!!$property->price_monthly!!}@endif"
          />
        <span class="input-group-addon">
        <input name="is_price_monthly" type="checkbox" value="1"
        @if(old('is_price_monthly')){{'checked="checked"'}}
        @elseif(isset($property->is_price_monthly) and ($property->is_price_monthly=='1')){{'checked="checked"'}}@endif />
        </span> 
      </div>
    </td>
  </tr>
  <!-- loop -->
  @foreach($rates as $rate)
  <tr>
    <td colspan="4" class="text-center">
      <div class="col-sm-4 col-xs-12 checkbox"> <strong>
        {{$rate->title}}
        </strong>:
        {{$rate->season_start_month}}
        /
        {{$rate->season_start_day}}
        -
        {{$rate->season_end_month}}
        /{{$rate->season_end_day}}
      </div>
      <!-- <div class="col-sm-4 col-xs-12">
        <div class="pull-left checkbox">Min Stay:</div>
        <div class="col-xs-7">
          <input name="minimum_stay_nights_{{$rate->id}}" type="number" class="form-control" placeholder="#nights"
            value="@if(old('minimum_stay_nights_'.$rate->id)){!! old('minimum_stay_nights_'.$rate->id) !!}@elseif(isset($rate->minimum_stay_nights)){!!$rate->minimum_stay_nights!!}@endif"
            />
        </div>
      </div> -->
      <div class="col-sm-4 col-xs-12"> <span class="pull-left checkbox">Final Dues:</span> <span class="col-md-7">
        <input name="final_payment_days_{{$rate->id}}" type="number" class="form-control"placeholder="#days"
          value="@if(old('final_payment_days_'.$rate->id)){!! old('final_payment_days_'.$rate->id) !!}@elseif(isset($rate->final_payment_days)){!!$rate->final_payment_days!!}@endif"
          />
        </span>
        </label>
      </div>
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <div class="input-group"><span class="input-group-addon">$</span>
        <input name="price_daily_{{$rate->id}}" type="text" class="form-control" placeholder="price daily"
          value="@if(old('price_daily_'.$rate->id)){!! old('price_daily_'.$rate->id) !!}@elseif(isset($rate->price_daily)){!!$rate->price_daily!!}@endif"
          />
        <span class="input-group-addon">
        <input name="is_price_daily_{{$rate->id}}" type="checkbox" value="1"
        @if(old('is_price_daily_'.$rate->id)){{'checked="checked"'}}
        @elseif(isset($rate->is_price_daily) and ($rate->is_price_daily=='1')){{'checked="checked"'}}@endif
        />
        </span> 
      </div>
    </td>
    <td>
      <div class="input-group"><span class="input-group-addon">$</span>
        <input name="price_weekly_{{$rate->id}}" type="text" class="form-control" placeholder="weekly"
          value="@if(old('price_weekly_'.$rate->id)){!! old('price_weekly_'.$rate->id) !!}@elseif(isset($rate->price_weekly)){!!$rate->price_weekly!!}@endif"
          />
        <span class="input-group-addon">
        <input name="is_price_weekly_{{$rate->id}}" type="checkbox" value="1"
        @if(old('is_price_weekly_'.$rate->id)){{'checked="checked"'}}
        @elseif(isset($rate->is_price_weekly) and ($rate->is_price_weekly=='1')){{'checked="checked"'}}@endif
        />
        </span> 
      </div>
    </td>
    <td>
      <div class="input-group"><span class="input-group-addon">$</span>
        <input name="price_two_weekly_{{$rate->id}}" type="text" class="form-control" placeholder="two weekly"
          value="@if(old('price_two_weekly_'.$rate->id)){!! old('price_two_weekly_'.$rate->id) !!}@elseif(isset($rate->price_two_weekly)){!!$rate->price_two_weekly!!}@endif"
          />
        <span class="input-group-addon">
        <input name="is_price_two_weekly_{{$rate->id}}" type="checkbox" value="1"
        @if(old('is_price_two_weekly_'.$rate->id)){{'checked="checked"'}}
        @elseif(isset($rate->is_price_two_weekly) and ($rate->is_price_two_weekly=='1')){{'checked="checked"'}}@endif
        />
        </span> 
      </div>
    </td>
    <td>
      <div class="input-group"><span class="input-group-addon">$</span>
        <input name="price_monthly_{{$rate->id}}" type="text" class="form-control" placeholder="monthly"
          value="@if(old('price_monthly_'.$rate->id)){!! old('price_monthly_'.$rate->id) !!}@elseif(isset($rate->price_monthly)){!!$rate->price_monthly!!}@endif"
          />
        <span class="input-group-addon">
        <input name="is_price_monthly_{{$rate->id}}" type="checkbox" value="1"
        @if(old('is_price_monthly_'.$rate->id)){{'checked="checked"'}}
        @elseif(isset($rate->is_price_monthly) and ($rate->is_price_monthly=='1')){{'checked="checked"'}}@endif
        />
        </span> 
      </div>
    </td>
  </tr>
  @endforeach
  <!-- end loop -->
  </tbody>
</table>
