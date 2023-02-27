<section id="welcome-index">
   <div class="container page-body">
      <!-- Welcome Contents Section -->
      <article class="col-md-12">
         <div class="col-md-6 col-sm-6">
            <h1 class="page-header">{{$page_home->title}}</h1>
            {!!$page_home->summary!!}   
            <br/>
            <br/>
            <a href="{{url($page_home->category->slug.'/'.$page_home->slug)}}"><span aria-hidden="true">&#8594;</span> {{trans('eminent.read-more')}}</a>
            <br/>
            <br/>
         </div>
         <div class="col-md-6 col-sm-6">
            <style type="text/css">
               .welcome-image-border {
                margin: 5em ;
                border: solid .5em black;
                border-image: linear-gradient(#00afda 17.5%, #ae589e 17.5%, #ae589e 35%, #f24d54 35%, #f24d54 52.5%, #ff914f 52.5%, #ff914f 70%, #ffc064 70%, #ffc064 87.5%, #62c373 87.5%) 5 5;
                padding: 11px;
                /*width: 9em; height: 12em;*/
              }
            </style>
            <div class="welcome-image-border">
            <img class="img-responsive img-preload" data-src="{{asset(@$page_home->images->first()->image_small)}}" data-src-retina="{{asset(@$page_home->images->first()->image)}}" alt="{{@$page_home->title}}" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"> 
         </div>
         </div>
      </article>
      <!-- /.row -->
      <!-- /.row -->
   </div>
</section>