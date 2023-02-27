<section class="featured-items-section">
   <div class="container">
      <div class="col-sm-12">
         <div class=" caption-slide-up">
            @foreach($properties as $property)
            <div class="col-lg-4 col-sm-6 col-md-6 featured-item">
               <div class="labels">
                  @if($property->is_new==1)
                  <div class="label-new"></div>
                  @endif
                  @if($property->is_vacation==1)
                  <div class="label-rent"></div>
                  @endif
                  @if($property->is_sale==1)
                  <div class="label-sale"></div>
                  @endif
               </div>
               <div class="category">
                  {!!$property->category->title!!}
               </div>
               <ul class="list-inline featured-item-header text-center">
                  <li><strong>
                     {{$property->bedrooms}} - </strong><small>{{trans('eminent.property.bedrooms')}}</small>
                  </li>
                  <li><strong>
                     {{$property->bathrooms}} - </strong><small>{{trans('eminent.property.bathrooms')}}</small>
                  </li>
                  <li><strong>
                     {{$property->sleeps}} - </strong><small>{{trans('eminent.property.sleeps')}}</small>
                  </li>
               </ul>
               <figure>
                  @if(isset($property->images->first()->image_small))
                  <img class="img-responsive img-preload" data-src="{{asset($property->images->first()->image_small)}}" data-src-retina="{{asset($property->images->first()->image)}}" alt="{{@$property->title}}" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"> 
                  @else
                  <img class="img-responsive" src="{{asset('pictures/placeholder.png')}}" alt="No Image Available">
                  @endif
                  <figcaption>
                     <h3>
                        {{$property->title}}
                     </h3>
                     <p>
                        {{$property->city}}<br>
                        {{@$property->location->title}},
                        {{$property->zip}}
                     </p>
                     <a href="{{url('show/'.$property->slug)}}" class="button high_device_link"><span>&#10004;</span>{{trans('eminent.view-detail')}}</a> 
                     <a href="{{url('show/'.$property->slug)}}" class="small_device_link" >{{trans('eminent.view-detail')}}</a> 
                  </figcaption>
               </figure>
            </div>
            @endforeach
         </div>
      </div>
   </div>
</section>