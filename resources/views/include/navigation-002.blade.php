<!-- Menu coming from database -->
<div class="container-fluid">
 <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="z-index: 1000;">
 	<div>
 	<a class="text-center" href="{{url('/')}}"><img src="{{asset('img/'.$settings->logo_light)}}" alt="{{$settings->site_title}}" class="img-responsive"  style="height:70px; margin:10px 0 0 20px"/></a>
 	</div>
 </div>s
 <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="z-index: 1000;">
 <!-- Menu coming from database -->
	<nav id='main-menu' class="navbar text-uppercase main-menu-transparent pull-right" role="navigation">
	  {!! html_entity_decode(html_entity_decode($menu_top)) !!}
	</nav>
</div>
</div>