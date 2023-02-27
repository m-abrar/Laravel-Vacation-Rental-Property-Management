@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/line-items/update') }}" method="post">
  @include('admin.line-items._form')
</form>
@endsection
