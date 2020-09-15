<li onclick="location.href='<?php echo $so['site_url'].'/index.php?page=message&u='.$so['noti_user']['username']; ?>'" class='d-flex flex-row'>
  <div class="noti-avatar-container">
    <img src="<?php echo $so['site_url'].$so['noti_user']['profileImage']; ?> " alt="">
  </div>
  <div class="right-part">
    <p class='noti-user-name h4'>
      <a href="#" class='text-dark'> <?php echo $so['noti_user']['screenName']; ?></a>
      <span class='noti-message text-muted h3'><small>messaged you</small></span>
    </p>
  </div>
</li>