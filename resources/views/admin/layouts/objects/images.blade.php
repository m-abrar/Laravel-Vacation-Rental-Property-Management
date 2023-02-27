<script>
  var width = '800';
  var height = '600';
  function cropperLoad(n,deletable,db_id,preview_image,tmp_img_path){
      var preview_image = preview_image.replace(/\//i, '|');
      var tmp_img_path = tmp_img_path.replace(/\//i, '|');
  
    $.ajax({
      url: "{{url('/')}}/load-cropper-object/" + n + '/' + deletable + '/' + db_id + '/' + width + '/' + height + '/' + preview_image + '/' +tmp_img_path,
      success: function(result) {
        $("#dynamic_images_wrap").append(result);
      }
    });  
  }
</script>
<script>
  $(document).ready(function() {
  var images_max_fields      = 100; //maximum input boxes allowed
  var image_add_button       = $("#add_image_button"); //Add button ID
  
  var counter = $('#images_total').val(); //initlal text box count
  
  $(image_add_button).click(function(e){ //on add input button click
      e.preventDefault();
      if(counter < images_max_fields){ //max input box allowed
          counter++; //text box increment
  
           cropperLoad(counter,'Y','NA','NA','NA');
  
          $('#images_total').val(counter);
      }
  });
  
  $("#dynamic_images_wrap").on("click",".image_remove_instantly", function(e){ //user click on remove text
      e.preventDefault(); $(this).closest('article').remove(); x--;
  })
  
  
  });
  
</script>
<div class="form-group">
  <div class="col-md-12" id="dynamic_images_wrap">
    @if(isset($images))
    <!-- EDIT -->
    <?php $i=1 ?>
    @foreach($images as $image)
    @if(old('tmp_img_path_'.$i))
    <?php $image_path = Request::old('tmp_img_path_'.$i); ?>
    @elseif(is_file($image->image_small))
    <?php $image_path = str_replace('/','|',$image->image_small); ?>
    @else
    <?php $image_path = 'NA'; ?>
    @endif
    <script>
      $(document).ready(function() {
          window.onload = cropperLoad("{{$i}}",'Y',"{{$image->id}}","{{$image_path}}","{{$image_path}}");
      });
    </script>
    <?php $i++ ?>
    @endforeach
    @for ($i=$i; $i <= old('images_total'); $i++)
    <script>
      $(document).ready(function() {
          window.onload = cropperLoad("{{$i}}",'Y','NA',"{{old('tmp_img_path_'.$i)}}","{{old('tmp_img_path_'.$i)}}");
      });
    </script>
    @endfor
    @else
    <!-- ADD -->
    @if(old('images_total'))
    @for ($i=1; $i <= old('images_total'); $i++)
    <script>
      $(document).ready(function() {
          window.onload = cropperLoad("{{$i}}",'Y','NA',"{{old('tmp_img_path_'.$i)}}","{{old('tmp_img_path_'.$i)}}");
      });
    </script>
    @endfor
    @else
    <script>
      $(document).ready(function() {
          window.onload = cropperLoad(1,'Y','NA','NA','NA');
          });
    </script>
    @endif
    @endif
  </div>
</div>
<div class="form-group">
  <div class="col-md-12 text-center">
    <button type="button" id="add_image_button" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add More</button>
    <input type="hidden" name="images_total" id="images_total" value="@if(old('images_total')){{old('images_total')}}@elseif(isset($images)){{count($images)}}@else{{1}}@endif" >
  </div>
</div>
