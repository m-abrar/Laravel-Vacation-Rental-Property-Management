@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/property-classes/create') }}" method="post">
  @include('admin.property-classes._form')
</form>
@endsection
