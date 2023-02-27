<input type="hidden" name="_token" value="{{ csrf_token() }}">
@if(isset($lineitem->id))
<input type="hidden" name="id" value="{{ $lineitem->id }}">
@endif
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Title/Name<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <input 
      type="text"
      name = "title"
      placeholder="Enter title here"
      value="@if(old('title')){!! old('title') !!}@elseif(isset($lineitem->title)){!!$lineitem->title!!}@endif"
      class="form-control"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Value<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <input 
      type="text"
      name = "value"
      placeholder="Enter value here"
      value="@if(old('value')){!! old('value') !!}@elseif(isset($lineitem->value)){!!$lineitem->value!!}@endif"
      class="form-control"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Value Type:</label>
  <div class="col-sm-9 col-xs-12">
    <select name="value_type" id="value_type" class="form-control" >
    <option value="0"
    @if(old('value_type') and old('value_type')=='0'){'selected="selected"'}
    @elseif(isset($lineitem->value_type) and $lineitem->value_type == '0'){{'selected="selected"'}}@endif
    >---Select----</option>
    <option value="fixed"
    @if(old('value_type') and old('value_type')=='fixed'){'selected="selected"'}
    @elseif(isset($lineitem->value_type) and $lineitem->value_type == 'fixed'){{'selected="selected"'}}@endif
    >$ (Fixed)</option>
    <option value="percentage"
    @if(old('value_type') and old('value_type')=='percentage'){'selected="selected"'}
    @elseif(isset($lineitem->value_type) and $lineitem->value_type == 'percentage'){{'selected="selected"'}}@endif
    >% (Percentage)</option>
    </select>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Apply On:</label>
  <div class="col-sm-9 col-xs-12">
    <select name="apply_on" id="apply_on" class="form-control" >
    <option value="0"
    @if(old('apply_on') and old('apply_on')=='fixed'){'selected="selected"'}
    @elseif(isset($lineitem->apply_on) and $lineitem->apply_on == 'fixed'){{'selected="selected"'}}@endif
    >---Select----</option>
    <option value="base"
    @if(old('apply_on') and old('apply_on')=='base'){'selected="selected"'}
    @elseif(isset($lineitem->apply_on) and $lineitem->apply_on == 'base'){{'selected="selected"'}}@endif
    >Lodging Amount Only</option>
    <option value="sum"
    @if(old('apply_on') and old('apply_on')=='sum'){'selected="selected"'}
    @elseif(isset($lineitem->apply_on) and $lineitem->apply_on == 'sum'){{'selected="selected"'}}@endif
    >All Add Ons (displayed above this one) + Lodging Amount</option>
    </select>
  </div>
</div>
<div class="form-group">
  <div class="col-sm-3 col-xs-12"></div>
  <div class="col-sm-9 col-xs-12">
    <label>
    <input name="is_required" type="checkbox" value="1"
    @if(old('is_required')){{'checked="checked"'}}
    @elseif(isset($lineitem->is_required) and ($lineitem->is_required=='1')){{'checked="checked"'}}@endif />
    Required</label>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Description</label>
  <div class="col-sm-9 col-xs-12">
    <textarea name="description" class="form-control">@if(old('description')){!! old('description') !!}@elseif(isset($lineitem->description)){!!$lineitem->description!!}@endif</textarea>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Position/Display Order</label>
  <div class="col-sm-9 col-xs-12">
    <input name="display_order" type="text" class="form-control" 
      value="@if(old('display_order')){!! old('display_order') !!}@elseif(isset($lineitem->display_order)){!!$lineitem->display_order!!}@endif"
      />
  </div>
</div>
<div class="form-group">
  <div class="col-sm-3 col-xs-12"></div>
  <div class="col-sm-9 col-xs-12">
    <label>
    <input name="is_active" type="checkbox" value="1"
    @if(old('is_active')){{'checked="checked"'}}
    @elseif(isset($lineitem->is_active) and ($lineitem->is_active=='1')){{'checked="checked"'}}@endif />
    Active</label>
  </div>
</div>
