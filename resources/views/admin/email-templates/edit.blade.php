@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/email-templates/update') }}" method="post">
  @include('admin.email-templates._form')
</form>
@endsection
