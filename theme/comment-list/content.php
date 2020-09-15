<li class='d-flex comment-item pb-2'>
  <div class="chat-user-avatar-container comment-item-left">
    <img src="<?php echo $so['site_url'].$so['comment']['commentBy']['profileImage']; ?>" alt="comment-by-profile-image">
  </div>
  <div class="comment-info d-flex flex-column comment-item-right">
    <div class='d-flex align-items-center'>
      <div class="comment-by mr-2"><a href="<?php echo $so['site_url']."/index.php?page=timeline&u=".$so['comment']['commentBy']['username']; ?>" class='h4'><?php echo $so['comment']['commentBy']['screenName']; ?></a></div>
      <div class="comment-at text-muted"><?php echo time_ago(strtotime($so['comment']['comment_at'])); ?></div>
    </div>
    <div class="comment-text h4">
      <p>
       <?php echo $so['comment']['comment_text']; ?>
      </p>
    </div>
  </div>
</li>
<style>
.comment-by a{
  font-size:1.4rem;
}
.comment-at {
  font-size:1.3rem;
}
.comment-text{
  font-size:1.6rem;
  font-weight:400
}
</style>