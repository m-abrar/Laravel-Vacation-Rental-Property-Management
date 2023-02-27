<!-- Clients Aside -->
<aside class="clients">
   <div class="container">
      <div class="row">
         <div id="demo">
            <div id="owl-demo" class="owl-carousel">
               @foreach($ourpartners as $partner)
               <div class="item" style="max-width: 200px">
                  @if(isset($partner->images->first()->image))
                  <img class="img-responsive img-centered" src="{{asset($partner->images->first()->image)}}" alt="{{$partner->title}}">
                  @else
                  <img class="img-responsive img-centered" src="{{asset('pictures/placeholder.png')}}" alt="No Image Available">
                  @endif
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</aside>