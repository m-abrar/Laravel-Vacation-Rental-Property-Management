<input type="hidden" name="_token" value="{{ csrf_token() }}">
@if(isset($page->id))
<input type="hidden" name="id" value="{{ $page->id }}">
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
            value="@if(old('title')){!! old('title') !!}@elseif(isset($page->title)){!!$page->title!!}@endif"
            class="form-control"
            />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Slug</label>
        <div class="col-sm-8 col-xs-12">
          <input name="slug" type="text" id="slug" class="form-control" 
            value="@if(old('slug')){!! old('slug') !!}@elseif(isset($page->slug)){!!$page->slug!!}@endif"
            />
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Category</label>
        <div class="col-sm-8 col-xs-12">
          <select name="category_id" class="form-control">
          <option value="0"
          @if (!isset($page->category_id)) {{ 'selected="selected"' }} @endif
          > - select - </option>
          @foreach ($categories as $category)
          <option value="{{ $category->id }}"
          @if (old('category_id') == $category->id) {!!'selected="selected"'!!} 
          @elseif (isset($page->category_id) and $page->category_id == $category->id) {!!'selected="selected"'!!} 
          @endif
          >{!!$category->title!!}</option>
          @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 col-xs-12 control-label">Display Order</label>
        <div class="col-sm-8 col-xs-12">
          <input name="display_order" type="text" class="form-control" 
            value="@if(old('display_order')){!! old('display_order') !!}@elseif(isset($page->display_order)){!!$page->display_order!!}@endif"
            />
        </div>
      </div>
    </div>
    <br/><br/>
  </fieldset>
</div>
<div class="col-md-12">
  <fieldset class="checkbox">
    <legend>Indexing Control</legend>
    <div class="col-md-3 col-xs-4">
      <label>
      <input name="is_active" type="checkbox" value="1"
      @if(old('is_active')){{'checked="checked"'}}
      @elseif(isset($page->is_active) and ($page->is_active=='1')){{'checked="checked"'}}@endif />
      Active</label>
    </div>
    <div class="col-md-3 col-xs-4">
      <label>
      <input name="is_featured" type="checkbox" value="1"
      @if(old('is_featured')){{'checked="checked"'}}
      @elseif(isset($page->is_featured) and ($page->is_featured=='1')){{'checked="checked"'}}@endif />
      Featured</label>
    </div>
    <div class="col-md-3 col-xs-4">
      <label>
      <input name="is_new" type="checkbox" value="1"
      @if(old('is_new')){{'checked="checked"'}}
      @elseif(isset($page->is_new) and ($page->is_new=='1')){{'checked="checked"'}}@endif />
      New</label>
    </div>
    <div class="col-md-3 col-xs-4">
      <label>
      <input name="is_home" type="checkbox" value="1"
      @if(old('is_home')){{'checked="checked"'}}
      @elseif(isset($page->is_home) and ($page->is_home=='1')){{'checked="checked"'}}@endif />
      Home page</label>
    </div>
    <br/><br/>
  </fieldset>
</div>
<!---POPUP BUTTONS-->
<div class="col-md-12">
  <fieldset>
    <legend>Page Data</legend>
    <div class="col-md-12" role="tabpanel">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">Summary</a></li>
        <li role="presentation"><a href="#contents" aria-controls="contents" role="tab" data-toggle="tab">Contents</a></li>
        <li role="presentation"><a href="#pictures" aria-controls="pictures" role="tab" data-toggle="tab">Pictures</a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="summary">
          <div class="form-group">
            <label class="col-sm-2 col-xs-12 control-label">Summary<font color="#FF0000">*</font></label>
            <div class="col-sm-10 col-xs-12">
              <textarea name="summary" class="form-control mceEditor" style="min-height:100px;" 
                placeholder="Enter brief details. (Required minimum 100 characters)"
                >@if(old('summary')){!! old('summary') !!}@elseif(isset($page->summary)){!!$page->summary!!}@endif</textarea>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="contents">
          <div class="form-group">
            <label class="col-sm-2 col-xs-12 control-label">Contents<font color="#FF0000">*</font></label>
            <div class="col-sm-10 col-xs-12">
              <textarea name="contents" class="form-control mceEditor" style="min-height:200px;" 
                placeholder="Enter pages detail here. (Required minimum 100 characters)"
                >@if(old('contents')){!! old('contents') !!}@elseif(isset($page->contents)){!!$page->contents!!}@endif</textarea>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="pictures"> @include('admin.layouts.objects.images') </div>
      </div>
    </div>
  </fieldset>
  <br/><br/>
</div>
