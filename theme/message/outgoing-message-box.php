<div class="outgoing_msg">
  <div class="sent_msg">
    <p><?php echo $so['user_message']['message']; ?></p>
    <span class="time_date"> <?php echo date("h:i A",strtotime($so['user_message']['message_at'])); ?></span>
  </div>
</div>