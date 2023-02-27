@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/owners/create') }}" method="post">
  @include('admin.owners._form')
</form>
@endsection
