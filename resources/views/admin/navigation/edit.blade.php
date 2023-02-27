@extends('admin.layouts.start-navigation')
@section('contents')
<a href="{{url('admin/navigation/'.$navigation->group_name)}}" class="btn btn-success" title="Navigation">
<span class="glyphicon glyphicon-chevron-left"></span>Back to Navigation
</a>
<a href="{{url('admin/navigation/create/'.$navigation->group_name)}}" class="btn btn-info" title="Navigation">
<span class="glyphicon glyphicon-plus"></span>Add New
</a>
<form action="{{ url('/admin/navigation/update') }}" method="post">
  @include('admin.navigation._form')
  <br/>
  <br/>
  <br/>
  <div class="form-group">
    <div class="col-sm-3 col-xs-12"></div>
    <div class="col-sm-9 col-xs-12">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="id" value="{{ $navigation->id }}">
      <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Update</button>
      <button type="reset" class="btn btn-default"><span class="glyphicon glyphicon-repeat"></span> Reset</button>
      <a href="javascript:confirmDelete('{{url('/admin/navigation/delete/'.$navigation->id.'?_token='.csrf_token())}}')" class="btn btn-danger">
      <span class="glyphicon glyphicon-trash"></span> Delete
      </a>
    </div>
  </div>
</form>
@endsection
