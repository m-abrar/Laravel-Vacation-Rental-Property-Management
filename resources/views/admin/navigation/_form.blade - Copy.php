<script type="text/javascript" src="{{asset('admin/_noblesoft/autocomplete/dist/jquery.autocomplete.js')}}"></script>
<link href="{{asset('admin/_noblesoft/autocomplete/css/styles.css')}}" rel="stylesheet" />
<script type="text/javascript">
  $('.autocomplete').autocomplete({
      lookup: function (query, done) {
          // Do ajax call or lookup locally, when done,
          // call the callback and pass your results:
          var result = {
              suggestions: [
                  { "value": "United Arab Emirates", "data": "AE" },
                  { "value": "United Kingdom",       "data": "UK" },
                  { "value": "United States",        "data": "US" }
              ]
          };
  
          done(result);
      },
      onSelect: function (suggestion) {
          alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
      }
  });
</script>
<div class="form-group">
  <label class="col-md-3 control-label">Title<font color="#FF0000">*</font></label>
  <div class="col-md-9">
    <input 
      type="text"
      name = "title"
      placeholder="Enter title here"
      value="@if(old('title')){!! old('title') !!}@elseif(isset($navigation->title)){!!$navigation->title!!}@endif"
      class="form-control"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Link</label>
  <div class="col-md-3">
    {{url('/')}}/
  </div>
  <div class="col-md-2">
    <select name="page_type_id" class="form-control" >
      <option value="0"> - Page Type - </option>
      <option value="0" @if(isset($navigation->page_type_id) and $navigation->page_type_id=='0'){echo 'selected="selected"'@endif >N/A</option>
      @foreach ($pagetypes as $pagetype)
      <option value="{{$pagetype->id}}" @if(@$navigation->page_type_id==$pagetype->id){!!'selected="selected"'!!}@endif >
      {{$pagetype->title}}
      </option>
      @endforeach
      <option value="0"> - Other - </option>
      <option value="type">Property Type</option>
      <option value="listing">Property</option>
    </select>
  </div>
  <div class="col-md-1">
    /
  </div>
  <div class="col-md-3">
    <input 
      type="text"
      name = "link_value"
      placeholder="Enter slug value here"
      value="@if(old('link_value')){!! old('link_value') !!}@elseif(isset($navigation->value)){!!$navigation->value!!}@endif"
      class="form-control"
      />
  </div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Preview</label>
<div class="col-md-9">
  {{url('/')}}/{{$pagetype->slug}}
</div>
<div class="form-group">
  <div class="col-sm-3 col-xs-12"></div>
  <div class="col-sm-9 col-xs-12">
    <label>
    <input name="is_active" type="checkbox" value="1"
    @if(old('is_active')){{'checked="checked"'}}
    @elseif(isset($navigation->is_active) and ($navigation->is_active=='1')){{'checked="checked"'}}@endif />
    Active</label>
  </div>
</div>
