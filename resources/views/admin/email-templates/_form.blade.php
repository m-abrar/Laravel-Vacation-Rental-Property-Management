<input type="hidden" name="_token" value="{{ csrf_token() }}">
@if(isset($emailtemplate->id))
<input type="hidden" name="id" value="{{ $emailtemplate->id }}">
@endif
<input type="hidden" name="id" value="{{ $emailtemplate->id }}">
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Subject<font color="#FF0000">*</font></label>
  <div class="col-sm-9 col-xs-12">
    <input 
      type="text"
      name = "email_subject"
      placeholder="Enter email subject here"
      value="@if(old('email_subject')){!! old('email_subject') !!}@elseif(isset($emailtemplate->email_subject)){!!$emailtemplate->email_subject!!}@endif"
      class="form-control"
      />
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Email Body</label>
  <div class="col-sm-9 col-xs-12">
    <textarea name="email_body" class="form-control mceEditor height-225">@if(old('email_body')){!! old('email_body') !!}@elseif(isset($emailtemplate->email_body)){!!$emailtemplate->email_body!!}@endif</textarea>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 col-xs-12 control-label">Variables</label>
  <div class="col-sm-9 col-xs-12">
    {!!$emailtemplate->variable_hints!!}
  </div>
</div>
