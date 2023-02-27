<style type="text/css">
.text-muted {
color:#777;
}

.service-heading {
text-transform:none;
margin:15px 0;
}

div.service-circle {
max-width:100%;
width:100%;
height:auto;
display:block;
padding-top:100%;
border-radius:50%;
background-position-y:center;
background-position-x:center;
background-repeat:no-repeat;
background-size:cover;
top:0;
left:0;
right:0;
bottom:0;
margin:0 auto;
}
</style>
<!-- Services Section -->
<section id="services">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 text-center">
            <h2 class="section-heading wow zoomIn animated" data-wow-delay="0.6s">Our Services</h2>
            <h3 class="section-subheading text-muted wow zoomIn animated" data-wow-delay="0.8s">Lorem ipsum dolor sit amet consectetur.</h3>
         </div>
      </div>
      <div class="row text-center">
         @foreach($ourservices as $service)
         <div class="col-xs-12 col-sm-6 col-md-4 wow fadeInUp animated" data-wow-delay="0.2s">
            @if(isset($service->images->first()->image_small) AND is_file($service->images->first()->image_small))
            <div class="service-circle" style="background-image:url('{{asset(@$service->images->first()->image_small)}}')"></div>
            @else
            <div class="service-circle" style="background-image:url({{asset('pictures/placeholder.png')}})"></div>
            @endif
            <h4 class="service-heading">{!!$service->title!!}</h4>
            <p class="text-muted">{!!$service->summary!!}</p>
         </div>
         @endforeach
      </div>
   </div>
</section>