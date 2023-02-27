<div class="col-md-12">
  <fieldset>
    <legend>User Profile</legend>
    <div class="col-md-12" role="tabpanel">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#website" aria-controls="website" role="tab" data-toggle="tab">Contact</a></li>
        <li role="presentation"><a href="#password" aria-controls="password" role="tab" data-toggle="tab">Password</a></li>
        <li role="presentation"><a href="#avatar" aria-controls="avatar" role="tab" data-toggle="tab">Avatar</a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="website">
          <label class="col-sm-3 col-xs-12 control-label">First Name<font color="#FF0000">*</font></label>
          <div class="col-sm-9 col-xs-12">
            <input 
              type="text"
              name = "firstname"
              placeholder="Enter first name here"
              value="@if(old('firstname')){!! old('firstname') !!}@elseif(isset($user->firstname)){!!$user->firstname!!}@endif"
              class="form-control"
              />
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Last Name<font color="#FF0000">*</font></label>
            <div class="col-sm-9 col-xs-12">
              <input 
                type="text"
                name = "lastname"
                placeholder="Enter last name here"
                value="@if(old('lastname')){!! old('lastname') !!}@elseif(isset($user->lastname)){!!$user->lastname!!}@endif"
                class="form-control"
                />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Designation</label>
            <div class="col-sm-9 col-xs-12">
              <input 
                type="text"
                name = "designation"
                placeholder="Enter designation here"
                value="@if(old('designation')){!! old('designation') !!}@elseif(isset($user->designation)){!!$user->designation!!}@endif"
                class="form-control"
                />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Username<font color="#FF0000">*</font></label>
            <div class="col-sm-9 col-xs-12">
              <input 
                type="text"
                name = "username"
                placeholder="Enter username here"
                value="@if(old('username')){!! old('username') !!}@elseif(isset($user->username)){!!$user->username!!}@endif"
                class="form-control"
                />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Email<font color="#FF0000">*</font></label>
            <div class="col-sm-9 col-xs-12">
              <input 
                type="text"
                name = "email"
                placeholder="Enter email here"
                value="@if(old('email')){!! old('email') !!}@elseif(isset($user->email)){!!$user->email!!}@endif"
                class="form-control"
                />
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="password">
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Password</label>
            <div class="col-sm-9 col-xs-12">
              <input 
                type="password"
                name = "password"
                value=""
                class="form-control"
                />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Password Confirm</label>
            <div class="col-sm-9 col-xs-12">
              <input 
                type="password"
                name = "password_confirm"
                value=""
                class="form-control"
                />
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="avatar">
          @if(old('tmp_img_path_avatar'))
          <?php $image_path = Request::old('tmp_img_path_avatar'); ?>
          @elseif(isset($user->avatar) and is_file($user->avatar))
          <?php $image_path = str_replace('/','|',$user->avatar); ?>
          @else
          <?php $image_path = 'NA'; ?>
          @endif
          <div class="form-group">
            <label class="col-sm-3 col-xs-12 control-label">Picture</label>
            <div class="col-sm-9 col-xs-12" id="picture">
              <script>$(document).ready(function() { window.onload = cropperLoad('avatar','N','NA',"{{$image_path}}","{{$image_path}}"); });</script>
            </div>
          </div>
          <script>
            var width = '250';
            var height = '250';
            function cropperLoad(n,deletable,db_id,preview_image,tmp_img_path){
                var preview_image = preview_image.replace(/\//i, '|');
                var tmp_img_path = tmp_img_path.replace(/\//i, '|');
            
              $.ajax({
                url: "{{url('/')}}/load-cropper-object/" + n + '/' + deletable + '/' + db_id + '/' + width + '/' + height + '/' + preview_image + '/' +tmp_img_path,
                success: function(result) {
                  $("#picture").html(result);
                }
              });  
                
            }
            
          </script>
        </div>
      </div>
    </div>
  </fieldset>
  <br/><br/>
</div>
