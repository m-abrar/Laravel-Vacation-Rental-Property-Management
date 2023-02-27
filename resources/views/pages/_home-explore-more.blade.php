<section class="intro_paddding">
   <div class="container">
      <div class="col-lg-12">
         <h2 class="page-header"> {{trans('eminent.explore-more')}} </h2>
      </div>
      @foreach($pages_featured as $page)
      <!-- Featured Contents -->
      @if(isset($page->images->first()->image) and is_file($page->images->first()->image))
      <div class="col-md-4">
         <div class="content">
            <div class="grid">
               <figure class="effect-sarah">
                  <img class="img-responsive img-preload" data-src="{{asset($page->images->first()->image_small)}}" data-src-retina="{{asset($page->images->first()->image)}}" alt="{{@$page->title}}" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">
                  <figcaption>
                     <h2>{{$page->title}}</h2>
                     <p><?= $page->summary ?></p>
                     <a href="{{url($page->category->slug.'/'.$page->slug)}}">{{trans('eminent.view-more')}}</a>
                  </figcaption>
               </figure>
            </div>
         </div>
      </div>
      @endif
      <!-- /.Featured Contents -->
      @endforeach
   </div>
</section>