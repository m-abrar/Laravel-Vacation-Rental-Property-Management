@if ($errors->any())
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-ban"></i> Error!</h4>
  @foreach ( $errors->all() as $error )
  {!! $error !!}<br/>
  @endforeach
</div>
@endif
@if (Session::has('message'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4>  <i class="icon fa fa-check"></i> Congratulations!</h4>
  {!! Session::get('message') !!}
</div>
@endif
@if (isset($message))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4>  <i class="icon fa fa-check"></i> Congratulations!</h4>
  {!! $message !!}
</div>
@endif
