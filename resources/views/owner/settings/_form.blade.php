<div class="col-md-12">
  <fieldset>
    <legend>Settings</legend>
    <div class="col-md-12" role="tabpanel">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#website" aria-controls="website" role="tab" data-toggle="tab">Website</a></li>
        <li role="presentation"><a href="#office" aria-controls="office" role="tab" data-toggle="tab">Office</a></li>
        <li role="presentation"><a href="#design" aria-controls="design" role="tab" data-toggle="tab">Design</a></li>
        <li role="presentation"><a href="#social" aria-controls="social" role="tab" data-toggle="tab">Social Links</a></li>
        <li role="presentation"><a href="#payment" aria-controls="payment" role="tab" data-toggle="tab">Payment</a></li>
        <li role="presentation"><a href="#policies" aria-controls="policies" role="tab" data-toggle="tab">Policies</a></li>
        <li role="presentation"><a href="{{url('admin/locations')}}">Locations</a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="website">
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Site Title<font color="#FF0000">*</font></label>
            <div class="col-sm-9 col-xs-12">
              <input 
                type="text"
                name = "site_title"
                placeholder="Enter title here"
                value="@if(old('site_title')){!! old('site_title') !!}@elseif(isset($setting->site_title)){!!$setting->site_title!!}@endif"
                class="form-control"
                />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Site Email<font color="#FF0000">*</font></label>
            <div class="col-sm-9 col-xs-12">
              <input 
                name="site_email" 
                type="email" 
                value="@if(old('site_email')){!! old('site_email') !!}@elseif(isset($setting->site_email)){!!$setting->site_email!!}@endif"
                class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Site URL<font color="#FF0000">*</font></label>
            <div class="col-sm-9 col-xs-12">
              <input 
                name="site_url" 
                type="url" 
                value="@if(old('site_url')){!! old('site_url') !!}@elseif(isset($setting->site_url)){!!$setting->site_url!!}@endif"
                class="form-control" />
            </div>
          </div>
          <!-- <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Site Mode</label>
            <div class="col-sm-9 col-xs-12 checkbox">
            
              <label>
                    <input name="is_site_live" type="checkbox" value="1"
                  @if(old('is_site_live')){{'checked="checked"'}}
                  @elseif(isset($setting->is_site_live) and ($setting->is_site_live=='1')){{'checked="checked"'}}@endif />
                    Live</label>
            </div>
            </div> -->
        </div>
        <div role="tabpanel" class="tab-pane" id="office">
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Address Line 1</label>
            <div class="col-sm-9 col-xs-12">
              <input 
                name="site_address_line_1" 
                type="text" 
                value="@if(old('site_address_line_1')){!! old('site_address_line_1') !!}@elseif(isset($setting->site_address_line_1)){!!$setting->site_address_line_1!!}@endif"
                class="form-control" 
                placeholder="Business address line 1" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Address Line 2</label>
            <div class="col-sm-9 col-xs-12">
              <input 
                name="site_address_line_2" 
                type="text" 
                value="@if(old('site_address_line_2')){!! old('site_address_line_2') !!}@elseif(isset($setting->site_address_line_2)){!!$setting->site_address_line_2!!}@endif"
                class="form-control" 
                placeholder="Business address line 2" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label"> Phone</label>
            <div class="col-sm-9 col-xs-12">
              <input 
                name="site_phone" 
                type="text" 
                value="@if(old('site_phone')){!! old('site_phone') !!}@elseif(isset($setting->site_phone)){!!$setting->site_phone!!}@endif"
                class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Latitude</label>
            <div class="col-sm-9 col-xs-12">
              <input 
                name="latitude" 
                type="text" 
                value="@if(old('latitude')){!! old('latitude') !!}@elseif(isset($setting->latitude)){!!$setting->latitude!!}@endif"
                class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Longitude</label>
            <div class="col-sm-9 col-xs-12">
              <input 
                name="longitude" 
                type="text" 
                value="@if(old('longitude')){!! old('longitude') !!}@elseif(isset($setting->longitude)){!!$setting->longitude!!}@endif"
                class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Business Hours</label>
            <div class="col-sm-9 col-xs-12">
              <input 
                name="business_hours" 
                type="text" 
                value="@if(old('business_hours')){!! old('business_hours') !!}@elseif(isset($setting->business_hours)){!!$setting->business_hours!!}@endif"
                class="form-control" />
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="design">
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Site Header Top</label>
            <div class="col-sm-9 col-xs-12">
              <textarea name="site_header_top" class="form-control mceEditor">@if(old('site_header_top')){!! old('site_header_top') !!}@elseif(isset($setting->site_header_top)){!!$setting->site_header_top!!}@endif</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Site Header </label>
            <div class="col-sm-9 col-xs-12">
              <textarea name="site_header" class="form-control mceEditor">@if(old('site_header')){!! old('site_header') !!}@elseif(isset($setting->site_header)){!!$setting->site_header!!}@endif</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Site Footer </label>
            <div class="col-sm-9 col-xs-12">
              <textarea name="site_footer" class="form-control mceEditor">@if(old('site_footer')){!! old('site_footer') !!}@elseif(isset($setting->site_footer)){!!$setting->site_footer!!}@endif</textarea>
            </div>
          </div>
          @if(old('tmp_img_path_avatar'))
          <?php $image_path = Request::old('tmp_img_path_avatar'); ?>
          @elseif(isset($setting->avatar) and is_file('admin/img/'.$setting->avatar))
          <?php $image_path = 'admin|img|'.$setting->avatar; ?>
          @else
          <?php $image_path = 'NA'; ?>
          @endif
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Avatar</label>
            <div class="col-sm-9 col-xs-12" id="add-avatar">
              <script>$(document).ready(function() { window.onload = cropperLoadAvatar('avatar','N','NA',"{{$image_path}}","{{$image_path}}"); });</script>
            </div>
          </div>
          <script>
            function cropperLoadAvatar(n,deletable,db_id,preview_image,tmp_img_path){
                var preview_image = preview_image.replace(/\//i, '|');
                var tmp_img_path = tmp_img_path.replace(/\//i, '|');
            
              $.ajax({
                url: "{{url('/')}}/load-cropper-object/" + n + '/' + deletable + '/' + db_id + '/250/250/' + preview_image + '/' +tmp_img_path,
                success: function(result) {
                  $("#add-avatar").html(result);
                }
              });  
                
            }
            
          </script>
          @if(old('tmp_img_path_logo_dark'))
          <?php
          $image_path = Request::old('tmp_img_path_logo_dark'); 
          ?>
          @elseif(isset($setting->logo_dark) and is_file('img/'.$setting->logo_dark))
          <?php $image_path = 'img|'.$setting->logo_dark; ?>
          @else
          <?php $image_path = 'NA'; ?>
          @endif
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Logo Dark</label>
            <div class="col-sm-9 col-xs-12" id="add-logo-dark">
              <script>$(document).ready(function() { window.onload = cropperLoadLogoDark('logodark','N','NA',"{{$image_path}}","{{$image_path}}"); });</script>
            </div>
          </div>
          @if(old('tmp_img_path_logo_light'))
          <?php
          $image_path = Request::old('tmp_img_path_logo_light'); 
          ?>
          @elseif(isset($setting->logo_light) and is_file('img/'.$setting->logo_light))
          <?php $image_path = 'img|'.$setting->logo_light; ?>
          @else
          <?php $image_path = 'NA'; ?>
          @endif
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Logo Light</label>
            <div class="col-sm-9 col-xs-12" id="add-logo-light" style="background-color:#000; padding:10px">
              <script>$(document).ready(function() { window.onload = cropperLoadLogoLight('logolight','N','NA',"{{$image_path}}","{{$image_path}}"); });</script>
              
            </div>
          </div>
          <script>
            function cropperLoadLogoDark(n,deletable,db_id,preview_image,tmp_img_path){
                var preview_image = preview_image.replace(/\//i, '|');
                var tmp_img_path = tmp_img_path.replace(/\//i, '|');
              $.ajax({
                url: "{{url('/')}}/load-cropper-object/" + n + '/' + deletable + '/' + db_id + '/450/150/' + preview_image + '/' +tmp_img_path,
                success: function(result) {
                  $("#add-logo-dark").html(result);
                }
              });  
            }
            function cropperLoadLogoLight(n,deletable,db_id,preview_image,tmp_img_path){
                var preview_image = preview_image.replace(/\//i, '|');
                var tmp_img_path = tmp_img_path.replace(/\//i, '|');
              $.ajax({
                url: "{{url('/')}}/load-cropper-object/" + n + '/' + deletable + '/' + db_id + '/450/150/' + preview_image + '/' +tmp_img_path,
                success: function(result) {
                  $("#add-logo-light").html(result);
                }
              });  
            }
          </script>
        </div>
        <div role="tabpanel" class="tab-pane" id="social">
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Facebook </label>
            <div class="col-sm-9 col-xs-12">
              <input 
                name="facebook" 
                type="url" 
                value="@if(old('facebook')){!! old('facebook') !!}@elseif(isset($setting->facebook)){!!$setting->facebook!!}@endif"
                class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Twitter </label>
            <div class="col-sm-9 col-xs-12">
              <input 
                name="twitter" 
                type="url" 
                value="@if(old('twitter')){!! old('twitter') !!}@elseif(isset($setting->twitter)){!!$setting->twitter!!}@endif"
                class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Linkedin </label>
            <div class="col-sm-9 col-xs-12">
              <input 
                name="linkedin" 
                type="url" 
                value="@if(old('linkedin')){!! old('linkedin') !!}@elseif(isset($setting->linkedin)){!!$setting->linkedin!!}@endif"
                class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Google+ </label>
            <div class="col-sm-9 col-xs-12">
              <input 
                name="googleplus" 
                type="url" 
                value="@if(old('googleplus')){!! old('googleplus') !!}@elseif(isset($setting->googleplus)){!!$setting->googleplus!!}@endif"
                class="form-control" />
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="payment">
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Payment Mode</label>
            <div class="col-sm-9 col-xs-12">
              <select name="payment_mode" class="form-control">
              <option value="live"
              @if ($setting->payment_mode == "live")
              selected="selected" @endif 
              >Live</option>
              <option value="demo"
              @if ($setting->payment_mode == "demo")
              selected="selected" @endif 
              >Demo</option>
              </select>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="policies">
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Rental Policies</label>
            <div class="col-sm-9 col-xs-12">
              <textarea name="rental_policies" class="form-control mceEditor">@if(old('rental_policies')){!! old('rental_policies') !!}@elseif(isset($setting->rental_policies)){!!$setting->rental_policies!!}@endif</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label"></label>
            <div class="col-sm-9 col-xs-12 checkbox">
              <label>
              <input name="is_rental_policies" type="checkbox" value="1"
              @if(old('is_rental_policies')){{'checked="checked"'}}
              @elseif(isset($setting->is_rental_policies) and ($setting->is_rental_policies=='1')){{'checked="checked"'}}@endif />
              Show</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </fieldset>
  <br/><br/>
</div>
