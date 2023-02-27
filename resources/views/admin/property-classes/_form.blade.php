@if(isset($propertyclass->id))
<input type="hidden" name="id" value="{{ $propertyclass->id }}">
@endif
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Title/Name<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <input 
      type="text"
      name = "title"
      placeholder="Enter title here"
      value="@if(old('title')){!! old('title') !!}@elseif(isset($propertyclass->title)){!!$propertyclass->title!!}@endif"
      class="form-control"
      />
  </div>
</div>