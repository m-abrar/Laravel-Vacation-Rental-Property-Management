@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/locations/create') }}" method="post">
  @include('admin.locations._form')
</form>
@endsection