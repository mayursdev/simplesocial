 <?php if($so['logged_in']){ ?>
  <script>
    //  reminder with only js no server required
    function reminderExceeded(reminderAt){
    if(reminderAt > 0)
      return false;
    else
      return true;
   }
  <?php if(reminderInterval($so['user']['timer']) !=false){ ?>
    // checkReminder

   var reminderInterval= setInterval(reminderCheckInterval, 1000);

   function reminderCheckInterval(){

      var data = {};

      let reminderAt = getCookie('reminderAt')

      data.success = reminderExceeded(reminderAt)

      if (data.success == true && reminderAt!='false') {
        // show health reminder
        $('#Modal').modal('toggle')
        clearInterval(reminderInterval);

      } else if (data.success == false) {
        // console.log(reminderAt);
        let newReminderAt = parseInt(getCookie('reminderAt')) - 1
        // setCookie('reminderAt',newReminderAt,1)
        document.cookie = "reminderAt="+newReminderAt;

        if (getCookie('reminderInterval')=='false'){
          clearInterval(reminderInterval);
        }
      }

   }
<?php }?>

  $(document).ready(function(){
    notiCount();
    $('.list-wrapper span').html("<?php echo returnAdmin(); ?>");
  })
  setInterval(notiCount , 5000);
  function notiCount(){
    $.post(ajaxRequestFile() + '?f=user&s=get_noti_count', {}, function (data) {
      var data = JSON.parse(data);
      if (data.msgCount >0) {
        $('#message-count .noti-count').html(data.msgCount)
        $('#message-count .noti-count').removeClass('d-none')

      }else{
        $('#message-count .noti-count').addClass('d-none')
      }
       if (data.notiCount >0) {
        $('#notification-count .noti-count').html(data.notiCount)
        $('#notification-count .noti-count').removeClass('d-none')
      }else{
        $('#notification-count .noti-count').addClass('d-none')
      }
    })
  }

  // updateLastseen
  setInterval(() => {
    $.post(ajaxRequestFile() + '?f=user&s=update_lastseen', {}, function (data) {
      var data = JSON.parse(data);
      if (data.success == true) {
        // console.log('lastseen update successful..');

      } else if (data.success == false) {
        // console.log('lastseen update failed..');
      }
    })
  }, 10000);

  </script>

<?php } ?>