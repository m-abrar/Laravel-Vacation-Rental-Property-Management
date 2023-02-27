<!-- Show the main description of property from database -->
<div class="row">
   <h3>{{trans('eminent.headings.description')}}</h3>
   <div class="col-md-12">
      {!!$property->description!!}
   </div>
</div>
<!-- Show amenities assigned to this property -->
<div class="row">
   <h3>{{trans('eminent.headings.amenities')}}</h3>
   <ul class="amenities">
      @foreach ($amenities as $amenity)
      @if($amenity->added->first()->value=='Yes')
      <li class="col-md-4">
         {{$amenity->title}}
      </li>
      @endif
      @endforeach
   </ul>
</div>
<!-- Show features assigned to this property -->
<div class="row">
   <h3>{{trans('eminent.headings.features')}}</h3>
   <ul class="features">
      @foreach ($features as $feature)
      @if($feature->added->first()->value!='' and $feature->added->first()->value!='0')
      <li class="col-md-4">
         {{$feature->title}}
         <span class="pull-right">
         <strong>
         {{$feature->added->first()->value}}
         </strong>
         <span>
      </li>
      @endif
      @endforeach
   </ul>
   <hr />
</div>