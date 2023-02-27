@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/facilitators/update') }}" method="post">
  @include('admin.facilitators._form')
</form>
@endsection
