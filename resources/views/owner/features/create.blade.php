@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/features/create') }}" method="post">
  @include('admin.features._form')
</form>
@endsection
