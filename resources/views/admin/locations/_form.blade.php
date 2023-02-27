@if(isset($location->id))
<input type="hidden" name="id" value="{{ $location->id }}">
@endif
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
        <label class="col-sm-3 col-xs-12 control-label">Country</label>
        <div class="col-sm-9 col-xs-12">
          <select name="country" class="form-control">
          <option value=""
          @if (!isset($location->parent_id)) {{ 'selected="selected"' }} @endif
          > - select - </option>
          @foreach ($countries as $country)
          <option value="{{ $country->id }}"
          @if (old('country') == $country->id) {{ 'selected="selected"' }}
          @elseif (isset($location->parent_id) and $location->parent_id == $country->id) {{ 'selected="selected"' }}
          @endif
          >{!!$country->title!!}</option>
          @endforeach
          <option value="new"
          @if (old('country') == 'new') {{ 'selected="selected"' }} @endif
          > Add New Country </option>
          </select>
        </div>
      </div>

<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Title/Name<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <input 
      type="text"
      name = "title"
      placeholder="Enter title here"
      value="@if(old('title')){!! old('title') !!}@elseif(isset($location->title)){!!$location->title!!}@endif"
      class="form-control" required="required" 
      />
  </div>
</div>
<div class="form-group">
        <label class="col-sm-3 col-xs-12 control-label">Slug<font color="#FF0000">*</font></label>
        <div class="col-sm-9 col-xs-12">
          <input name="slug" type="text" id="slug" class="form-control" 
            value="@if(old('slug')){!! old('slug') !!}@elseif(isset($location->slug)){!!$location->slug!!}@endif"
            required="required" />
        </div>
      </div>
<div class="form-group">
  <div class="col-sm-3 col-xs-12"></div>
  <div class="col-sm-9 col-xs-12">
    <label>
    <input name="is_active" type="checkbox" value="1"
    @if(old('is_active')){{'checked="checked"'}}
    @elseif(isset($location->is_active) and ($location->is_active=='1')){{'checked="checked"'}}@endif />
    Active</label>
  </div>
</div>
@if(old('tmp_img_path_main'))
<?php $image_path = Request::old('tmp_img_path_main'); ?>
@elseif(isset($location->image) and is_file($location->image))
<?php $image_path = str_replace('/','|',$location->image); ?>
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
  var width = '640';
  var height = '480';
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
