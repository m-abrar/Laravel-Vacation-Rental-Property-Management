<input type="hidden" name="_token" value="{{ csrf_token() }}">
@if(isset($facilitator->id))
<input type="hidden" name="id" value="{{ $facilitator->id }}">
@endif
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Role:</label>
  <div class="col-sm-9 col-xs-12">
    <select name="role" class="form-control" >
    <option value="0"
    @if(old('role') and old('role')=='0'){'selected="selected"'}
    @elseif(isset($facilitator->role) and $facilitator->role == '0'){{'selected="selected"'}}@endif
    >---Select----</option>
    <option value="housekeeper"
    @if(old('role') and old('role')=='housekeeper'){'selected="selected"'}
    @elseif(isset($facilitator->role) and $facilitator->role == 'housekeeper'){{'selected="selected"'}}@endif
    >Housekeeper</option>
    <option value="vendor"
    @if(old('role') and old('role')=='vendor'){'selected="selected"'}
    @elseif(isset($facilitator->role) and $facilitator->role == 'vendor'){{'selected="selected"'}}@endif
    >Maintenance Vendor</option>
    </select>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">First Name<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <input name="firstname" type="text" id="firstname" class="form-control" 
      value="@if(old('firstname')){!! old('firstname') !!}@elseif(isset($facilitator->firstname)){!!$facilitator->firstname!!}@endif"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Last Name<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <input name="lastname" type="text" id="lastname" class="form-control" 
      value="@if(old('lastname')){!! old('lastname') !!}@elseif(isset($facilitator->lastname)){!!$facilitator->lastname!!}@endif"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Address Line 1</label>
  <div class="col-sm-9 col-xs-12">
    <input name="address_line_1" type="text" id="address_line_1" class="form-control" 
      value="@if(old('address_line_1')){!! old('address_line_1') !!}@elseif(isset($facilitator->address_line_1)){!!$facilitator->address_line_1!!}@endif"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Address Line 2</label>
  <div class="col-sm-9 col-xs-12">
    <input name="address_line_2" type="text" id="address_line_2" class="form-control" 
      value="@if(old('address_line_2')){!! old('address_line_2') !!}@elseif(isset($facilitator->address_line_2)){!!$facilitator->address_line_2!!}@endif"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">City</label>
  <div class="col-sm-9 col-xs-12">
    <input name="city" type="text" id="city" class="form-control" 
      value="@if(old('city')){!! old('city') !!}@elseif(isset($facilitator->city)){!!$facilitator->city!!}@endif"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">State</label>
  <div class="col-sm-9 col-xs-12">
    <input name="state" type="text" id="state" class="form-control" 
      value="@if(old('state')){!! old('state') !!}@elseif(isset($facilitator->state)){!!$facilitator->state!!}@endif"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Zip</label>
  <div class="col-sm-9 col-xs-12">
    <input name="zip" type="text" id="zip" class="form-control" 
      value="@if(old('zip')){!! old('zip') !!}@elseif(isset($facilitator->zip)){!!$facilitator->zip!!}@endif"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Phone</label>
  <div class="col-sm-9 col-xs-12">
    <input name="phone" type="text" id="phone" class="form-control" 
      value="@if(old('phone')){!! old('phone') !!}@elseif(isset($facilitator->phone)){!!$facilitator->phone!!}@endif"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Email<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <input type="email" name="email" id="email" class="form-control" 
      value="@if(old('email')){!! old('email') !!}@elseif(isset($facilitator->email)){!!$facilitator->email!!}@endif"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Notes</label>
  <div class="col-sm-9 col-xs-12">
    <textarea name="notes" class="form-control" id="notes">@if(old('notes')){!! old('notes') !!}@elseif(isset($facilitator->notes)){!!$facilitator->notes!!}@endif</textarea>
  </div>
</div>
@if(old('tmp_img_path_main'))
<?php $image_path = Request::old('tmp_img_path_main'); ?>
@elseif(isset($facilitator->image) and is_file($facilitator->image))
<?php $image_path = str_replace('/','|',$facilitator->image); ?>
@else
<?php $image_path = 'NA'; ?>
@endif
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Picture</label>
  <div class="col-sm-9 col-xs-12" id="ajax-picture">
    <script>$(document).ready(function() { window.onload = cropperLoad('main','N','NA',"{{$image_path}}","{{$image_path}}"); });</script>
  </div>
</div>
<script>
  var width = '300';
  var height = '400';
  function cropperLoad(n,deletable,db_id,preview_image,tmp_img_path){
      var preview_image = preview_image.replace(/\//i, '|');
      var tmp_img_path = tmp_img_path.replace(/\//i, '|');
  
    $.ajax({
      url: "{{url('/')}}/load-cropper-object/" + n + '/' + deletable + '/' + db_id + '/' + width + '/' + height + '/' + preview_image + '/' +tmp_img_path,
      success: function(result) {
        $("#ajax-picture").html(result);
      }
    });  
      
  }
  
</script>
<!-- <div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Display Order</label>
  <div class="col-sm-9 col-xs-12">
    <input name="display_order" type="text" class="form-control" 
    value="@if(old('display_order')){!! old('display_order') !!}@elseif(isset($facilitator->display_order)){!!$facilitator->display_order!!}@endif"
    />
  </div>
  </div> -->
<div class="form-group">
  <div class="col-sm-3 col-xs-12"></div>
  <div class="col-sm-9 col-xs-12">
    <label>
    <input name="is_active" type="checkbox" value="1"
    @if(old('is_active')){{'checked="checked"'}}
    @elseif(isset($facilitator->is_active) and ($facilitator->is_active=='1')){{'checked="checked"'}}@endif />
    Active</label>
  </div>
</div>
