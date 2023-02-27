@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/line-items/create') }}" method="post">
  @include('admin.line-items._form')
  <br/>
  <br/>
  <br/>
  <div class="form-group">
    <div class="col-sm-3 col-xs-12"></div>
    <div class="col-sm-9 col-xs-12">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Add</button>
      <button type="reset" class="btn btn-default"><span class="glyphicon glyphicon-repeat"></span> Reset</button>
    </div>
  </div>
</form>
@endsection