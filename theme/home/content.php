      <?php echo returnPageContents('left-sidebar/content'); ?>

      <!-- post container start -->
      <div class="col-sm-6 post-container">
        <?php
        if(isset($_GET['post']) && postExists($_GET['post'])){
          $so['post'] = getPostFromPostId($_GET['post']);
          $so['post']['postBy'] = getUserData($so['post']['post_by']);
          echo returnPageContents('post-layout/content');
      ?>
        <?php }else{ ?>
        <!-- create post box start -->
        <?php echo returnPageContents('post-form/content'); ?>
        <!-- create post box end -->

        <div id="posts-container">
          <!-- all posts dumped here -->
        </div>
        <?php }
       ?>
      </div>
      <!-- post container end -->

      <!-- Right side container start -->
      <div class="col-sm-3 profile-info-side">
        <!-- profile info card start -->
        <div class="logged-user-card box-shadow">
          <div class="logged-user-cover">
            <img src="<?php echo $so["site_url"].$so["user"]["profileCover"]; ?>" alt="profileCover">
          </div>
          <div class="logged-user-avatar-info">
            <div class="logged-user-avatar">
              <img src="<?php echo $so["site_url"].$so["user"]["profileImage"]; ?>" alt="profileImage">
            </div>
            <div class="logged-user-info">
              <a href="<?php echo "{$so["site_url"]}?page=timeline&u={$so["user"]["username"]}"; ?>">
                <?php echo $so["user"]["screenName"]; ?>
              </a>
              <p>@<?php echo $so["user"]["username"]; ?></p>
            </div>
          </div>
          <ul class="logged-user-profile-info">
            <li>
              <a href="<?php echo "{$so["site_url"]}?page=timeline&u={$so["user"]["username"]}"; ?>">
                <h4>Posts</h4>
                <p><?php echo $so['user']['postCount']; ?></p>
              </a>
            </li>
            <li>
              <a href="<?php echo "{$so["site_url"]}?page=timeline&u={$so["user"]["username"]}&type=following"; ?>">
                <h4>Following</h4>
                <p><?php echo $so["user"]["following"]; ?></p>
              </a>
            </li>
            <li>
              <a href="<?php echo "{$so["site_url"]}?page=timeline&u={$so["user"]["username"]}&type=followers"; ?>">
                <h4>Followers</h4>
                <p><?php echo $so["user"]["followers"]; ?></p>
              </a>
            </li>
          </ul>
        </div>
        <!-- profile info card end -->
      </div>
      <!-- profile info side container end -->
      <script>
       <?php if(!isset($_GET['post']) || empty($_GET['post']) || postExists($_GET['post'])==false){ ?>
        $(document).ready(function () {
          $('.loader').show();
          $.post(ajaxRequestFile() + '?f=user&s=following_posts', {
          }, function (data) {
            $('.loader').hide();
            var data = JSON.parse(data);
            if (data.success == true) {
              $('#posts-container').html(data.html);
            } else if (data.success == false) {}
          })
        })
     <?php } ?>
      </script>