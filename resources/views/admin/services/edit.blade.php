@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/services/update') }}" method="post">
  @include('admin.services._form')
</form>
@endsection
