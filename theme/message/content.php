<?php
  echo returnPageContents('left-sidebar/content');
// echo time_ago(strtotime(date('Y-m-d h:i:s')));
?>
<!-- message container start -->
<div class="col-sm-8 mt-4">
  <div class="container bg-white pr-0">
    <div class="chat-user-data d-flex flex-row p-3">
      <div class="user-img mr-3"><img src="<?php echo "${so['site_url']}{$so['user_to_message']['profileImage'] }"; ?>"
          alt=""></div>
      <div class="d-flex flex-column">
        <a class='' href="<?php echo "${so['site_url']}/index.php?page=timeline&u={$so['user_to_message']['username'] }"; ?>"><h4><?php echo $so['user_to_message']['screenName']; ?></h4></a>
        <p class='last-seen h5'><?php echo lastseenStatus(strtotime($so['user_to_message']['lastseen']));
 ?></p>
      </div>
    </div>
    <div class="messaging">
      <div class="inbox_msg">
        <div class="mesgs">
          <div class="msg_history pr-3">
            <!-- all msgs dumped here -->
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" class="write_msg" onkeyup="sendMessage(this,<?php echo $so['user_to_message']['user_id']; ?>,event )" placeholder="Type a message">
              <button class="msg_send_btn" type="button">Send</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- message container end -->
<script>
$( document ).ready(function() {
  $('.loader').show();
  $.post(ajaxRequestFile() + '?f=messages&s=get_chat_messages', {
    friend_id : <?php echo $so['user_to_message']['user_id']; ?>
  }, function (data) {
    $('.loader').hide();
    var data = JSON.parse(data);
    if (data.success == true) {
      $('.msg_history').html(data.message);
      $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
      // console.log(data);

    } else if (data.success == false) {
      console.log(data);
    }
  })
});

// fetch Recent Messages
setInterval(()=>{
  var friendId = <?php echo $so['user_to_message']['user_id']; ?>;
  $.post(ajaxRequestFile() + '?f=messages&s=get_recent_messages', {
  friend_id : friendId
}, function (data) {
  $('.loader').hide();
  var data = JSON.parse(data);
  if (data.success == true) {
    $(".alert").hide();
    $('.msg_history').append(data.message);
    $(".msg_history").animate({
        scrollTop: $('.msg_history')[0].scrollHeight
      }, 1000);

  } else if (data.success == false) {
    // console.log('all msgs seen')
  }
})
},2000);

</script>