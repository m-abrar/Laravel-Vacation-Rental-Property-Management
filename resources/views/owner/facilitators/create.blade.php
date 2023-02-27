@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/facilitators/create') }}" method="post">
  @include('admin.facilitators._form')
</form>
@endsection
