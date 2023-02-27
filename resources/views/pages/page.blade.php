@extends('layouts.default.start')
<!-- Goes to html>head>title -->
@section('title')
{{$page->title}} - {{$settings->site_title}}
@endsection

@section('head_enqueue_scripts')


@endsection
<!-- Yields body of the page inside the template -->
@section('contents')
<div class="container page-body">
  <!-- Welcome Contents Section -->
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">
        {{$page->title}}
      </h1>
    </div>
    <div class="col-md-8">
      @if($page->is_new==1)
      <img src="{{url('img/label-circle-new.png')}}" class="padding-10 pull-left img-responsive image-100" />
      @endif
      {!!$page->contents!!}   
      <br/>
      <br/>
      <nav>
        <ul class="pager">
          <li>
            <a href="{{url($page->category->slug)}}">
            <span aria-hidden="true">&#8592;</span> 
            All {{$page->category->title}}
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <div class="col-md-4">
      @if(isset($page->images->first()->image) and is_file($page->images->first()->image))
      <img class="test img-responsive" src="{{asset($page->images->first()->image)}}" alt="{{$page->title}}"> <br/>
      @endif
      <div id="light-gallery">
        @foreach ($page->images as $image)
        @if (is_file($image->image))
        <div class="col-md-6 zoomable light-gallery-item" data-src="{{asset( $image->image )}}">
          <a href=""><img class="img-responsive cursor-pointer" src="{{asset( $image->image )}}" /></a>
          <div class="overlay"></div>
        </div>
        @endif
        @endforeach
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- /.row -->
</div>
@endsection
@section('javascript')
<script type="text/javascript">
  $(document).ready(function() {
    $('#light-gallery').lightGallery({
      selector: '.light-gallery-item'
    });
  });
</script>

<!-- Picture Gallery -->

    <!-- jQuery already included @ jquery-2.1.0.js -->

    <link type="text/css" rel="stylesheet" href="{{ asset('resources/plugins/lightGallery-master/dist/css/lightgallery.css')}}" />

    <!-- /. Picture Gallery -->
<!-- Picture Gallery/lightGallery -->

    <!-- jQuery required >= 1.8.0  | jQuery already included in the head jquery-2.1.0.js -->

    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lightgallery.js')}}"></script>

    <!-- A jQuery plugin that adds cross-browser mouse wheel support. (Optional) -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>

    <!-- lightgallery plugins -->

    <script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>

    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-fullscreen.js')}}"></script>

    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-thumbnail.js')}}"></script>

    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-video.js')}}"></script>

    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-autoplay.js')}}"></script>

    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-zoom.js')}}"></script>

    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-hash.js')}}"></script>

    <script src="{{ asset('resources/plugins/lightGallery-master/dist/js/lg-pager.js')}}"></script>

    <!-- End of Picture Gallery/lightGallery -->

@endsection
