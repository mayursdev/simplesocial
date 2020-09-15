<?php
  $type = '';
  if(isset($_GET['type']) && !empty($_GET['type'])){
    $type = $_GET['type'];
  }
  ?>

     <?php echo returnPageContents('left-sidebar/content'); ?>

     <!-- settings container start -->
    <div class="col-sm-6 mt-4">

  <?php if($type =='avatar'){ ?>
        <!-- if type = dp & cover -->
        <div class="settings-content box-shadow rounded p-5 bg-white">
          <h1 class='mb-5'>DP & Cover Settings</h1>
          <form action="" enctype="multipart/form-data" id='updateAvatar'>
            <div class="response-msg">
              <?php echo returnPageContents('state-box/content'); ?>
            </div>
            <div class="row">
              <div class="form-group col-lg-6 mb-5">
                <label for="dp" class='h4'>Display Picture</label>
                <div class="file-upload-btn mt-1">
                  <input type="file" onchange="dispFileName(this.files,'dpFileName')" name="dp" class='form-control' id="dp" accept="image/*">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-camera">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                  </svg>
                </div>
                <input class='form-control' type="text" readonly id='dpFileName'>
              </div>
              <div class="form-group col-lg-6 mb-5">
                <label for="cover" class='h4'>Cover Picture</label>
                <div class="file-upload-btn mt-1">
                  <input type="file" name="cover" onchange="dispFileName(this.files,'coverFileName')" class='form-control' id="cover" accept="image/*">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-image">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                  </svg>
                </div>
                <input class='form-control' type="text" readonly id='coverFileName'>

              </div>
              <div class="col-lg-12">
                <button class="btn px-5 ml-auto py-2 button-primary d-flex justify-content-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-check-circle mr-3">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                  </svg>
                  <span class="h4">Save</span>
                </button>
              </div>
            </div>
          </form>
        </div>
  <?php }elseif($type=='password'){ ?>
        <!-- if type = password -->
        <div class="settings-content box-shadow rounded p-5 bg-white">
          <h1 class='mb-5'>Password Settings</h1>
          <form action="" id='updatePassword'>
            <div class="response-msg">
            <?php echo returnPageContents('state-box/content'); ?>
            </div>
            <div class="row">
              <div class="form-group col-lg-12 mb-5">
                <label for="currentPass" class='h4'>Current Password</label>
                <input type="text" name="currentPass" class='form-control p-4' id="currentPass" required>
              </div>
              <div class="form-group col-lg-6 mb-5">
                <label for="newPass" class='h4'>New Password</label>
                <input type="text" name="newPass" class='form-control p-4' id="newPass" required>
              </div>
              <div class="form-group col-lg-6 mb-5">
                <label for="confirmPass" class='h4'>Repeat Password</label>
                <input type="text" name="confirmPass" class='form-control p-4' id="confirmPass" required>
              </div>
              <div class="col-lg-12">
                <button class="btn px-5 ml-auto py-2 button-primary d-flex justify-content-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-check-circle mr-3">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                  </svg>
                  <span class="h4">Save</span>
                </button>
              </div>
            </div>
          </form>
        </div>
  <?php }else{ ?>
         <!-- if type = profile -->
        <div class="settings-content box-shadow rounded p-5 bg-white">
          <h1 class='mb-5'>Profile Settings</h1>
          <form action="" id='updateProfile'>
            <div class="response-msg">
            <?php echo returnPageContents('state-box/content'); ?>
            </div>
            <div class="row">
              <div class="form-group col-lg-12 mb-5">
                <label for="fullName" class='h4'>Full Name</label>
                <input required type="text" name="fullName" class='form-control p-4' id="fullName" value='<?php echo $so['user']['screenName']; ?>'>
              </div>
              <div class="form-group col-lg-12 mb-5">
                <label for="about" class='h4'>About me</label>
                <textarea name="about" id="about" cols="30" class='form-control' rows="7"><?php
                   echo $about = (!is_null($so['user']['about']))?($so['user']['about']):'';
                ?></textarea>
              </div>
              <div class="form-group col-lg-6 mb-5">
                <label for="birthday" class='h4'>Birthday</label>
                <input type="date" name="birthday" id="birthday" value='<?php echo $so['user']['birthday']; ?>' class="form-control">
              </div>
              <div class="form-group col-lg-6 mb-5">
                <label for="timer" class='h4 d-block'>Health Reminder</label>
                <select name="timer" class='' id="timer">
                  <?php $timer = ($so['user']['timer']);//get user timer for reminder ?>
                  <option value="disable" <?php if($timer=='disable') echo 'selected' ?>>Disable</option>
                  <option value="one" <?php if($timer=='one') echo 'selected' ?>>1 Minute</option>
                  <option value="twenty" <?php if($timer=='twenty') echo 'selected' ?>>20 Minutes</option>
                  <option value="thirty" <?php if($timer=='thirty') echo 'selected' ?>>30 Minutes</option>
                </select>
              </div>
              <div class="col-lg-12">
                <button class="btn px-5 ml-auto py-2 button-primary d-flex justify-content-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-check-circle mr-3">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                  </svg>
                  <span class="h4">Save</span>
                </button>
              </div>
            </div>
          </form>
        </div>
  <?php } ?>

      </div>
      <!-- settings container end -->

      <!-- Right side setting sidebar start -->
      <div class="col-sm-2 left-fixed pl-0">
        <ul class="list-wrapper bg-white rounded box-shadow">
          <li class="list-item <?php if($type=='') echo 'link-active'; ?>">
            <a href="<?php echo $so['site_url']."/index.php?page=settings"; ?>" class='p-3'>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="#2b53a4"
                  d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,8.39C13.57,9.4 15.42,10 17.42,10C18.2,10 18.95,9.91 19.67,9.74C19.88,10.45 20,11.21 20,12C20,16.41 16.41,20 12,20C9,20 6.39,18.34 5,15.89L6.75,14V13A1.25,1.25 0 0,1 8,11.75A1.25,1.25 0 0,1 9.25,13V14H12M16,11.75A1.25,1.25 0 0,0 14.75,13A1.25,1.25 0 0,0 16,14.25A1.25,1.25 0 0,0 17.25,13A1.25,1.25 0 0,0 16,11.75Z">
                </path>
              </svg>
              Profile
            </a>
          </li>
          <li class="list-item <?php if($type=='avatar') echo 'link-active'; ?>">
            <a href="<?php echo $so['site_url']."/index.php?page=settings&type=avatar"; ?>" class='p-3'>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="#03a9f4"
                  d="M8.5,13.5L11,16.5L14.5,12L19,18H5M21,19V5C21,3.89 20.1,3 19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19Z">
                </path>
              </svg>
              DP & Cover
            </a>
          </li>
          <li class="list-item <?php if($type=='password') echo 'link-active'; ?>">
            <a href="<?php echo $so['site_url']."/index.php?page=settings&type=password"; ?>" class='p-3'>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="#f9bd54"
                  d="M12,12H19C18.47,16.11 15.72,19.78 12,20.92V12H5V6.3L12,3.19M12,1L3,5V11C3,16.55 6.84,21.73 12,23C17.16,21.73 21,16.55 21,11V5L12,1Z">
                </path>
              </svg>
              Password
            </a>
          </li>
        </ul>
      </div>
      <!--  Right side setting sidebar end -->

      <style>
        #dpFileName,#coverFileName{
          display:none;
          width:190px;
          margin-top:1rem
        }
        #timer{
          width:230px;
        }
      </style>
   <!-- //$('imageFileName').hide(); -->
   <script>
    $("#updateAvatar").on('submit',function(e){
      e.preventDefault();
      var formData = new FormData(this);
      // console.log(formData);
      $.ajax({
          url: ajaxRequestFile()+"?f=user&s=update_user_avatar",
          type: "POST",
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
            var data  = JSON.parse(data)
            if(data.success==true){
              $('.alert').removeClass('alert-danger');
              $('.alert').addClass('alert-success');
              $('.alert').html(data.message);
              $('.alert').show();
              $('#dpFileName').hide();
              $('#coverFileName').hide();
              $('#updateAvatar')[0].reset();
              scrollTop();
            }else{
              // error msgs
              $('.state').addClass('alert-danger');
              $('.state').html(data.error);
              $('.state').show();
              scrollTop();
            }
            // console.log(data);
          },
          error: function () {}
                });
    })

    $("#updateProfile").on('submit',function(e){
      e.preventDefault();
      var formData = new FormData(this);
      // console.log(formData);
      $.ajax({
          url: ajaxRequestFile()+"?f=user&s=update_profile",
          type: "POST",
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
            var data  = JSON.parse(data)
            if(data.success==true){
              $('.alert').removeClass('alert-danger');
              $('.alert').addClass('alert-success');
              $('.alert').html(data.message);
              $('.alert').show();
              scrollTop();
              // $('#updateAvatar')[0].reset();
            }else{
              // error msgs
              $('.state').addClass('alert-danger');
              $('.state').html(data.error);
              $('.state').show();
              scrollTop();
            }
            // console.log(data);

          },
          error: function () {}
       });
    })

    $("#updatePassword").on('submit',function(e){
      e.preventDefault();
      var formData = new FormData(this);
      // console.log(formData);
      $.ajax({
          url: ajaxRequestFile()+"?f=user&s=update_password",
          type: "POST",
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
            var data  = JSON.parse(data)
            if(data.success==true){
              $('.alert').removeClass('alert-danger');
              $('.alert').addClass('alert-success');
              $('.alert').html(data.message);
              $('.alert').show();
              scrollTop();
              $('#updatePassword')[0].reset();
            }else{
              // error msgs
              $('.state').addClass('alert-danger');
              $('.state').html(data.error);
              $('.state').show();
              scrollTop();
            }

          },
          error: function () {}
       });
    })

   </script>