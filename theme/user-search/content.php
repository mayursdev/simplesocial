<?php $href = $so['site_url']."/index.php?page=timeline&u=".$so['search_user']['username']; ?>

    <li class="d-flex flex-row" onclick="$('.search-text').val('');location.href='<?php echo $href; ?>'">
      <div class="noti-avatar-container">
        <img src="<?php echo $so['site_url'].$so['search_user']['profileImage']; ?>" alt="">
      </div>
      <div class="right-part">
        <p class="noti-user-name h4">
          <a href="<?php echo $so['site_url'].'/index.php?page=timeline&u='.$so['search_user']['username']; ?>" class="text-dark"><?php echo $so['search_user']['screenName']; ?></a>
          <span class="noti-message text-muted h3"><small>@<?php echo $so['search_user']['username'] ; ?></small></span>
        </p>
      </div>
    </li>
