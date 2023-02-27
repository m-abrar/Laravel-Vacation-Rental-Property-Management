<!-- Site Header: Social Media links and Reserve Online -->
<section id="theme_options_header">
    @include('include.header-top-001')
    <!-- Site Header: Logo and heading text -->
    <div class="header-bg">
      <div class="container header-bg">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-6 logo">
            <h1>
              <a href="{{url('/')}}"><img src="{{asset('img/'.$settings->logo_dark)}}" alt="{{$settings->site_title}}" class="img-responsive" /></a>
            </h1>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-6 header_heading">
            <div class="advertisement">
            {!!$settings->site_header!!}      
          </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End of site header -->
    
    <!-- Body: Page Contents -->
    
<!-- Navigation: Top-bar -->
    <div>
    @include('layouts.default._navigation')
    </div>
</section>