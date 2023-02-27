

@if ($errors->any())
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-ban"></i> {{trans('eminent.alert.error')}}</h4>
  @foreach ( $errors->all() as $error )
  {!! $error !!}<br/>
  @endforeach
</div>
@endif
@if (Session::has('message'))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4>  <i class="icon fa fa-check"></i> {{trans('eminent.alert.congratulations')}}</h4>
  {!! Session::get('message') !!}
</div>
@endif
@if (isset($message))
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4>  <i class="icon fa fa-check"></i> {{trans('eminent.alert.congratulations')}}</h4>
  {!! $message !!}
</div>
@endif
@if (isset($warning) AND !empty($warning))
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>{{trans('eminent.alert.warning')}}</strong>
  {!! $warning !!}
</div>
@endif
@if (isset($information) AND !empty($information))
<div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>{{trans('eminent.alert.information')}}</strong>
  {!! $information !!}
</div>
@endif