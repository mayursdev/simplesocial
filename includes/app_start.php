<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
$so = array();
$so['site_url']=$site_url;
$so['theme_url']=$theme_url;
$so['content']='';

// check if user logged in
$so['logged_in'] =false;
if(isLoggedIn()==true){
  // get userid by sessionid
  $session_id = (isset($_SESSION['session_id']) AND !empty($_SESSION['session_id']))?
  $_SESSION['session_id'] : $_COOKIE['session_id'];
  $user_id =getUserIdFromSessionId($session_id);
  $so['user'] = getUserData($user_id);
  $so['user']['session_id'] = $_SESSION['session_id']= $session_id;

  $so['logged_in'] =true;
}


// Icons Virables
$error_icon   = '<i class="fa fa-exclamation-circle"></i> ';
$success_icon = '<i class="fa fa-check"></i> ';

?>