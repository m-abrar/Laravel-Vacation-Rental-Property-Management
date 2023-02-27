<style type="text/css">
.text-muted {
color:#777;
}

#portfolio .portfolio-item {
right:0;
margin:0 0 15px;
}

#portfolio .portfolio-item .portfolio-link {
display:block;
position:relative;
max-width:400px;
margin:0 auto;
}

#portfolio .portfolio-item .portfolio-link .portfolio-hover {
background:rgba(219,36,29,0.8);
position:absolute;
width:100%;
height:100%;
opacity:0;
transition:all ease .5s;
-webkit-transition:all ease .5s;
-moz-transition:all ease .5s;
}

#portfolio .portfolio-item .portfolio-link .portfolio-hover:hover {
opacity:1;
}

#portfolio .portfolio-item .portfolio-link .portfolio-hover .portfolio-hover-content {
position:absolute;
width:100%;
height:20px;
font-size:20px;
text-align:center;
top:50%;
margin-top:-12px;
color:#FFF;
}

#portfolio .portfolio-item .portfolio-link .portfolio-hover .portfolio-hover-content i {
margin-top:-12px;
}

#portfolio .portfolio-item .portfolio-caption {
max-width:400px;
background-color:#FFF;
text-align:center;
margin:0 auto;
padding:25px;
}

#portfolio .portfolio-item .portfolio-caption h4 {
text-transform:none;
margin:0;
}

#portfolio .portfolio-item .portfolio-caption p {
font-family:"Droid Serif", "Helvetica Neue", Helvetica, Arial, sans-serif;
font-style:italic;
font-size:16px;
margin:0;
}

#portfolio * {
z-index:2;
}

.btn-primary {
color:#FFF;
background-color:#fed136;
font-family:Montserrat, "Helvetica Neue", Helvetica, Arial, sans-serif;
text-transform:uppercase;
font-weight:700;
border-color:#fed136;
}

.btn-primary:hover,.btn-primary:focus,.btn-primary:active {
color:#FFF;
background-color:#fec503;
border-color:#f6bf01;
}

.btn-primary:active {
background-image:none;
}

.portfolio-modal .modal-dialog {
height:100%;
width:auto;
margin:0;
}

.portfolio-modal .modal-content {
border-radius:0;
background-clip:border-box;
-webkit-box-shadow:none;
box-shadow:none;
border:none;
min-height:100%;
text-align:center;
padding:100px 0;
}

.portfolio-modal .modal-content h2 {
margin-bottom:15px;
font-size:3em;
}

.portfolio-modal .modal-content img {
margin-bottom:30px;
}

.portfolio-modal .close-modal {
position:absolute;
width:75px;
height:75px;
background-color:transparent;
top:25px;
right:25px;
cursor:pointer;
}

.portfolio-modal .close-modal:hover {
opacity:0.3;
}

.portfolio-modal .close-modal .lr {
height:75px;
width:1px;
margin-left:35px;
background-color:#222;
transform:rotate(45deg);
-ms-transform:rotate(45deg);
-webkit-transform:rotate(45deg);
z-index:1051;
}

.portfolio-modal .close-modal .lr .rl {
height:75px;
width:1px;
background-color:#222;
transform:rotate(90deg);
-ms-transform:rotate(90deg);
-webkit-transform:rotate(90deg);
z-index:1052;
}

.modal-open .modal {
overflow-x:hidden;
overflow-y:auto;
}

.modal-backdrop {
z-index:0;
}

</style>
<!-- Portfolio Grid Section -->
<section id="portfolio" class="bg-light-gray">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 text-center">
            <h2 class="section-heading wow zoomIn animated" data-wow-delay="0.6s">Our Locations</h2>
            <h3 class="section-subheading text-muted wow zoomIn animated" data-wow-delay="0.8s">Lorem ipsum dolor sit amet consectetur.</h3>
         </div>
      </div>
      <div class="row">
         @foreach($ourlocations as $location)
         <div class="col-xs-12 col-sm-6 col-md-4 portfolio-item wow fadeInUp animated" data-wow-delay="0.2s">
            <a href="#location-{{$location->id}}" class="portfolio-link" data-toggle="modal">
               <div class="portfolio-hover">
                  <div class="portfolio-hover-content">
                     <i class="fa fa-plus fa-3x"></i>
                  </div>
               </div>
               @if(isset($location->images->first()->image))
               <img class="img-responsive" src="{{asset($location->images->first()->image)}}" alt="{{$location->title}}">
               @else
               <img class="img-responsive" src="{{asset('pictures/placeholder.png')}}" alt="No Image Available">
               @endif
            </a>
            <div class="portfolio-caption">
               <h4>{!!$location->title!!}</h4>
               <p class="text-muted">{!!$location->summary!!}</p>
            </div>
         </div>
         @endforeach
      </div>
   </div>
   <!-- Portfolio Modals -->
   <!-- Use the modals below to showcase details about your portfolio projects! -->
   @foreach($ourlocations as $location)
   <div class="portfolio-modal modal fade" id="location-{{$location->id}}" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
               <div class="lr">
                  <div class="rl">
                  </div>
               </div>
            </div>
            <div class="container">
               <div class="row">
                  <div class="col-lg-8 col-lg-offset-2">
                     <div class="modal-body">
                        <!-- Project Details Go Here -->
                        @if(isset($location->images->first()->image))
                        <img class="img-responsive" src="{{asset($location->images->first()->image)}}" alt="{{$location->title}}">
                        @else
                        <img class="img-responsive" src="{{asset('pictures/placeholder.png')}}" alt="No Image Available">
                        @endif
                        <h2>{!!$location->title!!}</h2>
                        {!!$location->description!!}
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   @endforeach

</section>


