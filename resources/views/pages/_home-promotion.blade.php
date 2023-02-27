<style type="text/css">
	#promotion-banner {
    position: relative;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    background-size: cover;
    -o-background-size: cover;
    background-position: center;
    background-image: url('{{asset(@$page_home->images->first()->image)}}');
    padding: 150px 0;
    box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.6);
}
</style>
<!--promotion-banner--> 
<section id="promotion-banner">
   <div class="container text-center">
      <h2 class="Banner-heading wow fadeInUp animated" data-wow-delay="0.5s">Great Stay <span class="theme-red">Affordable Price!</span></h2>{{asset(@$page_home->images->first()->image)}}
   </div>
</section>