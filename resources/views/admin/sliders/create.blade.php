@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/sliders/create') }}" method="post">
  @include('admin.sliders._form')
</form>
@endsection
