 <?php
  $type = '';
  if(isset($_GET['type']) && !empty($_GET['type'])){
    $type = $_GET['type'];
  }
  $isOwnerUser = isOwnerUser($so['user_profile']['user_id']);
   ?>
  <div class="timeline-profile-card">
          <div class="profile-card-top">
            <div class="timeline-user-cover-container"><img src="<?php echo $so['site_url'].$so['user_profile']['profileCover']; ?>" alt=""></div>
            <div class="timeline-user-profile-info">
              <div class="timeline-user-profile-pic-container"><img src="<?php echo $so['site_url'].$so['user_profile']['profileImage']; ?>" alt=""></div>
              <div class="timeline-user-profile-details">
                <h1><?php echo $so['user_profile']['screenName']; ?></h1>
                <?php if($isOwnerUser==false){
                if(!alreadyFollowing($so['user_profile']['user_id'])){
                  ?>
                <!-- Follow button -->
                <div class="follow-status d-inline-block">
                <button class="send-request btn btn-primary" onclick="followUser(<?php echo $so['user_profile']['user_id']; ?>)">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                  </svg>
                  <span class="h4">Follow</span>
                </button>
                </div>
                <?php }else{ ?>
                <!-- Already following button -->
                <div class="follow-status d-inline-block">
                <button class="send-request btn btn-success" onclick="followUser(<?php echo $so['user_profile']['user_id']; ?>)">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <polyline points="17 11 19 13 23 9"></polyline>
                  </svg>
                  <span class="h4">Following</span>
                </button>
                </div>
                <?php } ?>

                <button class='message-user btn btn-light'>
                  <a class='text-dark' href="<?php echo $so['site_url']."/index.php?page=message&u=".$so['user_profile']['username']; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="feather feather-message-square">
                      <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span class="h4">Message</span>
                  </a>
                </button>
              <?php }elseif($isOwnerUser==true){ ?>
                <!-- if owner -->
                <button type="button" class="btn btn-light">
                  <a href="<?php echo $so['site_url']."/index.php?page=settings"; ?>" class='text-dark'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="feather feather-edit-2">
                      <polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon>
                    </svg>
                    <span class='h4'>Edit</span>
                  </a>
                </button>
                <?php } ?>
              </div>
            </div>
          </div>
          <ul class="profile-card-bottom box-shadow">
            <li>
              <a href="<?php echo $so['site_url']."/index.php?page=timeline&u=".$so['user_profile']['username']; ?>" class='<?php echo $active = ($type=='') ? 'tab-active' : ''; ?>' id='timeline'>
                <div>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                      d="M11 4h10v2H11V4zm0 4h6v2h-6V8zm0 6h10v2H11v-2zm0 4h6v2h-6v-2zM3 4h6v6H3V4zm2 2v2h2V6H5zm-2 8h6v6H3v-6zm2 2v2h2v-2H5z"
                      fill="currentColor"></path>
                  </svg>
                </div>
                <p>Timeline</p>
              </a>
            </li>
            <li><a href="<?php echo $so['site_url']."/index.php?page=timeline&type=followers&u=".$so['user_profile']['username']; ?>" id='friends' class='<?php echo $active = ($type=='followers') ? 'tab-active' : ''; ?>'>
                <div>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                      d="M16 17V19H2V17S2 13 9 13 16 17 16 17M12.5 7.5A3.5 3.5 0 1 0 9 11A3.5 3.5 0 0 0 12.5 7.5M15.94 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13M15 4A3.39 3.39 0 0 0 13.07 4.59A5 5 0 0 1 13.07 10.41A3.39 3.39 0 0 0 15 11A3.5 3.5 0 0 0 15 4Z"
                      fill="currentColor"></path>
                  </svg>
                </div>
                <p>Followers</p>
              </a></li>

            <li><a href="<?php echo $so['site_url']."/index.php?page=timeline&type=following&u=".$so['user_profile']['username']; ?>" id='photos' class='<?php echo $active = ($type=='following') ? 'tab-active' : ''; ?>'>
                <div>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M15,14C12.33,14 7,15.33 7,18V20H23V18C23,15.33 17.67,14 15,14M6,10V7H4V10H1V12H4V15H6V12H9V10M15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12Z" fill="currentColor"></path></svg>
                </div>
                <p>Following</p>
              </a></li>

          </ul>
        </div>