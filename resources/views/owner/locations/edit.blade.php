@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/locations/update') }}" method="post">
  @include('admin.locations._form')
</form>
@endsection
