@extends('admin.layouts.default.start')
@section('contents')
<div class="box">
  <div class="box-body">
    <form action="{{ url('/admin/users/update') }}" method="post">
      @include('admin.users._form')
      <br/>
      <br/>
      <br/>
      <div class="form-group">
        <div class="col-sm-3 col-xs-12"></div>
        <div class="col-sm-9 col-xs-12">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="id" value="{{ $user->id }}">
          <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Update</button>
          <button type="reset" class="btn btn-default"><span class="glyphicon glyphicon-repeat"></span> Reset</button>
        </div>
      </div>
    </form>
  </div>
  <!-- /.box-body -->
</div>
@endsection
