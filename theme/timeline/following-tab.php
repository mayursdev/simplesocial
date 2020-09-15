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
                  Following
                </div>
              </div>
              <div class="box-shadow bg-white card p-0">
                <ul class='d-flex list flex-wrap m-0'>
                <?php
                  $following = getFollowing($so['user_profile']['user_id']);
                  if(count($following)>0){
                  foreach ($following as $user) {
                    $followingInfo = getUserData($user['user_id']);
                    ?>
                  <li class='d-flex flex-column align-items-center'>
                    <div class="friend-pic-container">
                      <img src="<?php echo $so['site_url'].$followingInfo['profileImage']; ?>" alt="">
                    </div>
                    <a href="<?php echo $so['site_url']."/index.php?page=timeline&u=".$followingInfo['username']; ?>" class="friend-name"><?php echo $followingInfo['screenName']; ?></a>
                  </li>
                    <?php
                  }
                }else{
                  ?>
                    <li class="text-dark h3 p-4">Not following any user.. </li>
                  <?php
                }
                ?>
                </ul>
              </div>
            </div>

       <!-- photo version -->
            <!-- <div class="list-card">
              <div class="card text-left box-shadow">
                <div class="card-header h3">
                  <div class="timeline-about-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                      <path fill="currentColor"
                        d="M8.5,13.5L11,16.5L14.5,12L19,18H5M21,19V5C21,3.89 20.1,3 19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19Z">
                      </path>
                    </svg>
                  </div>
                  Photos
                </div>
              </div>
              <div class="box-shadow bg-white card p-0">
                <ul class='justify-content-start d-flex list flex-wrap m-0'>
                  <li class='d-flex flex-column align-items-center'>
                    <div class="timeline-photo-container">
                      <img src="/assets/imgs/posts/14.jpg" alt="">
                    </div>
                  </li>
                  <li class='d-flex flex-column align-items-center'>
                    <div class="timeline-photo-container">
                      <img src="/assets/imgs/posts/1.jpg" alt="">
                    </div>
                  </li>
                  <li class='d-flex flex-column align-items-center'>
                    <div class="timeline-photo-container">
                      <img src="/assets/imgs/posts/18.jpg" alt="">
                    </div>
                  </li>
                  <li class='d-flex flex-column align-items-center'>
                    <div class="timeline-photo-container">
                      <img src="/assets/imgs/users/19_1.jpg" alt="">
                    </div>
                  </li>
                  <li class='d-flex flex-column align-items-center'>
                    <div class="timeline-photo-container">
                      <img src="/assets/imgs/posts/20.jpg" alt="">
                    </div>
                  </li>

                </ul>
              </div>
            </div> -->