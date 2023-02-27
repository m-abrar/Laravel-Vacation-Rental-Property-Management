@if(isset($reservation->id))
<input type="hidden" name="id" value="{{ $reservation->id }}">
@endif
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<fieldset class="col-md-12 table-bordered">
  <legend>Guest Detail</legend>
  <div class="col-xs-12 col-sm-6">
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">First Name<font color="#FF0000">*</font></label>
      <div class="col-sm-8 col-xs-12">
        <input name="firstname" type="text" class="form-control" 
          value="@if(old('firstname')){!! old('firstname') !!}@elseif(isset($reservation->firstname)){!!$reservation->firstname!!}@endif" 
          />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Last Name<font color="#FF0000">*</font></label>
      <div class="col-sm-8 col-xs-12">
        <input name="lastname" type="text" class="form-control" 
          value="@if(old('lastname')){!! old('lastname') !!}@elseif(isset($reservation->lastname)){!!$reservation->lastname!!}@endif" 
          />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Email<font color="#FF0000">*</font></label>
      <div class="col-sm-8 col-xs-12">
        <input name="email" type="text" id="email" class="form-control" 
          value="@if(old('email')){!! old('email') !!}@elseif(isset($reservation->email)){!!$reservation->email!!}@endif" 
          />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Phone</label>
      <div class="col-sm-8 col-xs-12">
        <input name="phone" type="text" id="phone" class="form-control" 
          value="@if(old('phone')){!! old('phone') !!}@elseif(isset($reservation->phone)){!!$reservation->phone!!}@endif" 
          />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Adults</label>
      <div class="col-sm-8 col-xs-12">
        <input name="adults" type="text" id="adults" class="form-control" 
          value="@if(old('adults')){!! old('adults') !!}@elseif(isset($reservation->adults)){!!$reservation->adults!!}@endif" 
          />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Children</label>
      <div class="col-sm-8 col-xs-12">
        <input name="children" type="text" class="form-control" 
          value="@if(old('children')){!! old('children') !!}@elseif(isset($reservation->children)){!!$reservation->children!!}@endif" 
          />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Pets</label>
      <div class="col-sm-8 col-xs-12">
        <input name="pets" type="text" id="pets" class="form-control" 
          value="@if(old('pets')){!! old('pets') !!}@elseif(isset($reservation->pets)){!!$reservation->pets!!}@endif" 
          />
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6">
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Addr. Line 1</label>
      <div class="col-sm-8 col-xs-12">
        <input name="address_line_1" type="text" class="form-control" 
          value="@if(old('address_line_1')){!! old('address_line_1') !!}@elseif(isset($reservation->address_line_1)){!!$reservation->address_line_1!!}@endif" 
          />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Addr. Line 2</label>
      <div class="col-sm-8 col-xs-12">
        <input name="address_line_2" type="text" class="form-control" 
          value="@if(old('address_line_2')){!! old('address_line_2') !!}@elseif(isset($reservation->address_line_2)){!!$reservation->address_line_2!!}@endif" 
          />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">City</label>
      <div class="col-sm-8 col-xs-12">
        <input name="city" type="text" id="city" class="form-control" 
          value="@if(old('city')){!! old('city') !!}@elseif(isset($reservation->city)){!!$reservation->city!!}@endif" 
          />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">State</label>
      <div class="col-sm-8 col-xs-12">
        <select name="state" class="form-control">
        <option value="0"
        @if (!isset($reservation->state_id)) {{ 'selected="selected"' }} @endif
        > - select - </option>
        @foreach ($states as $state)
        <option value="{{ $state->id }}"
        @if (old('state') == $state->id) {!!'selected="selected"'!!} 
        @elseif (isset($reservation->state_id) and $reservation->state_id == $state->id) {!!'selected="selected"'!!} 
        @endif
        >{!!$state->title!!}</option>
        @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Zip</label>
      <div class="col-sm-8 col-xs-12">
        <input name="zip" type="text" class="form-control" 
          value="@if(old('zip')){!! old('zip') !!}@elseif(isset($reservation->zip)){!!$reservation->zip!!}@endif" 
          />
      </div>
    </div>
  </div>
</fieldset>
<fieldset class="col-md-12 table-bordered">
  <legend>Calendar &amp; Accounts</legend>
  <div class="col-xs-12 col-sm-6">
    <h4>
      {!! @$reservation->property_title !!}
    </h4>
    <!-- <iframe name="iframe" width="100%" height="440" src="{{url('calendar-vertical/'.$property_id)}}" frameborder="0"></iframe> -->
    <!-- Calendar for showing property availability and doing the reservation dates booking -->
    <div id="property-calendar-select-dates"></div>
    <input type="hidden" name="dates_searched" id="dates-searched" value="{{@$dates_searched}}">

<div class="form-group" id="booking-availability-message">
      <!-- booking-availability-message -->
    </div>
    <div class="form-group hidden" id="calculation-error-container">
      <div class="alert alert-danger">
        <span id="calculation-error-message">
          <!-- Calculation Error Message -->
        </span>
      </div>
    </div>

    
  </div>
  <div class="col-xs-12 col-sm-6">
    
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Lodging:</label>
      <div class="col-sm-8 col-xs-12">
        <div class="input-group"> <span class="input-group-addon">$</span>
          <input name="lodging_amount" id="calculated-lodging-price" type="text" class="form-control update-reservation-price" placeholder="Auto calculation..." 
            value="@if(old('lodging_amount')){!! old('lodging_amount') !!}@elseif(isset($reservation->lodging_amount)){!!$reservation->lodging_amount!!}@endif" 
            />
        </div>
        <br/>
            @if(isset($reservation->lodging_amount))<small>Last Saved: ${!!$reservation->lodging_amount!!}</small>@endif
      </div>
    </div>






<h3>Addon Services</h3>
        <div class="addons">
        <?php $calculated_addons_price = 0; ?>
          @foreach ($addons as $addon)
          <?php
          $addon_quantity = 0;
          if(isset($reservation)){
          $quantity = $reservation->services->where('service_id',$addon->id);
          foreach ($quantity as $quant) {
            $addon_quantity = $quant->quantity;
          }          
          }
          $addon_price_total = $addon->price*$addon_quantity;
          $calculated_addons_price += $addon_price_total;
          ?>
          <div class="col-sm-12 col-xs-12" style="padding-bottom:8px;">

            <div class="col-sm-5 col-xs-5">
              <img class="img-responsive img-rounded" src="{{asset($addon->image)}}" alt="{!!$addon->title!!}" > 
            </div>

            <div class="col-sm-7 col-xs-7">
              <strong>{!!$addon->title!!}</strong> - ${{number_format($addon->price,2)}}
              <input type="hidden" id="addon-price-{{$addon->id}}" value="{{number_format($addon->price,2)}}" />
              <input type="hidden" id="addon-price-total-{{$addon->id}}" value="{{$addon_price_total}}" class="addon-total" />
              <br/>
              {!!$addon->summary!!}
              <br/>
              <!-- Trigger the modal with a button -->
              <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#addonModal-{{$addon->id}}">View Detail</a>
              <br/><br/>
              <!-- Modal -->
              <div id="addonModal-{{$addon->id}}" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">{!!$addon->title!!}</h4>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                      <div class="col-md-6">
                      {!!$addon->description!!}
                      <br/>
                      <br/>
                      Price per Unit: ${{number_format($addon->price,2)}}
                      </div>
                      <div class="col-md-6">
                      <img class="img-responsive img-rounded image-200" src="{{asset($addon->image)}}" alt="{!!$addon->title!!}" >
                      </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>

                </div>
              </div>
              
              <div class="col-sm-3 col-xs-3 control-label">
              Qty: 
              </div>
              <div class="col-sm-9 col-xs-9">
              <div class="input-group">
                  <span class="input-group-btn">
                      <button type="button" class="btn btn-default btn-number update-addons-total update-reservation-price" data-type="minus" data-field="quantity_{{$addon->id}}" data-id="{{$addon->id}}" />
                          <span class="glyphicon glyphicon-minus"></span>
                      </button>
                  </span>
                  <input type="text" id="addon-quantity-{{$addon->id}}" name="quantity_{{$addon->id}}" class="form-control input-number update-addons-total update-reservation-price" value="{{$addon_quantity}}" min="0" max="999" data-id="{{$addon->id}}" />
                  <span class="input-group-btn">
                      <button type="button" class="btn btn-default btn-number update-addons-total update-reservation-price" data-type="plus" data-field="quantity_{{$addon->id}}" data-id="{{$addon->id}}" />
                          <span class="glyphicon glyphicon-plus"></span>
                      </button>
                  </span>
              </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>




<dl class="dl-horizontal">
      <input type="hidden" id="calculated-addons-price" value="{{$calculated_addons_price}}" />
          <dt>Addons Total</dt>
          <dd>$<soan id="calculated-addons-price-html">{{number_format($calculated_addons_price,2)}}</soan></dd>
        </dl>

              <script type="text/javascript">
              $('.btn-number').click(function(e){
                  e.preventDefault();

                  fieldName = $(this).attr('data-field');
                  type      = $(this).attr('data-type');
                  var input = $("input[name='"+fieldName+"']");
                  var currentVal = parseInt(input.val());
                  if (!isNaN(currentVal)) {
                      if(type == 'minus') {
                          
                          if(currentVal > input.attr('min')) {
                              input.val(currentVal - 1).change();
                          } 
                          if(parseInt(input.val()) == input.attr('min')) {
                              //$(this).attr('disabled', true);
                              //i disabled it because it should continue addons price calculation
                          }

                      } else if(type == 'plus') {

                          if(currentVal < input.attr('max')) {
                              input.val(currentVal + 1).change();
                          }
                          if(parseInt(input.val()) == input.attr('max')) {
                              //$(this).attr('disabled', true);
                              //i disabled it because it should continue addons price calculation
                          }

                      }
                  } else {
                      input.val(0);
                  }

              });
              $('.input-number').focusin(function(){
                 $(this).data('oldValue', $(this).val());
              });
              $('.input-number').change(function() {
                  
                  minValue =  parseInt($(this).attr('min'));
                  maxValue =  parseInt($(this).attr('max'));
                  valueCurrent = parseInt($(this).val());
                  
                  name = $(this).attr('name');
                  if(valueCurrent >= minValue) {
                      $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
                  } else {
                      alert('Sorry, the minimum value was reached');
                      $(this).val($(this).data('oldValue'));
                  }
                  if(valueCurrent <= maxValue) {
                      $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
                  } else {
                      alert('Sorry, the maximum value was reached');
                      $(this).val($(this).data('oldValue'));
                  }
                  
              });
              $(".input-number").keydown(function (e) {
                      // Allow: backspace, delete, tab, escape, enter and .
                      if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                           // Allow: Ctrl+A
                          (e.keyCode == 65 && e.ctrlKey === true) || 
                           // Allow: home, end, left, right
                          (e.keyCode >= 35 && e.keyCode <= 39)) {
                               // let it happen, don't do anything
                               return;
                      }
                      // Ensure that it is a number and stop the keypress
                      if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                          e.preventDefault();
                      }
                  });

              $(document).on('click keyup', '.update-addons-total', function() {

                        fieldID = $(this).attr('data-id');
                        price = $("#addon-price-"+fieldID).val()*1;
                        quantity = $("#addon-quantity-"+fieldID).val()*1;
                        total = price * quantity;
                        $("#addon-price-total-"+fieldID).val(total);

                        var addonsGrandTotal = 0;
                        $(".addon-total").each(function(){
                            addonsGrandTotal += +$(this).val();
                        });
                        addonsGrandTotal = addonsGrandTotal.toFixed(2);
                        $("#calculated-addons-price").val(addonsGrandTotal);
                        $("#calculated-addons-price-html").html(addonsGrandTotal);

              });

              </script>














    <div class="form-group">
      @foreach ($lineitems as $lineitem)
      <div class="col-sm-12 col-xs-12 checkbox">
        @if ($lineitem->is_required == '1')
        <div class="col-sm-5 col-xs-5 control-label">
          {!!$lineitem->title!!}
        </div>
        <div class="col-sm-4 col-xs-4"> <small>required</small> </div>
        <div class="col-sm-3 col-xs-3">
          @if ($lineitem->value_type == "fixed")
          ${{$lineitem->value}}
          @endif
          @if ($lineitem->value_type == "percentage")
          {{$lineitem->value}}%
          @endif
        </div>
        @else
        <div class="col-sm-5 col-xs-5 control-label">
          {!!$lineitem->title!!}
        </div>
        <div class="col-sm-4 col-xs-4">
          <label>
          <input name="lineitem-{{$lineitem->id}}" type="checkbox" 
            id="lineitem-{{$lineitem->id}}" class="update-reservation-price" 
            <?php if($lineitem->selected==true){ echo 'checked="checked"'; }?> /> 
          Add </label>
        </div>
        <div class="col-sm-3 col-xs-3">
          @if ($lineitem->value_type == "fixed")
          ${{$lineitem->value}}
          @endif
          @if ($lineitem->value_type == "percentage")
          %{{$lineitem->value}}
          @endif
        </div>
        @endif
      </div>
      @endforeach
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Sub Total</label>
      <div class="col-sm-8 col-xs-12">
        <textarea name="sub_total_detail" id="sub-total-detail" class="form-control height-100" placeholder="Auto Calculation">@if(old('sub_total_detail')){!! old('sub_total_detail') !!}@elseif(isset($reservation->sub_total_detail)){!!$reservation->sub_total_detail!!}@endif</textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Total</label>
      <div class="col-sm-8 col-xs-12">
        <div class="input-group"> <span class="input-group-addon">$</span>
          <input name="total_amount" id="calculated-total-amount" type="text" class="form-control" placeholder="Auto Calculation" 
            value="@if(old('total_amount')){!! old('total_amount') !!}@elseif(isset($reservation->total_amount)){!!$reservation->total_amount!!}@endif" 
            />
        </div>
        <br/>
            @if(isset($reservation->total_amount))<small>Last Saved: ${!!$reservation->total_amount!!}</small>@endif
      </div>
    </div>
  </div>
</fieldset>
<fieldset class="col-md-12 table-bordered">
  <legend>For Office Use</legend>
  <div class="col-xs-12 col-sm-6">
    <!-- <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Housekeeper:</label>
      <div class="col-sm-8 col-xs-12">
        <select name="housekeeper_id" class="form-control">
        <option value="0"
        @if (!isset($reservation->housekeeper_id)) {{ 'selected="selected"' }} @endif
        > - select - </option>
        @foreach ($housekeepers as $housekeeper)
        <option value="{{ $housekeeper->id }}"
        @if (old('housekeeper_id') == $housekeeper->id) {!!'selected="selected"'!!} 
        @elseif (isset($reservation->housekeeper_id) and $reservation->housekeeper_id == $housekeeper->id) {!!'selected="selected"'!!} 
        @endif
        >{!!$housekeeper->firstname!!} {!!$housekeeper->lastname!!}</option>
        @endforeach
        </select>
      </div>
    </div> -->
    <!-- <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Vendor:</label>
      <div class="col-sm-8 col-xs-12">
        <select name="vendor_id" class="form-control">
        <option value="0"
        @if (!isset($reservation->vendor_id)) {{ 'selected="selected"' }} @endif
        > - select - </option>
        @foreach ($vendors as $vendor)
        <option value="{{ $vendor->id }}"
        @if (old('vendor_id') == $vendor->id) {!!'selected="selected"'!!} 
        @elseif (isset($reservation->vendor_id) and $reservation->vendor_id == $vendor->id) {!!'selected="selected"'!!} 
        @endif
        >{!!$vendor->firstname!!} {!!$vendor->lastname!!}</option>
        @endforeach
        </select>
      </div>
    </div> -->
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Status:</label>
      <div class="col-sm-8 col-xs-12 checkbox">
        <label>
        <input name="booking_status" type="radio" value="booked"
        @if (isset($reservation->status) and $reservation->status == 'booked')
        checked="checked"
        @endif />
        Booked</label>
        <label>
        <input name="booking_status" type="radio" value="pending"
        @if (isset($reservation->status) and $reservation->status == 'pending')
        checked="checked"
        @endif />
        Pending</label>
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-12 checkbox">
        <label>
        <input name="notify_customer" type="checkbox" />
        Notify Customer</label>
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-12 checkbox">
        <label>
        <input name="notify_owner" type="checkbox" />
        Notify Owner</label>
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-12 checkbox">
        <label>
        <input name="notify_housekeeper" type="checkbox" />
        Notify Housekeeper</label>
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-12 checkbox">
        <label>
        <input name="notify_vendor" type="checkbox" />
        Notify Vendor</label>
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6">
    <div class="form-group">
      <label class="col-sm-3 col-xs-12 control-label">Notes</label>
      <div class="col-sm-9 col-xs-12">
        <textarea name="notes" class="form-control height-150" placeholder="...">@if(old('notes')){!! old('notes') !!}@elseif(isset($reservation->notes)){!!$reservation->notes!!}@endif</textarea>
      </div>
    </div>
  </div>
</fieldset>
<fieldset class="col-md-12 table-bordered">
  <div class="form-group text-center">
    <input type="hidden" name="property_id" id="property_id" value="{{$property_id}}">
    <input type="hidden" name="reservation_id" id="reservation_id" value="{{$reservation_id}}">
    @if (isset($edit))
    <div class="checkbox">
      <label>
      <input id="generate-duplicate" type="checkbox" />
      Generate Duplicate
      </label>
    </div>
    @endif 
  </div>
</fieldset>
<script>
  $('#generate-duplicate').on('change', function(){
      if ($(this).is(':checked')) {
          $('form').attr('action', "{{ url('/admin/reservations/store/'.$property_slug) }}");
  
      } else {
          $('form').attr('action', "{{ url('/admin/reservations/update') }}");
  
      }
  });
</script>

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
  
      var calendar = new PropertyCalendar("{{url('/')}}", "{{$property_slug}}", "{{$reservation_id}}", $lineitems);
      <?php
      $pre_select_date_start = (null!==\Session::get('dates_searched')) ? min(\Session::get('dates_searched')):'NA';
      $pre_select_date_end = (null!==\Session::get('dates_searched')) ? max(\Session::get('dates_searched')):'NA';
      $year = ($pre_select_date_start!='NA')?date('Y',strtotime($pre_select_date_start)):date('Y'); 
      $month = ($pre_select_date_start!='NA')?date('n',strtotime($pre_select_date_start)):date('n'); 
      ?>
  
      calendar.loadCalendar("{{$year}}", "{{$month}}", "{{$pre_select_date_start}}", "{{$pre_select_date_end}}");
  
      $(document).on('click', '.calendar-navigate', function() {
          var $year = $(this).data("year");
          var $month = $(this).data("month");
          calendar.loadCalendar($year, $month);
      });

      <?php if('NA'!==$pre_select_date_start and 'NA'!==$pre_select_date_end ){ ?>
        calendar.preBookingMessage("{{$pre_select_date_start}}", "{{$pre_select_date_end}}");
        calendar.calculatePrice("{{$pre_select_date_start}}", "{{$pre_select_date_end}}");
      <?php } ?>
  
  
      @if($pre_select_date_start!='NA' and $pre_select_date_end=='NA')
      <?php $cycle = intval((strtotime($pre_select_date_start) - strtotime(date('Ymd'))) / 86400);
    $cycle += 1001;
    ?>
      window.lastClickCycleID = <?=$cycle?>;
      window.lastClickedDateValue = '<?=date('Y-m-d',strtotime($pre_select_date_start))?>';
      @else
      window.lastClickCycleID = 0;
      window.lastClickedDateValue = 0;
      @endif
  
  
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
  
      $(document).on('click keyup', '.update-reservation-price', function() {
          calendar.AddRemoveLineItems();
      });
  
  });
  
</script>
<script src="{{asset('js/reservations.js')}}"></script>
