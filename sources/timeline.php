<?php
// index.php?page=timeline&type=friends&u=mayur

// whose profile?
if(isset($_GET['u']) && !empty($_GET['u'])){
  $u = $_GET['u'];
  $user_id = getUserIdFromUsername($u);
  if(!is_null($user_id)){
    $so['user_profile'] = getUserData($user_id);
  }
}else{
  header('Location: '.$so['site_url']);
  // exit();
}

$so['page']='timeline';
$so['content']=returnPageContents('timeline/content');

?>