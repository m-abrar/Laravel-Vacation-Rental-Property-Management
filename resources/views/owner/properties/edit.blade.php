@extends('owner.layouts.default.start-minified')
@section('contents')
<form action="{{ url('/owner/properties/update') }}" method="post">
  @include('owner.properties._form')
</form>
@endsection
