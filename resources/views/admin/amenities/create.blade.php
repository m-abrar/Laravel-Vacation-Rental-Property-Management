@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/amenities/create') }}" method="post">
  @include('admin.amenities._form')
</form>
@endsection
