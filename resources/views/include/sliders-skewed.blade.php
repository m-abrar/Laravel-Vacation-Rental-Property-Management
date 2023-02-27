<section>

<!-- Skewed Slider -->
    <link href="{{ asset('resources/plugins/jquery.sldr-master/css/styles.css') }}" rel="stylesheet">
    <!-- /.Skewed Slider -->
<div id="SLDR-ONE" class="sldr">
    <ul class="wrap animate">
      <li class="elmnt-one"><div class="skew"><div class="wrap"><img class="sliderimg" src="{{ asset('pictures/slider-20150921043740.png') }}" width="1200" height="400"></div></div></li>
      <li class="elmnt-two"><div class="skew"><div class="wrap"><img class="sliderimg" src="{{ asset('pictures/slider-20150921042715.png') }}" width="1200" height="400"></div></div></li>
      <li class="elmnt-three"><div class="skew"><div class="wrap"><img class="sliderimg" src="{{ asset('pictures/slider-20150921044522.png') }}" width="1200" height="400"></div></div></li>
    </ul>
  </div>

  <div class="clear"></div>

  <div class="captions">
   <div class="focalPoint"><p><small>Lake</small></p></div>
   <div><p><small>Mountain Range</small></p></div>
   <div><p><small>Mt. Fuji</small></p></div>
  </div>

  <ul class="selectors">
    <li class="focalPoint"><a href="">•</a></li>
    <li><a href="">•</a></li>
    <li><a href="">•</a></li>
  </ul>

  <div class="clear"></div>



</div>

<script src="{{asset('resources/plugins/jquery.sldr-master/js/jquery.sldr.js') }}"></script>
<script>

$( window ).load( function() {

  $( '.sldr' ).each( function() {
    var th = $( this );
    th.sldr({
      focalClass    : 'focalPoint',
      offset        : th.width() / 2,
      sldrWidth     : 'responsive',
      nextSlide     : th.nextAll( '.sldr-nav.next:first' ),
      previousSlide : th.nextAll( '.sldr-nav.prev:first' ),
      selectors     : th.nextAll( '.selectors:first' ).find( 'li' ),
      toggle        : th.nextAll( '.captions:first' ).find( 'div' ),
      sldrInit      : sliderInit,
      sldrStart     : slideStart,
      sldrComplete  : slideComplete,
      sldrLoaded    : sliderLoaded,
      sldrAuto      : true,
      sldrTime      : 5000,
      hasChange     : true
    });
  });

});

/**
 * Sldr Callbacks
 */

/**
 * When the sldr is initiated, before the DOM is manipulated
 * @param {object} args the slides, callback, and config of the slider
 * @return null
 */
function sliderInit( args ) {

}

/**
 * When individual slides are loaded
 * @param {object} args the slides, callback, and config of the slider
 * @return null
 */
function slideLoaded( args ) {

}

/**
 * When the full slider is loaded, after the DOM is manipulated
 * @param {object} args the slides, callback, and config of the slider
 * @return null
 */
function sliderLoaded( args ) {

}

/**
 * Before the slides change focal points
 * @param {object} args the slides, callback, and config of the slider
 * @return null
 */
function slideStart( args ) {

}

/**
 * After the slides are done changing focal points
 * @param {object} args the slides, callback, and config of the slider
 * @return null
 */
function slideComplete( args ) {

}

</script>

</section>