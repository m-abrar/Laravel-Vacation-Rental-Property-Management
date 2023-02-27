@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/property-types/update') }}" method="post">
  @include('admin.property-types._form')
</form>
@endsection
