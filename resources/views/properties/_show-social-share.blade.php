<div class="row text-center property-social-share">
   <div class="col-md-3 col-sm-6 col-xs-12 share-label"><i class="fa fa-share fa-lg"></i> {{trans('eminent.share')}}</div>
   <div class="col-md-3 col-sm-6 col-xs-4 share-option fb">
    <a href="https://www.facebook.com/sharer/sharer.php?u={{url('show/'.$property->slug)}}" target="_blank"><i class="fa fa-facebook fa-lg"></i>Facebook</a>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-4 share-option twitter">
    <a href="https://twitter.com/share?url={{url('show/'.$property->slug)}}" target="_blank"><i class="fa fa-twitter fa-lg"></i>Twitter</a>
  </div>
   <div class="col-md-3 col-sm-6 col-xs-4 share-option gplus">
    <a href="https://plus.google.com/share?url={{url('show/'.$property->slug)}}" target="_blank"><i class="fa fa-google-plus fa-lg"></i>Google</a>
  </div>
</div>