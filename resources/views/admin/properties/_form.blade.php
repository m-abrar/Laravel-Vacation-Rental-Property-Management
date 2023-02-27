
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@if(isset($property->id))
<input type="hidden" name="id" value="{{ $property->id }}">
@endif
<div class="col-md-12">
  <fieldset>
    <legend>General Detail</legend>
    <div class="col-md-6">
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Title/Name<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <input 
            type="text"
            name = "title"
            placeholder="Enter title here"
            value="@if(old('title')){!! old('title') !!}@elseif(isset($property->title)){!!$property->title!!}@endif"
            class="form-control"
            />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Slug<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <input name="slug" type="text" id="slug" class="form-control" 
            value="@if(old('slug')){!! old('slug') !!}@elseif(isset($property->slug)){!!$property->slug!!}@endif"
            />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Code/SKU<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <input name="code" type="text" id="code" class="form-control" 
            value="@if(old('code')){!! old('code') !!}@elseif(isset($property->code)){!!$property->code!!}@endif"
            />
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Category<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <select name="category" class="form-control">
          <option value=""
          @if (!isset($property->category_id) or old('category') == "") {{ 'selected="selected"' }} @endif
          > - select - </option>
          @foreach ($categories as $category)
          <option value="{{ $category->id }}"
          @if (old('category') == $category->id) {!!'selected="selected"'!!} 
          @elseif (isset($property->category_id) and $property->category_id == $category->id) {!!'selected="selected"'!!} 
          @endif
          >{!!$category->title!!}</option>
          @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
      <?php
        $classes_selected = array();
        if(@$property){
        foreach ($property->classez as $class) {
          array_push($classes_selected, $class->class_id);
        }
      
      }
      ?>
        <label class="col-sm-4 col-xs-12 control-label">Classes<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <select name="classes[]" class="form-control property-classes" multiple="multiple">
          @foreach ($classes as $class)
          <option value="{{ $class->id }}" 
          <?php if(in_array($class->id, $classes_selected)){
          echo 'selected="selected"';
          }
          ?>
          >{!!$class->title!!}</option>
          @endforeach
          </select>
          <script type="text/javascript">
            $(".property-classes").select2();
          </script>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Minimum stay<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <div class="input-group"> 
          <input name="minimum_stay_nights" type="text" class="form-control" 
            value="@if(old('minimum_stay_nights')){!! old('minimum_stay_nights') !!}@elseif(isset($property->minimum_stay_nights)){!!$property->minimum_stay_nights!!}@endif"
            /><span class="input-group-addon">nights</span></div>
        </div>
      </div><!-- upgrade - 12/10/2016 - minimum_nights -->
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Bedrooms<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <input name="bedrooms" type="text" class="form-control" 
            value="@if(old('bedrooms')){!! old('bedrooms') !!}@elseif(isset($property->bedrooms)){!!$property->bedrooms!!}@endif"
            />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Bathrooms<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <input name="bathrooms" type="text" class="form-control" 
            value="@if(old('bathrooms')){!! old('bathrooms') !!}@elseif(isset($property->bathrooms)){!!$property->bathrooms!!}@endif"
            />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Sleeps<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <input name="sleeps" type="text" class="form-control" 
            value="@if(old('sleeps')){!! old('sleeps') !!}@elseif(isset($property->sleeps)){!!$property->sleeps!!}@endif"
            />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Garages<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <input name="garages" type="text" class="form-control" 
            value="@if(old('garages')){!! old('garages') !!}@elseif(isset($property->garages)){!!$property->garages!!}@endif"
            />
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Address<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <input name="address" type="text" id="address" class="form-control" 
            value="@if(old('address')){!! old('address') !!}@elseif(isset($property->address)){!!$property->address!!}@endif"
            />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">City<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <input name="city" type="text" id="city" class="form-control" 
            value="@if(old('city')){!! old('city') !!}@elseif(isset($property->city)){!!$property->city!!}@endif"
            />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">State<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <select name="state" class="form-control">
          <option value=""
          @if (!isset($property->state_id)) {{ 'selected="selected"' }} @endif
          > - select - </option>
          @foreach ($states as $state)
          <option value="{{ $state->id }}"
          @if (old('state') == $state->id) {!!'selected="selected"'!!} 
          @elseif (isset($property->state_id) and $property->state_id == $state->id) {!!'selected="selected"'!!} 
          @endif
          >{!!$state->title!!}</option>
          @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Zip Code<font color="#FF0000">*</font></label>
        <div class="col-sm-8 col-xs-12">
          <input name="zip" type="text" id="zip" class="form-control" 
            value="@if(old('zip')){!! old('zip') !!}@elseif(isset($property->zip)){!!$property->zip!!}@endif"
            />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Lat,Long</label>
        <div class="col-sm-8 col-xs-12">
          <div class="input-group">
            <input name="latitude" type="text" id="latitude" class="form-control" 
              value="@if(old('latitude')){!! old('latitude') !!}@elseif(isset($property->latitude)){!!$property->latitude!!}@endif"
              />
            <input name="longitude" type="text" id="longitude" class="form-control" 
              value="@if(old('longitude')){!! old('longitude') !!}@elseif(isset($property->longitude)){!!$property->longitude!!}@endif"
              />
            <span class="input-group-addon">
            <a href="#myMapModal" data-toggle="modal">Open Map</a>
            </span> 
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Display Order</label>
        <div class="col-sm-8 col-xs-12">
          <input name="display_order" type="text" class="form-control" 
            value="@if(old('display_order')){!! old('display_order') !!}@elseif(isset($property->display_order)){!!$property->display_order!!}@endif"
            />
        </div>
      </div>
    </div>
  </fieldset>
  <br/><br/>
</div>
<div class="col-md-12">
  <fieldset class="checkbox">
    <legend>Indexing Control</legend>
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-4 col-xs-6 ">
          <label>
          <input name="is_active" type="checkbox" value="1"
          @if(old('is_active')){{'checked="checked"'}}
          @elseif(isset($property->is_active) and ($property->is_active=='1')){{'checked="checked"'}}@endif />
          Property is Active</label>
        </div>
        <div class="col-md-4 col-xs-6">
          <label>
          <input name="is_featured" type="checkbox" value="1"
          @if(old('is_featured')){{'checked="checked"'}}
          @elseif(isset($property->is_featured) and ($property->is_featured=='1')){{'checked="checked"'}}@endif />
          Featured Property</label>
        </div>
        <div class="col-md-4 col-xs-6">
          <label>
          <input name="is_new" type="checkbox" value="1"
          @if(old('is_new')){{'checked="checked"'}}
          @elseif(isset($property->is_new) and ($property->is_new=='1')){{'checked="checked"'}}@endif />
          Mark as New</label>
        </div>
        <div class="col-md-4 col-xs-6">
          <label>
          <input name="is_vacation" type="checkbox" value="1"
          @if(old('is_vacation')){{'checked="checked"'}}
          @elseif(isset($property->is_vacation) and ($property->is_vacation=='1')){{'checked="checked"'}}@endif />
          Available for Vacation Rental</label>
        </div>
        <div class="col-md-4 col-xs-6">
          <label>
          <input name="is_sale" type="checkbox" value="1"
          @if(old('is_sale')){{'checked="checked"'}}
          @elseif(isset($property->is_sale) and ($property->is_sale=='1')){{'checked="checked"'}}@endif />
          Displaying for Sale</label>
        </div>
        <!-- <div class="col-md-4 col-xs-6">
          <label>
          <input name="is_long_term" type="checkbox" value="1"
          @if(old('is_long_term')){{'checked="checked"'}}
          @elseif(isset($property->is_long_term) and ($property->is_long_term=='1')){{'checked="checked"'}}@endif />
          Available for Long Term Rental</label>
          </div> -->
        <!-- <div class="col-md-4 col-xs-6">
          <label>
          <input name="is_calendar" type="checkbox" value="1"
          @if(old('is_calendar')){{'checked="checked"'}}
          @elseif(isset($property->is_calendar) and ($property->is_calendar=='1')){{'checked="checked"'}}@endif />
          User can see Availability Calendar</label>
          </div> -->
        <div class="col-md-4 col-xs-6">
          <label>
          <input name="is_rates" type="checkbox" value="1"
          @if(old('is_rates')){{'checked="checked"'}}
          @elseif(isset($property->is_rates) and ($property->is_rates=='1')){{'checked="checked"'}}@endif />
          User can see Rental Rates </label>
        </div>
      </div>
    </div>
    <br/><br/>
  </fieldset>
</div>
<!---POPUP BUTTONS-->
<div class="col-md-12">
  <fieldset>
    <legend>Property Data</legend>
    <div class="col-md-12" role="tabpanel">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">Summary</a></li>
        <li role="presentation"><a href="#description" aria-controls="description" role="tab" data-toggle="tab">Description</a></li>
        <li role="presentation"><a href="#pictures" aria-controls="pictures" role="tab" data-toggle="tab">Pictures</a></li>
        <li role="presentation"><a href="#rates" aria-controls="rates" role="tab" data-toggle="tab">Pricing</a></li>
        <li role="presentation"><a href="#features" aria-controls="features" role="tab" data-toggle="tab">Add Features</a></li>
        <li role="presentation"><a href="#amenities" aria-controls="amenities" role="tab" data-toggle="tab">Add Amenities</a></li>
        <li role="presentation"><a href="#lineitems" aria-controls="lineitems" role="tab" data-toggle="tab">Line Items</a></li>
        <li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">Reviews</a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="summary">
          <div class="form-group">
            <label class="col-sm-2 col-xs-12 control-label">Summary<font color="#FF0000">*</font></label>
            <div class="col-sm-10 col-xs-12">
              <textarea name="summary" class="form-control mceEditor"
                placeholder="Enter brief details."
                >@if(old('summary')){!! old('summary') !!}@elseif(isset($property->summary)){!!$property->summary!!}@endif</textarea>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="description">
          <div class="form-group">
            <label class="col-sm-2 col-xs-12 control-label">Description<font color="#FF0000">*</font></label>
            <div class="col-sm-10 col-xs-12">
              <textarea name="description" class="form-control mceEditor"
                placeholder="Enter property detail here."
                >@if(old('description')){!! old('description') !!}@elseif(isset($property->description)){!!$property->description!!}@endif</textarea>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="pictures"> @include('admin.layouts.objects.images') *After adding/changing pictures update the property.</div>
        <div role="tabpanel" class="tab-pane" id="rates"> 

          <h4> Sale Price </h4>

          <div class="form-group">
            <div class="col-mm-4 col-xs-6">
              <div class="input-group"><span class="input-group-addon">$</span>
              <input name="sale_price" type="number" id="sale_price" class="form-control" 
                value="@if(old('sale_price')){!! old('sale_price') !!}@elseif(isset($property->sale_price)){!!$property->sale_price!!}@endif"
                />
                </div>
            </div>
          </div>
          <br/><br/>

          <h4> Rental Prices </h4>
        @include ('admin.properties._rates') 

        </div>
        <div role="tabpanel" class="tab-pane" id="features"> @include ('admin.properties._features') </div>
        <div role="tabpanel" class="tab-pane" id="amenities"> @include ('admin.properties._amenities') </div>
        <div role="tabpanel" class="tab-pane" id="lineitems"> @include ('admin.properties._lineitems') </div>
        <div role="tabpanel" class="tab-pane" id="reviews">
          <div class="form-group">
            <label class="col-sm-2 col-xs-12 control-label">Reviews</label>
            <div class="col-sm-10 col-xs-12">
              <textarea name="reviews" class="form-control mceEditor" id="mceEditor" style="min-height:200px;" 
                placeholder="Enter property reviews here. (Required minimum 100 characters)"
                >@if(old('reviews')){!! old('reviews') !!}@elseif(isset($property->reviews)){!!$property->reviews!!}@endif</textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </fieldset>
  <br/><br/>
</div>
<!--END OF POPUP BUTTONS-->
<div class="col-md-12">
  <fieldset>
    <legend>Accounts/Office</legend>
    <div class="col-md-6">
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Commission</label>
        <div class="col-sm-8 col-xs-12">
          <div class="input-group"> <span class="input-group-addon">%</span>
            <input name="commission_value" type="text" class="form-control" placeholder="##" maxlength="2" 
              value="@if(old('commission_value')){!! old('commission_value') !!}@elseif(isset($property->commission_value)){!!$property->commission_value!!}@endif" 
              />
            <span class="input-group-addon">
            <input name="is_commission" type="checkbox" value="1"
            @if(old('is_commission')){{'checked="checked"'}}
            @elseif(isset($property->is_commission) and ($property->is_commission=='1')){{'checked="checked"'}}@endif />
            Active </span> 
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Admin Notes</label>
        <div class="col-sm-8 col-xs-12">
          <textarea name="notes_admin" class="form-control" style="min-height:100px;" 
            placeholder="Enter hidden notes only for admin."
            >@if(old('notes_admin')){!! old('notes_admin') !!}@elseif(isset($property->notes_admin)){!!$property->notes_admin!!}@endif</textarea>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Housekeeper</label>
        <div class="col-sm-8 col-xs-12">
          <select name="housekeeper_id" class="form-control">
          <option value="0"
          @if (!isset($property->housekeeper_id)) {{ 'selected="selected"' }} @endif
          > - select - </option>
          @foreach ($housekeepers as $housekeeper)
          <option value="{{ $housekeeper->id }}"
          @if (old('housekeeper_id') == $housekeeper->id) {!!'selected="selected"'!!} 
          @elseif (isset($property->housekeeper_id) and $property->housekeeper_id == $housekeeper->id) {!!'selected="selected"'!!} 
          @endif
          >{!!$housekeeper->firstname!!} {!!$housekeeper->lastname!!}</option>
          @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Vendor</label>
        <div class="col-sm-8 col-xs-12">
          <select name="vendor_id" class="form-control">
          <option value="0"
          @if (!isset($property->vendor_id)) {{ 'selected="selected"' }} @endif
          > - select - </option>
          @foreach ($vendors as $vendor)
          <option value="{{ $vendor->id }}"
          @if (old('vendor_id') == $vendor->id) {!!'selected="selected"'!!} 
          @elseif (isset($property->vendor_id) and $property->vendor_id == $vendor->id) {!!'selected="selected"'!!} 
          @endif
          >{!!$vendor->firstname!!} {!!$vendor->lastname!!}</option>
          @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">User(Owner/Agent)</label>
        <div class="col-sm-8 col-xs-12">
          <select name="user_id" class="form-control">
          <option value="0"
          @if (!isset($property->user_id)) {{ 'selected="selected"' }} @endif
          > - select - </option>
          @foreach ($owners as $owner)
          <option value="{{ $owner->id }}"
          @if (old('user_id') == $owner->id) {!!'selected="selected"'!!} 
          @elseif (isset($property->user_id) and $property->user_id == $owner->id) {!!'selected="selected"'!!} 
          @endif
          >{!!$owner->firstname!!} {!!$owner->lastname!!}</option>
          @endforeach
          </select>
        </div>
      </div>
    </div>
  </fieldset>
  <br/><br/>
</div>
<div class="col-md-12">
  <fieldset>
    <div class="form-group text-center">
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
</div>



<!-- Google Map Modal -->
<div class="modal fade modal-fullscreen force-fullscreen" id="myMapModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Google Map</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div id="google-map-canvas" class=""></div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-4"><b>Status:</b></div>
            <div class="col-md-8">
              <div id="markerStatus">Click and drag the marker.</div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-4"><b>Current position:</b></div>
            <div class="col-md-6">
              <div id="marker-latlng"></div>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success pull-right applyLatLong">Apply</button>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-4"><b>Nearest address:</b></div>
            <div class="col-md-6">
              <div id="address"></div>
            </div>
            <div class="col-md-2"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- End of Google Map Modal -->


<!-- Change action of the form if you want to dulicate the data -->
<script>
  $('#generate-duplicate').on('change', function(){
      if ($(this).is(':checked')) {
          $('form').attr('action', "{{ url('/admin/properties/create') }}");
      } else {
          $('form').attr('action', "{{ url('/admin/properties/update') }}");
      }
  });
</script>


<!-- jQuery: Customization for Google Map  -->

<script type='text/javascript' src="http://maps.googleapis.com/maps/api/js?sensor=false&key={!! $settings->google_map_api_key !!}"></script>

<!-- improved on 7/19/2017 -->

<script type='text/javascript'>
  $(document).on('click', '.applyLatLong', function() {
    var latlong = $('#marker-latlng').html();
    latlongsplit = latlong.split(',');
    $('#latitude').val(latlongsplit[0]);
    $('#longitude').val(latlongsplit[1]);
    $('.applyLatLong').prop('disabled', true);
    $('.applyLatLong').html('Applied');

  });
  $(document).ready(function() {
    var geocoder = new google.maps.Geocoder();
    var map;        
    @if(old('latitude') and old('longitude'))
    var latLng = new google.maps.LatLng("{{old('latitude')}}","{{old('longitude')}}");
    @elseif(isset($property->latitude) and isset($property->longitude))
    var latLng = new google.maps.LatLng("{{$property->latitude}}","{{$property->longitude}}");
    @else
  var latLng = new google.maps.LatLng("{{$settings->latitude}}","{{$settings->longitude}}"); //Load office address as default location
  @endif

  var marker=new google.maps.Marker({
    position:latLng,
    map: map,
    draggable: true
  });
  
  function geocodePosition(pos) {
    geocoder.geocode({
      latLng: pos
    }, function(responses) {
      if (responses && responses.length > 0) {
        updateMarkerAddress(responses[0].formatted_address);
      } else {
        updateMarkerAddress('Cannot determine address at this location.');
      }
    });
  }
  
  function updateMarkerStatus(str) {
    document.getElementById('markerStatus').innerHTML = str;
  }
  
  function updateMarkerPosition(latLng) {
    document.getElementById('marker-latlng').innerHTML = [
    latLng.lat().toFixed(5),
    latLng.lng().toFixed(5)
    ].join(', ');
    $('.applyLatLong').prop('disabled', false);
    $('.applyLatLong').html('Apply');
  }
  
  function updateMarkerAddress(str) {
    document.getElementById('address').innerHTML = str;
  }
  
  function initialize() {
    var mapProp = {
      center:latLng,
      zoom: 14,
      draggable: true,
      scrollwheel: true,
      mapTypeId:google.maps.MapTypeId.ROADMAP
    };

  // Update current position info.
  
  map=new google.maps.Map(document.getElementById("google-map-canvas"),mapProp);
  marker.setMap(map);
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.setContent(contentString);
    infowindow.open(map, marker);
  });
  
  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });
  updateMarkerPosition(latLng);
  geocodePosition(latLng);
  
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Drag ended');
    geocodePosition(marker.getPosition());
  });
  
};
google.maps.event.addDomListener(window, 'load', initialize);

google.maps.event.addDomListener(window, "resize", resizingMap());

$('#myMapModal').on('shown.bs.modal', function() {
  //Must wait until the render of the modal appear, thats why we use the resizeMap and NOT resizingMap!! ;-)
resizeMap();
})

function resizeMap() {
  if(typeof map =="undefined") return;
  setTimeout( function(){resizingMap();} , 400);
}

function resizingMap() {
  if(typeof map =="undefined") return;
  var center = map.getCenter();
  google.maps.event.trigger(map, "resize");
  map.setCenter(center); 
}

});

</script>
