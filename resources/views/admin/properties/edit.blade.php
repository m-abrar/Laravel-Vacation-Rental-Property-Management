@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/properties/update') }}" method="post">
  @include('admin.properties._form')
</form>
@endsection
