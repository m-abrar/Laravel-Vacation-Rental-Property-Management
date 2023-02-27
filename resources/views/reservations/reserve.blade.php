<!-- 
1. Reserving a property
2. Showing preview image of property
3. Showing calculations of reservation total amount
4. Filling out customer detail form 
-->
@extends('layouts.default.start')
@section('title')
Reserve | {{$property->title}} - {{$settings->site_title}}
@endsection
@section('contents')
<div class="container page-body">
  <!-- Page Heading/Breadcrumbs -->
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">{{trans('eminent.booking')}} <small>-
        {{ $property->title }}
        </small> 
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php">{{trans('eminent.home')}}</a></li>
        <li><a href="properties.php">{{trans('eminent.booking')}}</a></li>
        <li class="active">
          {{ $property->title }}
        </li>
      </ol>
    </div>
  </div>

  @include('include.alerts')

  <!-- /.row -->
  <!-- Property Brief Information -->
  <div class="row">
    <form class="form-horizontal" role="form" method="post" action="{{url('reserve')}}/{{$property->slug}}/{{date('Y-m-d',strtotime($date_start))}}/{{date('Y-m-d',strtotime($date_end))}}/store">
      <div class="col-md-3">
        <div id="propertyMainImage"> 
          <img class="img-responsive" src="{{asset($property->images->first()->image)}}" alt="{!!$property->title!!}" > 
        </div>
        <br>
        <div class="row">
          <div class="col-md-5 info-cell">
            {{trans('eminent.property.bedrooms')}}
            <div class="pull-right">
              {{ $property->bedrooms }}
            </div>
          </div>
          <div class="col-md-5 info-cell">
            {{trans('eminent.property.bathrooms')}}
            <div class="pull-right">
              {{ $property->bathrooms }}
            </div>
          </div>
          <div class="col-md-5 info-cell">
            {{trans('eminent.property.sleeps')}}
            <div class="pull-right">
              {{ $property->sleeps }}
            </div>
          </div>
          <div class="col-md-5 info-cell">
            {{trans('eminent.property.garages')}}
            <div class="pull-right">
              {{ $property->garages }}
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
        <h3>{{trans('eminent.reservation.booking-detail')}}</h3>
        <dl class="dl-horizontal">
          <dt>{{trans('eminent.reservation.date-of-arrival')}}</dt>
          <dd>{{ ($date_start) }}</dd>
          <dt>{{trans('eminent.reservation.date-of-departure')}}</dt>
          <dd>{{ ($date_end) }}</dd>
          <dt>{{trans('eminent.nights')}}</dt>
          <dd>{{ $nights }}</dd>
          <dt>{{trans('eminent.reservation.lodging-amount')}}</dt>
          <dd>@if(is_numeric($lodging_amount)) ${{number_format($lodging_amount,2)}} @else 'Error!' @endif</dd>
        </dl>
        <input type="hidden" id="calculated-lodging-price" value="@if(is_numeric($lodging_amount)){{$lodging_amount}}@endif" />
        <h3>Addon Services</h3>
        <div class="addons">
          @foreach ($addons as $addon)
          <div class="col-sm-12 col-xs-12" style="padding-bottom:8px;">

            <div class="col-sm-5 col-xs-5">
              <img data-toggle="modal" data-target="#addonModal-{{$addon->id}}" class="img-responsive img-rounded" src="{{asset($addon->image)}}" alt="{!!$addon->title!!}" > 
            </div>

            <div class="col-sm-7 col-xs-7">
              <strong>{!!$addon->title!!}</strong> - ${{number_format($addon->price,2)}}
              <input type="hidden" id="addon-price-{{$addon->id}}" value="{{number_format($addon->price,2)}}" />
              <input type="hidden" id="addon-price-total-{{$addon->id}}" class="addon-total" />
              <br/>
              {!!$addon->summary!!}
              <br/>


              <!-- Trigger the modal with a button -->
              <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#addonModal-{{$addon->id}}">{{trans('eminent.view-detail')}}</a>
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
                      {{trans('eminent.price')}} ${{number_format($addon->price,2)}}
                      </div>
                      <div class="col-md-6">
                      <img class="img-responsive img-rounded image-200" src="{{asset($addon->image)}}" alt="{!!$addon->title!!}" >
                      </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('eminent.close')}}</button>
                    </div>
                  </div>

                </div>
              </div>

              
              <div class="col-sm-3 col-xs-3 control-label">
              {{trans('eminent.quantity')}} 
              </div>
              <div class="col-sm-9 col-xs-9">
              <div class="input-group">
                  <span class="input-group-btn">
                      <button type="button" class="btn btn-default btn-number update-addons-total update-reservation-price" data-type="minus" data-field="quantity_{{$addon->id}}" data-id="{{$addon->id}}" />
                          <span class="glyphicon glyphicon-minus"></span>
                      </button>
                  </span>
                  <input type="text" id="addon-quantity-{{$addon->id}}" name="quantity_{{$addon->id}}" class="form-control input-number update-addons-total update-reservation-price" value="0" min="0" max="999" data-id="{{$addon->id}}" />
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
      <input type="hidden" id="calculated-addons-price" />
          <dt>{{trans('eminent.reservation.addons-total')}}</dt>
          <dd>$<soan id="calculated-addons-price-html">0.00</soan></dd>
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


        <h3>{{trans('eminent.reservation.taxes-and-addons')}}</h3>
        <div class="form-group">
          @foreach ($lineitems as $lineitem)
          <div class="col-sm-12 col-xs-12 checkbox">
            @if ($lineitem->is_required == '1')
            <div class="col-sm-4 col-xs-4 control-label">
              {!!$lineitem->title!!}
            </div>
            <div class="col-sm-3 col-xs-3"> <small>required</small> 
            </div>
            <div class="col-sm-5 col-xs-5">@if ($lineitem->value_type == "fixed")
              ${{number_format($lineitem->value,2)}}
              @endif
              @if ($lineitem->value_type == "percentage")
              {{$lineitem->value}}%
              @endif
            </div>
            @else
            <div class="col-sm-4 col-xs-4 control-label">
              {!!$lineitem->title!!}
            </div>
            <div class="col-sm-3 col-xs-3"><label>
              <input name="{!!$lineitem->slug!!}" type="checkbox" id="lineitem-{{$lineitem->id}}" 
                class="update-reservation-price" > 
              <strong>{{trans('eminent.reservation.add')}}</strong> </label>
            </div>
            <div class="col-sm-5 col-xs-5">
              @if ($lineitem->value_type == "fixed")
              ${{number_format($lineitem->value,2)}}
              @endif
              @if ($lineitem->value_type == "percentage")
              {{$lineitem->value}}%
              @endif
            </div>
            @endif
          </div>
          @endforeach
        </div>
        <textarea style="display:none" id="sub-total-detail" name="sub_total_detail">@if(is_numeric($lodging_amount)){{$lodging_amount}}@endif</textarea>
        <dl class="dl-horizontal">
          <dt><h3>{{trans('eminent.reservation.total-amount')}}</h3></dt>
          <dd><h3>$<span id="calculated-total-amount">Can not proceed!</span></h3></dd>
        </dl>
      </div>
      <div class="col-md-4 booking-form">
        <div class="row">
        <h3>{{trans('eminent.reservation.contact-detail')}}</h3>
        </div>

        <div class="form-group">
          <label class="col-sm-4 col-xs-12 control-label">{{trans('eminent.reservation.first-name')}}<font color="#FF0000">*</font></label>
          <div class="col-sm-8 col-xs-12">
            <input name="firstname" type="text" value="@if(old('firstname')){!! old('firstname') !!}@endif" class="form-control"  />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 col-xs-12 control-label">{{trans('eminent.reservation.last-name')}}<font color="#FF0000">*</font></label>
          <div class="col-sm-8 col-xs-12">
            <input name="lastname" type="text" value="@if(old('lastname')){!! old('lastname') !!}@endif" class="form-control"  />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 col-xs-12 control-label">{{trans('eminent.reservation.email')}}<font color="#FF0000">*</font></label>
          <div class="col-sm-8 col-xs-12">
            <input name="email" type="text" value="@if(old('email')){!! old('email') !!}@endif" class="form-control"  />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 col-xs-12 control-label">{{trans('eminent.reservation.phone')}}<font color="#FF0000">*</font></label>
          <div class="col-sm-8 col-xs-12">
            <input name="phone" type="text" value="@if(old('phone')){!! old('phone') !!}@endif" class="form-control"  />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 col-xs-12 control-label">{{trans('eminent.reservation.city')}}<font color="#FF0000">*</font></label>
          <div class="col-sm-8 col-xs-12">
            <input name="city" type="text" value="@if(old('city')){!! old('city') !!}@endif" class="form-control"  />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 col-xs-12 control-label">{{trans('eminent.reservation.state')}}<font color="#FF0000">*</font></label>
          <div class="col-sm-8 col-xs-12">
            <select name="state" class="form-control"  >
            <option value=""
            @if (!old('state') or old('state') == '') {{ 'selected="selected"' }} @endif
            > {{trans('eminent.form.select')}} </option>
            @foreach ($states as $state)
            <option value="{{ $state->id }}"
            @if (old('state') == $state->id) {!!'selected="selected"'!!}@endif
            >{!!$state->title!!}</option>
            @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 col-xs-12 control-label">{{trans('eminent.reservation.zip')}}<font color="#FF0000">*</font></label>
          <div class="col-sm-8 col-xs-12">
            <input name="zip" type="text" value="@if(old('zip')){!! old('zip') !!}@endif" class="form-control"  />
          </div>
        </div>
        <div class="form-group text-center">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-primary"> {{trans('eminent.reservation.payment')}} <span class="glyphicon glyphicon-chevron-right"></span> </button>
        </div>
      </div>
    </form>
  </div>
</div>
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
  
      var calendar = new PropertyCalendar("{{url('/')}}", "{{$property->slug}}", "NA", $lineitems);
      <?php
      $pre_select_date_start = (null!==\Session::get('dates_searched')) ? min(\Session::get('dates_searched')):'NA';
      $pre_select_date_end = (null!==\Session::get('dates_searched')) ? max(\Session::get('dates_searched')):'NA';
      $year = ($pre_select_date_start!='NA')?date('Y',strtotime($pre_select_date_start)):date('Y',strtotime('+2 days')); 
      $month = ($pre_select_date_start!='NA')?date('n',strtotime($pre_select_date_start)):date('n',strtotime('+2 days'));
      ?> 
  
      window.onload = calendar.AddRemoveLineItems();
  
      $(document).on('click keyup', '.update-reservation-price', function() {
          calendar.AddRemoveLineItems();
      });
  
  
  });
  
</script>
<script src="{{asset('js/reservations.js')}}"></script>
@endsection
