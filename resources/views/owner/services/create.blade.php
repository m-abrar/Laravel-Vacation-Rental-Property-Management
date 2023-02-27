@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/services/create') }}" method="post">
  @include('admin.services._form')
</form>
@endsection
