@extends('admin.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/admin/reservations/update') }}" method="post">
  @include('admin.reservations._form')
</form>
@endsection
