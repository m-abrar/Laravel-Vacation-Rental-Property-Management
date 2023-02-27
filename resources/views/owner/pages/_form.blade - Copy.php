<fieldset class="col-md-12 table-bordered">
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
      <label class="col-sm-4 col-xs-12 control-label">Slug</label>
      <div class="col-sm-8 col-xs-12">
        <input name="slug" type="text" id="slug" class="form-control" 
          value="@if(old('slug')){!! old('slug') !!}@elseif(isset($property->slug)){!!$property->slug!!}@endif"
          />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Code/SKU</label>
      <div class="col-sm-8 col-xs-12">
        <input name="code" type="text" id="code" class="form-control" 
          value="@if(old('code')){!! old('code') !!}@elseif(isset($property->code)){!!$property->code!!}@endif"
          />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Category</label>
      <div class="col-sm-8 col-xs-12">
        <select name="category_id" class="form-control">
        <option value="0"
        @if (!isset($property->category_id)) {{ 'selected="selected"' }} @endif
        > - select - </option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}"
        @if (old('category_id') == $category->id) {!!'selected="selected"'!!} 
        @elseif (isset($property->category_id) and $property->category_id == $category->id) {!!'selected="selected"'!!} 
        @endif
        >{!!$category->title!!}</option>
        @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Total Bedrooms<font color="#FF0000">*</font></label>
      <div class="col-sm-8 col-xs-12">
        <input name="bedrooms" type="text" class="form-control" 
          value="@if(old('bedrooms')){!! old('bedrooms') !!}@elseif(isset($property->bedrooms)){!!$property->bedrooms!!}@endif"
          />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Total Bathrooms<font color="#FF0000">*</font></label>
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
        <select name="state_id" class="form-control">
        <option value="0"
        @if (!isset($property->state_id)) {{ 'selected="selected"' }} @endif
        > - select - </option>
        @foreach ($states as $state)
        <option value="{{ $state->id }}"
        @if (old('state_id') == $state->id) {!!'selected="selected"'!!} 
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
      <label class="col-sm-4 col-xs-12 control-label">Latitude</label>
      <div class="col-sm-8 col-xs-12">
        <input data-toggle="modal" data-target="#mapModal" name="latitude" type="text" id="latitude" class="form-control" 
          value="@if(old('latitude')){!! old('latitude') !!}@elseif(isset($property->latitude)){!!$property->latitude!!}@endif"
          />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Longitude</label>
      <div class="col-sm-8 col-xs-12">
        <input data-toggle="modal" data-target="#mapModal" name="longitude" type="text" id="longitude" class="form-control" 
          value="@if(old('longitude')){!! old('longitude') !!}@elseif(isset($property->longitude)){!!$property->longitude!!}@endif"
          />
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
<fieldset class="col-md-12 table-bordered">
  <legend>Indexing Control</legend>
  <div class="col-md-4 col-xs-6 checkbox">
    <label>
    <input name="is_active" type="checkbox" value="1"
    @if(old('is_active')){{'checked="checked"'}}
    @elseif(isset($property->is_active) and ($property->is_active=='1')){{'checked="checked"'}}@endif />
    Property is Active</label>
  </div>
  <div class="col-md-4 col-xs-6 checkbox">
    <label>
    <input name="is_featured" type="checkbox" value="1"
    @if(old('is_featured')){{'checked="checked"'}}
    @elseif(isset($property->is_featured) and ($property->is_featured=='1')){{'checked="checked"'}}@endif />
    Featured Property</label>
  </div>
  <div class="col-md-4 col-xs-6 checkbox">
    <label>
    <input name="is_new" type="checkbox" value="1"
    @if(old('is_new')){{'checked="checked"'}}
    @elseif(isset($property->is_new) and ($property->is_new=='1')){{'checked="checked"'}}@endif />
    Mark as 'New'</label>
  </div>
  <div class="col-md-4 col-xs-6 checkbox">
    <label>
    <input name="is_vacation" type="checkbox" value="1"
    @if(old('is_vacation')){{'checked="checked"'}}
    @elseif(isset($property->is_vacation) and ($property->is_vacation=='1')){{'checked="checked"'}}@endif />
    Available for Vacation Rental</label>
  </div>
  <div class="col-md-4 col-xs-6 checkbox">
    <label>
    <input name="is_sale" type="checkbox" value="1"
    @if(old('is_sale')){{'checked="checked"'}}
    @elseif(isset($property->is_sale) and ($property->is_sale=='1')){{'checked="checked"'}}@endif />
    Displaying for Sale</label>
  </div>
  <div class="col-md-4 col-xs-6 checkbox">
    <label>
    <input name="is_long_term" type="checkbox" value="1"
    @if(old('is_long_term')){{'checked="checked"'}}
    @elseif(isset($property->is_long_term) and ($property->is_long_term=='1')){{'checked="checked"'}}@endif />
    Available for Long Term Rental</label>
  </div>
  <div class="col-md-4 col-xs-6 checkbox">
    <label>
    <input name="is_calendar" type="checkbox" value="1"
    @if(old('is_calendar')){{'checked="checked"'}}
    @elseif(isset($property->is_calendar) and ($property->is_calendar=='1')){{'checked="checked"'}}@endif />
    User can see Availability Calendar</label>
  </div>
  <div class="col-md-4 col-xs-6 checkbox">
    <label>
    <input name="is_rates" type="checkbox" value="1"
    @if(old('is_rates')){{'checked="checked"'}}
    @elseif(isset($property->is_rates) and ($property->is_rates=='1')){{'checked="checked"'}}@endif />
    User can see Rental Rates </label>
  </div>
</fieldset>
<!---POPUP BUTTONS-->
<fieldset class="col-md-12 table-bordered">
  <legend>Property Data</legend>
  <div class="col-md-12" role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">Summary</a></li>
      <li role="presentation"><a href="#description" aria-controls="description" role="tab" data-toggle="tab">Description</a></li>
      <li role="presentation"><a href="#pictures" aria-controls="pictures" role="tab" data-toggle="tab">Pictures</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="summary">
        <div class="form-group">
          <label class="col-sm-2 col-xs-12 control-label">Summary<font color="#FF0000">*</font></label>
          <div class="col-sm-10 col-xs-12">
            <textarea name="summary" class="form-control" style="min-height:100px;" 
              placeholder="Enter brief details. (Required minimum 100 characters)"
              >@if(old('summary')){!! old('summary') !!}@elseif(isset($property->summary)){!!$property->summary!!}@endif</textarea>
          </div>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="description">
        <div class="form-group">
          <label class="col-sm-2 col-xs-12 control-label">Description<font color="#FF0000">*</font></label>
          <div class="col-sm-10 col-xs-12">
            <textarea name="description" class="form-control mceEditor" id="mceEditor" style="min-height:200px;" 
              placeholder="Enter property detail here. (Required minimum 100 characters)"
              >@if(old('description')){!! old('description') !!}@elseif(isset($property->description)){!!$property->description!!}@endif</textarea>
          </div>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="pictures"> @include('admin.layouts.objects.images') </div>
    </div>
  </div>
</fieldset>
<!--END OF POPUP BUTTONS-->
<fieldset class="col-md-12 table-bordered">
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
      <label class="col-sm-4 col-xs-12 control-label">Cleaning</label>
      <div class="col-sm-8 col-xs-12">
        <div class="input-group"> <span class="input-group-addon">$</span>
          <input name="cleaning_fee_value" type="text" class="form-control" placeholder="###"
            value="@if(old('cleaning_fee_value')){!! old('cleaning_fee_value') !!}@elseif(isset($property->cleaning_fee_value)){!!$property->cleaning_fee_value!!}@endif"
            />
          <span class="input-group-addon">
          <input name="is_cleaning_fee" type="checkbox" value="1"
          @if(old('is_cleaning_fee')){{'checked="checked"'}}
          @elseif(isset($property->is_cleaning_fee) and ($property->is_cleaning_fee=='1')){{'checked="checked"'}}@endif />
          Active </span> 
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Lodger's Tax</label>
      <div class="col-sm-8 col-xs-12">
        <div class="input-group"> <span class="input-group-addon">%</span>
          <input name="lodger_tax_value" type="text" class="form-control" placeholder="##"
            value="@if(old('lodger_tax_value')){!! old('lodger_tax_value') !!}@elseif(isset($property->lodger_tax_value)){!!$property->lodger_tax_value!!}@endif"
            />
          <span class="input-group-addon">
          <input name="is_lodger_tax" type="checkbox" value="1"
          @if(old('is_lodger_tax')){{'checked="checked"'}}
          @elseif(isset($property->is_lodger_tax) and ($property->is_lodger_tax=='1')){{'checked="checked"'}}@endif />
          Active </span> 
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Sales Tax</label>
      <div class="col-sm-8 col-xs-12">
        <div class="input-group"> <span class="input-group-addon" id="sales_tax_value">%</span>
          <input name="sales_tax_value" type="text" class="form-control" placeholder="##" aria-describedby="sales_tax_value" 
            value="@if(old('sales_tax_value')){!! old('sales_tax_value') !!}@elseif(isset($property->sales_tax_value)){!!$property->sales_tax_value!!}@endif"
            />
          <span class="input-group-addon">
          <input name="is_sales_tax" type="checkbox" value="1"
          @if(old('is_sales_tax')){{'checked="checked"'}}
          @elseif(isset($property->is_sales_tax) and ($property->is_sales_tax=='1')){{'checked="checked"'}}@endif />
          Active </span> 
        </div>
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
        >{!!$housekeeper->title!!}</option>
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
        >{!!$vendor->title!!}</option>
        @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 col-xs-12 control-label">Owner of Property</label>
      <div class="col-sm-8 col-xs-12">
        <select name="owner_id" class="form-control">
        <option value="0"
        @if (!isset($property->owner_id)) {{ 'selected="selected"' }} @endif
        > - select - </option>
        @foreach ($owners as $owner)
        <option value="{{ $owner->id }}"
        @if (old('owner_id') == $owner->id) {!!'selected="selected"'!!} 
        @elseif (isset($property->owner_id) and $property->owner_id == $owner->id) {!!'selected="selected"'!!} 
        @endif
        >{!!$owner->title!!}</option>
        @endforeach
        </select>
      </div>
    </div>
  </div>
</fieldset>
<div class="form-group text-center"> @if (isset($edit)) <br>
  <br>
  <br>
  <input name="duplicate" type="checkbox" />
  Generate Duplicate
  @endif 
</div>
