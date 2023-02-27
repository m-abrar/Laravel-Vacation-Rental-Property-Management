<div id="top" class="colors-top-bar">
      <div class="container">
        <div class="pull-right">
          <ul class="socialmarks socialmarks2 ">
            @if(!filter_var($settings->facebook, FILTER_VALIDATE_URL) === false)
            <li><a href="{{$settings->facebook}}" target="_blank" class="facebook"></a></li>
            @endif
            @if(!filter_var($settings->twitter, FILTER_VALIDATE_URL) === false)
            <li><a href="{{$settings->twitter}}" target="_blank" class="twitter"></a></li>
            @endif
            @if(!filter_var($settings->linkedin, FILTER_VALIDATE_URL) === false)
            <li><a href="{{$settings->linkedin}}" target="_blank" class="linkedin"></a></li>
            @endif
            @if(!filter_var($settings->googleplus, FILTER_VALIDATE_URL) === false)
            <li><a href="{{$settings->googleplus}}" target="_blank" class="googleplus"></a></li>
            @endif
          </ul>
        </div>
        
        <div class="pull-left">
          @if(Auth::check())
          <a href="{{url('admin/dashboard')}}" class="btn btn-oval">Manage Propeperties </a>
          @else
          <a href="{{url('admin/dashboard')}}" class="btn btn-oval">Login</a> 
          @endif
          <!-- Popup: Reserve Online -->
          @include('include.reserve-online')
        </div>
        <div class="pull-left" style="color:#fff; margin: 10px 5px 0 5px ;">
          {!!$settings->site_header_top!!}
        </div>
      </div>
    </div>