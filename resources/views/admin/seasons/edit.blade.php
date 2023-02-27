@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/seasons/update') }}" method="post">
  @include('admin.seasons._form')
</form>
@endsection
