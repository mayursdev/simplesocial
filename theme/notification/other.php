<?php
$href = '';
$what = '';
$type = $so['noti_user']['type'];
if($type=='follow'){
  $href = $so['site_url'].'/index.php?page=timeline&u='.$so['noti_user']['username'];
  $what = 'started following you';
}elseif($type=='like'){
  $href = $so['site_url'].'/index.php?post='.$so['noti_user']['target'];
  $what = 'liked your post';
}elseif($type=='comment'){
  $href = $so['site_url'].'/index.php?post='.$so['noti_user']['target'];
  $what = 'commented your post';

}
?>

<li onclick="notiSeen(<?php echo $so['noti_user']['target'].','.$so['noti_user']['user_id'] ;?>);location.href='<?php echo $href; ?>'" class='d-flex flex-row'>
  <div class="noti-avatar-container">
    <img src="<?php echo $so['site_url'].$so['noti_user']['profileImage']; ?> " alt="">
  </div>
  <div class="right-part">
    <p class='noti-user-name h4'>
      <a href="#" class='text-dark'> <?php echo $so['noti_user']['screenName']; ?></a>
      <span class='noti-message text-muted h3'><small><?php echo $what; ?></small></span>
    </p>
  </div>
</li>