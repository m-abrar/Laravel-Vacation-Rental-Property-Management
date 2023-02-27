<style type="text/css">
  .slow-spin {
  -webkit-animation: fa-spin 6s infinite linear;
  animation: fa-spin 6s infinite linear;
  }
  #settings-button {
  right:-60px; top:30px;
  position: absolute;
  background-color: #ddd;
  border: solid 1px #ccc;
  color:#222;
  }
  #theme-options-panel {
  float: left;
  height:350px;
  width:250px;
  z-index:2;
  position:fixed;
  top:55px;
  left:-250px;
  background:#ddd; border: solid 1px #ccc;
  color:#000;
  z-index: 1400;
  }
  #theme-options-panel > div > .box {
  width: 25px;
  height: 25px;
  margin: 5px;
  cursor: pointer;
  float: left;
  }
  #theme-options-panel > div > .themebutton001 {
  border-top: #1d5134 solid 7px;
  background-color: #48a942;
  }
  #theme-options-panel > div > .themebutton002 {
  border-top: #511D3A solid 7px;
  background-color: #A342A9;
  }
  #theme-options-panel > div > .themebutton003 {
  border-top: #2F1D51 solid 7px;
  background-color: #4252A9;
  }
  #theme-options-panel > div > .themebutton004 {
  border-top: #1D3E51 solid 7px;
  background-color: #42A99A;
  }
  #theme-options-panel > div > .themebutton005 {
  border-top: #51391D solid 7px;
  background-color: #A94642;
  }
  #theme-options-panel > div > .themebutton006 {
  border-top: #51391D solid 7px;
  background-color: #9E9E9E;
  }
  #theme-options-panel > div > .themebutton007 {
  border-top: #51391D solid 7px;
  background-color: #795548;
  }
  #theme-options-panel > div > .themebutton008 {
  border-top: #51391D solid 7px;
  background-color: #00BCD4;
  }
  #theme-options-panel > div > .themebutton009 {
  border-top: #51391D solid 7px;
  background-color: #FF5722;
  }
  #theme-options-panel > div > .themebutton010 {
  border-top: #51391D solid 7px;
  background-color: #8BC34A;
  }
  #theme-options-panel > div > .themebutton011 {
  border-top: #51391D solid 7px;
  background-color: #CDDC39;
  }
  #theme-options-panel > div > .themebutton012 {
  border-top: #51391D solid 7px;
  background-color: #E91E63;
  }
 /* #theme-options-panel > div > .themebutton013 {
  border-top: #51391D solid 7px;
  background-color: #9C27B0;
  }*/
</style>
<div id="theme-options-panel" style="text-align: center;">
  <a href="#" id="settings-button"><i class="fa fa-cog  fa-spin fa-3x fa-fw slow-spin"></i></a>
    <h4>Theme Colors!</h4>
    <div style="margin-left:35px;">
  <div class="box themebutton001" data-theme_options_color="{{ asset('/css/eminent-theme-001.css') }}"></div>
  <div class="box themebutton002" data-theme_options_color="{{ asset('/css/eminent-theme-002.css') }}"></div>
  <div class="box themebutton003" data-theme_options_color="{{ asset('/css/eminent-theme-003.css') }}"></div>
  <div class="box themebutton004" data-theme_options_color="{{ asset('/css/eminent-theme-004.css') }}"></div>
  <div class="box themebutton005" data-theme_options_color="{{ asset('/css/eminent-theme-005.css') }}"></div>
  <div class="box themebutton006" data-theme_options_color="{{ asset('/css/eminent-theme-006.css') }}"></div>
  <div class="box themebutton007" data-theme_options_color="{{ asset('/css/eminent-theme-007.css') }}"></div>
  <div class="box themebutton008" data-theme_options_color="{{ asset('/css/eminent-theme-008.css') }}"></div>
  <div class="box themebutton009" data-theme_options_color="{{ asset('/css/eminent-theme-009.css') }}"></div>
  <div class="box themebutton010" data-theme_options_color="{{ asset('/css/eminent-theme-010.css') }}"></div>
  <div class="box themebutton011" data-theme_options_color="{{ asset('/css/eminent-theme-011.css') }}"></div>
  <div class="box themebutton012" data-theme_options_color="{{ asset('/css/eminent-theme-012.css') }}"></div>
  <!-- <div class="box themebutton013" data-theme_options_color="{{ asset('/css/eminent-theme-013.css') }}"></div> -->
  <br/><br/>
</div>


<div>
  <h4>Header Style</h4>| 
  <a href="?theme_options_header=1">01</a> | 
  <a href="?theme_options_header=2">02</a> | 
  <a href="?theme_options_header=3">03</a> | 
  <a href="?theme_options_header=4">04</a> | 
  <a href="?theme_options_header=5">05</a> | 
</div>


<div>
  <h4>Hero Style</h4>| 
  <a href="?theme_options_hero=1" data-toggle="tooltip" title="Bootstrap Carousel Simple">01</a> | 
  <a href="?theme_options_hero=2" data-toggle="tooltip" title="Transparent">02</a> | 
  <a href="?theme_options_hero=3" data-toggle="tooltip" title="Search Bar on Hero">03</a> | 
  <a href="?theme_options_hero=4" data-toggle="tooltip" title="Unit Gallery">04</a> |
  <a href="?theme_options_hero=5" data-toggle="tooltip" title="Fixed Background">05</a> |
  <a href="?theme_options_hero=5" data-toggle="tooltip" title="Map of Properties">06</a> |
</div>



<div>
  <h4>Home Style</h4>| 
  <a href="?theme_options_home=1">01</a> | 
  <a href="?theme_options_home=2">02</a> | 
  <a href="?theme_options_home=3">03</a> | 
  <a href="?theme_options_home=4">04</a> |
  <a href="?theme_options_home=5">05</a> |
  <a href="?theme_options_home=5">06</a> |
</div>




<div>
  <h4>Footer Style</h4>| 
  <a href="?theme_options_footer=1">01</a> | 
  <a href="?theme_options_footer=2">02</a> | 
  <a href="?theme_options_footer=3">03</a> | 
  <a href="?theme_options_footer=4">04</a> |
  <a href="?theme_options_footer=5">05</a> |
</div>




</div>
<script>
  function setCookie(cname,cvalue,exdays) {
      var d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      var expires = "expires=" + d.toGMTString();
      document.cookie = cname+"="+cvalue+"; "+expires;
  }
  
  function getCookie(cname) {
      var name = cname + "=";
      var ca = document.cookie.split(';');
      for(var i=0; i<ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0)==' ') c = c.substring(1);
          if (c.indexOf(name) == 0) {
              return c.substring(name.length, c.length);
          }
      }
      return "";
  }
  
  $(function() {
      $('#theme-options-panel > div > .box').click(function (){
      var theme_options_color = $(this).data('theme_options_color');
      $('#theme_options_color').attr('href',theme_options_color);
      setCookie("theme_options_color", theme_options_color, 30);
  });
  });
  
  
  $(document).ready(function(){
  $('#settings-button').click(function(){
  var toggleoptions = $('#theme-options-panel');
  var settingsbutton = $('#settings-button');
  if (toggleoptions.hasClass('visible')){
    toggleoptions.animate({"left":"-250px"}, "slow").removeClass('visible');
    //settingsbutton.animate({"left":"200px"}, "slow");
  } else {
    //settingsbutton.animate({"left":"400px"}, "slow");
    toggleoptions.animate({"left":"0px"}, "slow").addClass('visible');
  }
  });
  });
</script>