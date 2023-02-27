<footer>
      <div class="contentfooter">
      <div class="footer-grids">
        <div class="footer one">
          <h3>More About Company</h3>
          <p> Lorem ipsum dolor sit amet, vix tamquam tractatos et, cum ei quod invidunt adipisci, eu vis sale aperiam labores. Te insolens iudicabit vituperatoribus sit, ei cum utinam referrentur. Ne probo delenit eam. Ea vitae convenire duo, nibh volutpat mel in. Invidunt percipitur in pri, ea vocent legendos hendrerit per, ut iriure platonem sea.</p>
          <p class="adam">Muhammad Abrar Hassan, CEO</p>
          <div class="clear"></div>
        </div>
        <div class="footer two">
          <h3>Keep Connected</h3>
          <ul>
            @if(!filter_var($settings->facebook, FILTER_VALIDATE_URL) === false)
            <li><a class="fb" href="{{$settings->facebook}}"><i></i>Like us on Facebook</a></li>
            @endif
            @if(!filter_var($settings->twitter, FILTER_VALIDATE_URL) === false)
            <li><a class="fb1" href="{{$settings->twitter}}"><i></i>Follow us on Twitter</a></li>
            @endif
            @if(!filter_var($settings->googleplus, FILTER_VALIDATE_URL) === false)
            <li><a class="fb2" href="{{$settings->googleplus}}"><i></i>Add us on Google Plus</a></li>
            @endif
            @if(!filter_var($settings->linkedin, FILTER_VALIDATE_URL) === false)
            <li><a class="fb3" href="{{$settings->linkedin}}"><i></i>Follow us on Linkedin</a></li>
            @endif
          </ul>
        </div>
        <div class="footer three">
          <h3>{{trans('eminent.headings.contact-us')}}</h3>
          <ul>
            <li>{{$settings->site_title}}<address>{{$settings->site_address_line_1}}, {{$settings->site_address_line_2}}</address> </li>
            <li>{{$settings->site_phone}}</li>
            <li><a href="mailto:{{$settings->site_email}}">{{$settings->site_email}}</a> </li>
          </ul>
        </div>
        <div class="clear"></div>
      </div>
      <div class="copy-right-grids">
        <div class="copy-left">
            <p class="footer-gd">{!!$settings->site_footer!!}</p>
        </div>
        <div class="copy-right">
          <ul>
            <li><a href="#">Company Information</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms & Conditions</a></li>
          </ul>
        </div>
        <div class="clear"></div>
      </div>
    </div>  
    </footer>