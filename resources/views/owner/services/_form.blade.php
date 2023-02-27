<input type="hidden" name="_token" value="{{ csrf_token() }}">
@if(isset($service->id))
<input type="hidden" name="id" value="{{ $service->id }}">
@endif
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Title/Name<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <input 
      type="text"
      name = "title"
      placeholder="Enter title here"
      value="@if(old('title')){!! old('title') !!}@elseif(isset($service->title)){!!$service->title!!}@endif"
      class="form-control"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Price<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <input 
      type="text"
      name = "price"
      placeholder="Enter price here"
      value="@if(old('price')){!! old('price') !!}@elseif(isset($service->price)){!!$service->price!!}@endif"
      class="form-control"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Summary</label>
  <div class="col-sm-9 col-xs-12">
    <textarea name="summary" class="form-control">@if(old('summary')){!! old('summary') !!}@elseif(isset($service->summary)){!!$service->summary!!}@endif</textarea>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Description</label>
  <div class="col-sm-9 col-xs-12">
    <textarea name="description" class="form-control">@if(old('description')){!! old('description') !!}@elseif(isset($service->description)){!!$service->description!!}@endif</textarea>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Display Order</label>
  <div class="col-sm-9 col-xs-12">
    <input name="display_order" type="text" class="form-control" 
      value="@if(old('display_order')){!! old('display_order') !!}@elseif(isset($service->display_order)){!!$service->display_order!!}@endif"
      />
  </div>
</div>
<div class="form-group">
  <div class="col-sm-3 col-xs-12"></div>
  <div class="col-sm-9 col-xs-12">
    <label>
    <input name="is_active" type="checkbox" value="1"
    @if(old('is_active')){{'checked="checked"'}}
    @elseif(isset($service->is_active) and ($service->is_active=='1')){{'checked="checked"'}}@endif />
    Active</label>
  </div>
</div>



@if(old('tmp_img_path_main'))
<?php $image_path = Request::old('tmp_img_path_main'); ?>
@elseif(isset($service->image) and is_file($service->image))
<?php $image_path = str_replace('/','|',$service->image); ?>
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
