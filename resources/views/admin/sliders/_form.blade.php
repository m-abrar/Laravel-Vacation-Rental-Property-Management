@if(isset($slider->id))
<input type="hidden" name="id" value="{{ $slider->id }}">
@endif
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Title/Name<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <input 
      type="text"
      name = "title"
      placeholder="Enter title here"
      value="@if(old('title')){!! old('title') !!}@elseif(isset($slider->title)){!!$slider->title!!}@endif"
      class="form-control"
      />
  </div>
</div>
<div class="form-group">
  <div class="col-sm-3 col-xs-12"></div>
  <div class="col-sm-9 col-xs-12">
    <label>
    <input name="is_active" type="checkbox" value="1"
    @if(old('is_active')){{'checked="checked"'}}
    @elseif(isset($slider->is_active) and ($slider->is_active=='1')){{'checked="checked"'}}@endif />
    Active</label>
  </div>
</div>
@if(old('tmp_img_path_main'))
<?php $image_path = Request::old('tmp_img_path_main'); ?>
@elseif(isset($slider->image) and is_file($slider->image))
<?php $image_path = str_replace('/','|',$slider->image); ?>
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
  var width = '1200';
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
