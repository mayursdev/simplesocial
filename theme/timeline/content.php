  <?php
    $type ='';
    if(isset($_GET['type']) && !empty($_GET['type'])){
      $type = $_GET['type'];
    }
    $isOwner = isOwnerUser($so['user_profile']['user_id']);
  ?>
      <!-- timeline-container-start -->
      <div class="col-sm-10 timeline-container">
        <!-- user dp and cover -->
        <?php echo returnPageContents('timeline/timeline-profile-card'); ?>
        <!-- below timeline cover - user-about-sidebar & profile-user-posts -->
        <div class="row timeline-content">
          <!-- user-posts-container -->
          <div class="col-md-8 timeline-posts-container">
            <!-- if owner create post box -->
          <?php
            if($isOwner && $type ==''){
              echo returnPageContents('post-form/content');
            }
          ?>
        <?php if($type == 'followers'){
            // <!-- if type = friends -->
           echo returnPageContents('timeline/followers-tab');
        }elseif($type =='following'){
          // <!-- if type = following -->
          echo returnPageContents('timeline/following-tab');
        }else{
          // <!-- else type null user-posts  -->
          $posts = getUserPosts($so['user_profile']['user_id']);
          ?>
            <div class="timeline-posts" id='posts-container'>
          <?php
          if(count($posts)>0){
            $postUserData = getUserData($so['user_profile']['user_id']);
          foreach ($posts as $so['post']) {
            $so['post']['postBy'] = $postUserData;
            echo returnPageContents('timeline/posts-tab');
          }
        }else{
          ?><div class="alert alert-light text-dark box-shadow h3 p-4"> <?php if($isOwner) echo 'You'; else echo $so['user_profile']['screenName']; ?> has not posted anything yet.. <?php if($isOwner) echo "You can create new posts.." ?> </div> <?php
        }
          ?>
            </div>
          <?php

        } ?>

          </div>

        <!-- user-about-info left sidebar -->
        <?php echo returnPageContents('timeline/timeline-left-sidebar'); ?>

        </div>
      </div>
      <!-- timeline-container-end -->