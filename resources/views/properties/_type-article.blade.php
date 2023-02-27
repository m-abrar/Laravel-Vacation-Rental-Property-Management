<!-- Search Result Items: Included as partial file on search page. -->
<?php
   $filter_keys = '"all", ';
   foreach( $property->classez as $class ) { $filter_keys .= '"'.@$class->theclass->slug . '", '; }
   ?>
<div class="col-md-12 item row-equal-height" data-groups='[<?php echo rtrim($filter_keys,', '); ?>]'>
   <div class="col-sm-12 col-md-4" >
      <a href="{{url('show/'.$property->slug)}}">
         <!-- Future: where is_main==1 -->
         <img class="img-responsive img-hover" 
            src="{{asset(@$property->images->first()->image_small)}}" alt="{{@$property->title}}"> 
      </a>
   </div>
   <div class="col-sm-12 col-md-5 property-type-article-description" >
      <h3>
         {{$property->title}} 
      </h3>
      <p><i class="fa fa-map-marker"></i> {{$property->city}}, {{$property->zip}}, {{@$property->location->title}}</p>
      <p>
         {!!$property->summary!!}
      </p>
      <p>
         @foreach($property->amenities as $amenity)
         @if($amenity->value=='Yes')
      <div class="col-md-6"><i class="fa fa-check"></i>&nbsp;{{@$amenity->amenity->title}}&nbsp;&nbsp;</div>
      @endif
      @endforeach
      </p>
   </div>
   <div class="col-sm-12 col-md-3 text-center property-type-article-price info-cell">
      <br/> 
      <p>
         {{trans('eminent.property.capacity')}} <span>{{$property->sleeps}}</span>
      </p>
      <p>
         {{trans('eminent.property.bedrooms')}} <span>{{$property->bedrooms}}</span>
      </p>
      <p>
         {{trans('eminent.property.bathrooms')}} <span>{{$property->bathrooms}}</span>
      </p>
      @if($property->is_vacation=='1')
      <h4>
         @if($property->is_price_daily==1 and $property->is_vacation==1)
         ${{number_format($property->price_daily,2)}}/night
         @elseif($property->is_price_monthly==1)
         ${{number_format($property->price_monthly,2)}}/month
         @endif
      </h4>
      <a class="btn" href="{{url('reserve/'.$property->slug)}}">
      <i class="fa fa-plane"></i> {{trans('eminent.reserve')}} 
      </a>
      <br/>
      @endif
      @if($property->is_sale=='1')
      <h4>${{$property->sale_price}}</h4>
      <a class="btn" href="{{url('sale/'.$property->slug)}}">
      <i class="fa fa-shopping-cart"></i> {{trans('eminent.buy')}}  
      </a><br/><br/>
      @endif
   </div>
</div>