            <div class="list-card">
              <div class="card text-left box-shadow">
                <div class="card-header h3">
                  <div class="timeline-about-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                      <path fill="currentColor"
                        d="M16 17V19H2V17S2 13 9 13 16 17 16 17M12.5 7.5A3.5 3.5 0 1 0 9 11A3.5 3.5 0 0 0 12.5 7.5M15.94 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13M15 4A3.39 3.39 0 0 0 13.07 4.59A5 5 0 0 1 13.07 10.41A3.39 3.39 0 0 0 15 11A3.5 3.5 0 0 0 15 4Z">
                      </path>
                    </svg>
                  </div>
                  Followers
                </div>
              </div>
              <div class="box-shadow bg-white card p-0">
                <ul class='d-flex list flex-wrap m-0'>
                <?php
                  $followers = getFollowers($so['user_profile']['user_id']);
                  if(count($followers)>0){
                  foreach ($followers as $user) {
                    $followerInfo = getUserData($user['user_id']);
                    ?>
                  <li class='d-flex flex-column align-items-center'>
                    <div class="friend-pic-container">
                      <img src="<?php echo $so['site_url'].$followerInfo['profileImage']; ?>" alt="">
                    </div>
                    <a href="<?php echo $so['site_url']."/index.php?page=timeline&u=".$followerInfo['username']; ?>" class="friend-name"><?php echo $followerInfo['screenName']; ?></a>
                  </li>
                    <?php
                  }
                }else{
                  ?>
                <li class="text-dark h3 p-4">No followers yet.. </li>
                  <?php
                }
                ?>

                  <!-- <li class='d-flex flex-column align-items-center'>
                    <div class="friend-pic-container">
                      <img src="/assets/imgs/users/20_1.jpg" alt="">
                    </div>
                    <a href="#" class="friend-name">Greeshma Menon</a>
                  </li>
                  <li class='d-flex flex-column align-items-center'>
                    <div class="friend-pic-container">
                      <img src="/assets/imgs/users/1.jpg" alt="">
                    </div>
                    <a href="#" class="friend-name">Jane doe</a>
                  </li>
                  <li class='d-flex flex-column align-items-center'>
                    <div class="friend-pic-container">
                      <img src="/assets/imgs/users/2.jpg" alt="">
                    </div>
                    <a href="#" class="friend-name">Joseph Doe</a>
                  </li>
                  <li class='d-flex flex-column align-items-center'>
                    <div class="friend-pic-container">
                      <img src="/assets/imgs/users/4.jpg" alt="">
                    </div>
                    <a href="#" class="friend-name">John Doe</a>
                  </li> -->

                </ul>
              </div>
            </div>