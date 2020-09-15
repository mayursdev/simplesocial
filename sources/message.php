<?php
// index.php?page=messsage&u=rutika

// whose profile?
if(isset($_GET['u']) && !empty($_GET['u'])){
  $u = $_GET['u'];
  $user_id = getUserIdFromUsername($u);
  if(!is_null($user_id)){
    $so['user_to_message'] = getUserData($user_id);
  }else{
    header('Location: '.$so['site_url']);

  }
}else{
  header('Location: '.$so['site_url']);
  // exit();
}

$so['page']='timeline';
$so['content']=returnPageContents('message/content');

?>