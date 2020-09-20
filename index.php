<?php
require_once('includes/init.php');

if($so['logged_in']){
  updateLastseen($so['user']['user_id']);
  $reminderInterval = reminderInterval($so['user']['timer']);
  if(!$reminderInterval){
    $reminderInterval = 'false';
  }
  setcookie('reminderInterval', $reminderInterval,0);
  $reminderAt = strtotime($reminderInterval);

  if(!isset($_COOKIE['reminderAt'])){

      if($reminderInterval!=false){
        setcookie('reminderAt', $reminderAt, 0);
        // setcookie('reminderSetAt', date('d m Y h:i:s'), time() + (86400 * 30));
        setcookie('reminderInterval', $reminderInterval,0);
      }

  }else{

  if(reminderExceeded($_COOKIE['reminderAt']) || ($reminderInterval != $_COOKIE['reminderInterval'])){
      setcookie('reminderAt', $reminderAt, 0);
      setcookie('reminderInterval', $reminderInterval, 0);


    }
  }
}

$page ='';
if(isset($_GET['page'])){
  $page = $_GET['page'];
}

$not_logged_in_pages = array('register','login');

if($so['logged_in'] && !isset($_GET['page'])){
   $page ='home';
}elseif($so['logged_in'] && isset($_GET['page'])){
  if(!in_array($page,$not_logged_in_pages)){
    $page = $page;
  }else $page ='home';
}
else{
  if(in_array($page,$not_logged_in_pages)){
    $page =$page;
  }else $page='login';
}

  switch ($page) {
    case 'home':
      include('sources/home.php');
      break;
    case 'timeline':
      include('sources/timeline.php');
      break;
    case 'settings':
      include('sources/settings.php');
      break;
    case 'login':
      include('sources/login.php');
      break;
    case 'register':
      include('sources/register.php');
      break;
    case 'message':
      include('sources/message.php');
      break;
    // default:
    //   echo 'not found';
    //   break;
  }

  if($so['content']==''){
    $so['content']=returnPageContents('404/content');
  }





echo returnPageContents('container');

?>