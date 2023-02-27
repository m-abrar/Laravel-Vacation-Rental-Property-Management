@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/pages/create') }}" method="post">
  @include('admin.pages._form')
</form>
@endsection
