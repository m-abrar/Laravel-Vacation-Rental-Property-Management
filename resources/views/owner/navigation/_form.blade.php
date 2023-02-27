<script type="text/javascript" src="{{asset('admin/_noblesoft/autocomplete/dist/jquery.autocomplete.js')}}"></script>
<link href="{{asset('admin/_noblesoft/autocomplete/css/styles.css')}}" rel="stylesheet" />
<div class="form-group">
  <label class="col-md-3 control-label">Navigation Title <font color="#FF0000">*</font></label>
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
  <label class="col-md-3 control-label">Content</label>
  <div class="col-md-9">
    <div class="input-group"> 
      <span class="input-group-addon">{{url('/')}}/</span>
      <input name="relevant_content" type="text" class="form-control autocomplete" placeholder="Relevant Content Heading..."
        value="@if(old('relevant_content')){!! old('relevant_content') !!}@elseif(isset($navigation->relevant_content)){!!$navigation->relevant_content!!}@endif" 
        />
    </div>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">URL with Slug(s)</label>
  <div class="col-md-9">
    <div class="input-group"> 
      <span class="input-group-addon">{{url('/')}}/</span>
      <input name="value" id="url-value" type="text" class="form-control" placeholder="URL value in slug(s)..."
        value="@if(old('value')){!! old('value') !!}@elseif(isset($navigation->value)){!!$navigation->value!!}@endif" 
        />
    </div>
  </div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Preview</label>
<div class="col-md-9 autocomplete-preview">
  @if(old('value'))
  <a href="{{url(old('value'))}}" target="_blank">{{url(old('value'))}}</a>
  @elseif(isset($navigation->value))
  <a href="{{url($navigation->value)}}" target="_blank">{{url($navigation->value)}}</a>
  @else
  Please fill out the above field to see preview link.
  @endif
</div>
<div class="form-group">
  <div class="col-sm-3 col-xs-12"></div>
  <div class="col-sm-9 col-xs-12">
    <label>
    <input name="is_active" type="checkbox" value="1"
    @if(old('is_active')){{'checked="checked"'}}
    @elseif(isset($navigation->is_active) and ($navigation->is_active=='1')){{'checked="checked"'}}@endif />
    Active
    </label>
  </div>
</div>
<script type="text/javascript">
  $('.autocomplete').autocomplete({
      lookup: function (query, done) {
          // Do ajax call or lookup locally, when done,
          // call the callback and pass your results:
          var result = {
              suggestions: [
                  @foreach($autocomplete as $item)
                  { "value": "{{$item->title}}", "data": "{{$item->value}}" },
                  @endforeach
              ]
          };
  
          done(result);
      },
      onSelect: function (suggestion) {
          var script_url = "{{url('/')}}/";
          $('#url-value').val(suggestion.data);
          $('.autocomplete-preview').html('<a href="' + script_url + suggestion.data + '" target="_blank">' + script_url+suggestion.data+'</a>');
  
          //alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
  
      }
  });
</script>
