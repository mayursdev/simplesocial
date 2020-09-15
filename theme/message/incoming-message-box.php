<div class="incoming_msg">
  <div class="incoming_msg_img"> <img src="<?php echo "${so['site_url']}{$so['user_message']['profileImage'] }"; ?>" alt=""> </div>
  <div class="received_msg">
    <div class="received_withd_msg">
      <p>
        <?php echo $so['user_message']['message']; ?>
      </p>
      <span class="time_date"> <?php echo date("h:i A",strtotime($so['user_message']['message_at'])); ?></span>
    </div>
  </div>
</div>