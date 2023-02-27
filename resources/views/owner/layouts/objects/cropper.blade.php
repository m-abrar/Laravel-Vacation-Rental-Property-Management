<?php
  $preview_image = str_replace('|', '/', $preview_image);
  $tmp_img_path = str_replace('|', '/', $tmp_img_path);
  
  
  function gcd($a,$b) {
      $a = abs($a); $b = abs($b);
      if( $a < $b) list($b,$a) = Array($a,$b);
      if( $b == 0) return $a;
      $r = $a % $b;
      while($r > 0) {
          $a = $b;
          $b = $r;
          $r = $a % $b;
      }
      return $b;
  }
  
  
  function simplify($num,$den) {
      $g = gcd($num,$den);
      return Array($num/$g,$den/$g);
  }
  list ($ratioW,$ratioH) = simplify($width,$height);
  
  $ratio = $ratioW.'x'.$ratioH;
  
  ?>
<article class="col-md-3" id="crop-pictuer-{{$number}}">
  <input type="hidden" class="crop-width" value="{{$width}}" >
  <input type="hidden" class="crop-height" value="{{$height}}" >
  <input name="image_db_id_{{$number}}" type="hidden" value="{{$db_id}}" >
  <input name="image_data_{{$number}}" type="hidden" class="image-data" >
  <input name="tmp_img_path_{{$number}}" type="hidden" class="img-path" value="{{$tmp_img_path}}">
  <input type="hidden" class="site-url" value="{{url('/')}}" >
  <input type="hidden" class="csrf_token" value="{{ csrf_token() }}">
  <input type="hidden" class="image-src">
  <!-- Current image -->
  <div id="{{$number}}" class="image-view image-view-{{$ratio}} crop-initiate">
    @if(is_file($preview_image))
    <img src="{{asset($preview_image)}}">
    @else
    <img src="http://placehold.it/{{$width}}x{{$height}}" />
    @endif
  </div>
  <!-- Cropping modal -->
  <div class="modal fade image-modal modal-fullscreen force-fullscreen" aria-hidden="true" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Loading state -->
        <div class="image-loading" aria-label="Loading" role="img" tabindex="-1"></div>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" >Add New Picture</h4>
        </div>
        <div class="modal-body">
          <div class="image-body">
            <!-- Crop and preview -->
            <div class="row">
              <div class="col-md-12">
                <div class="image-wrapper"></div>
              </div>
              <div class="col-md-4">
                <label class="btn btn-primary btn-block" for="inputImage-{{$number}}" title="Select image file">
                <input class="image-input sr-only" id="inputImage-{{$number}}" name="file_{{$number}}" type="file" accept="image/*">
                <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="Select image file">
                <i class="fa fa-camera"></i> Select image file
                </span>
                </label>
              </div>
              <div class="col-md-4 text-center">
                <button type="button" class="btn btn-success image-save btn-block">
                <i class="glyphicon glyphicon-upload"></i> Upload to server </button>
              </div>
              <div class="col-md-4">
                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">
                <i class="glyphicon glyphicon-ban-circle"></i> Cancel
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div><!-- /.modal -->
  @if($deletable=='Y') 
  @if( is_numeric($db_id)) 
  <div class="checkbox"><label><input type="checkbox" name="image_delete_{{$number}}" value="{{$db_id}}" >Delete</label></div>
  <br/><br/>
  @else
  <a class="checkbox image_remove_instantly" href="#">Delete</a><br/><br/>
  @endif
  @endif
</article>
