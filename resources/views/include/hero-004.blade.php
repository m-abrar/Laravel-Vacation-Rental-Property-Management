<section>
<div id="unite-gallery-slider" style="display:none;">
   @foreach($sliders as $slider)
   <img alt="{{$slider->title}}"
      src="{{asset($slider->image)}}"
      data-image="{{asset($slider->image)}}"
      data-description="{{$slider->title}}">
   @endforeach
</div>
<br/>
<script type="text/javascript">
   jQuery(document).ready(function(){
     jQuery("#unite-gallery-slider").unitegallery({
        gallery_autoplay:true,
        thumb_fixed_size:false,
        gallery_width:2400,  
        gallery_height:800,
        slider_loader_type: 2,            //shape of the loader (1-7)
        slider_transition: "fade",         //fade, slide - the transition of the slide change
        slider_progress_indicator_type: "bar",     //pie, pie2, bar (if pie not supported, it will switch to bar automatically)
        slider_control_zoom:false,
        theme_panel_position: "top"   
     });
   });
</script>


</section>