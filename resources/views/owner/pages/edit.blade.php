@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/pages/update') }}" method="post">
  @include('admin.pages._form')
</form>
@endsection
