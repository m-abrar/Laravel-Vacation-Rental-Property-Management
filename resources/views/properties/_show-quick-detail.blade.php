<!-- Brief data of property detail. -->
<div class="row">
   <div class="col-md-3 info-cell"> {{trans('eminent.property.bedrooms')}}
      <span class="pull-right">
      {{$property->bedrooms}}
      </span>
   </div>
   <div class="col-md-3 info-cell"> {{trans('eminent.property.bathrooms')}}
      <span class="pull-right">
      {{$property->bathrooms}}
      </span>
   </div>
   <div class="col-md-3 info-cell"> {{trans('eminent.property.sleeps')}}
      <span class="pull-right">
      {{$property->sleeps}}
      </span>
   </div>
   <div class="col-md-3 info-cell"> {{trans('eminent.property.garages')}}
      <span class="pull-right">
      {{$property->garages}}
      </span>
   </div>
   <br/>
   <br/>
</div>
<div class="row">
   <div class="text-center">
      @foreach($property->classez as $class)
      <div class="col-md-3">
         <i class="glyphicon glyphicon-ok"></i>
         {{$class->theclass->title}}
      </div>
      @endforeach
   </div>
</div>