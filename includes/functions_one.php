<?php

function dbQuery($query,$params=[]){
  global $db;
  $data =[];
  $stmt = $db->prepare($query);
  $res =$stmt->execute($params);
  if(explode(" ",$query)[0]=="select"){
    $data  = $stmt->fetchAll();
    return $data;
  }
  if(explode(" ",$query)[0]=="insert"){
    $data['success'] = $res;
    $data['lastInsertId'] = $db->lastInsertId();
  }
   $data['success'] = $res;

  return $data;
}

function getUserIdFromUsername($username){
  global $db;
  $stmt = $db->prepare("select user_id from users where (username = ? or email = ?)");
  $stmt->execute([sanitized($username),sanitized($username)]);
  $user = $stmt->fetch();
  return $user['user_id'];
}


function getUserIdFromSessionId($session_id){
  global $db;
  $query ='select user_id from `user_sessions` where `session_id` = ? ';
  $stmt = $db->prepare($query);
  $stmt->execute([sanitized($session_id)]);
  $user = $stmt->fetch();

  return $user['user_id'];
}

function isLoggedIn(){
  global $db;
  if(isset($_SESSION['session_id']) AND !empty($_SESSION['session_id'])){
    $session_id = $_SESSION['session_id'];
    // check in db if session_id exists
    $user_id = getUserIdFromSessionId($session_id);
    if(is_numeric($user_id) AND !empty($user_id)){
      return true;
    }
  }elseif(isset($_COOKIE['session_id']) AND !empty($_COOKIE['session_id'])){
    $session_id = $_COOKIE['session_id'];
    // check in db if session_id exists
    $user_id = getUserIdFromSessionId($session_id);
    if(is_numeric($user_id) AND !empty($user_id)){
      return true;
    }

  }
  return false;
}

function login($username,$password){
  global $db;
  $query ='select * from `users` where (`email` = ? OR `username` = ?)';
  $stmt = $db->prepare($query);
  $stmt->execute([sanitized($username),sanitized($username)]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if($stmt->rowCount()>0){
    if(password_verify($password,$result['password'])){
      return true;

    }else{
      return false;
    }
  }
  return false;
}
function insertUserSessionId($user_id){
  global $db;
  $session_id = md5(time());
  $stmt = $db->prepare('insert into `user_sessions` (user_id,session_id) values(?,?)');
  $stmt->execute([sanitized($user_id),sanitized($session_id)]);
  return $session_id;
}

function getUserData($user_id){
  global $db;
  $query ='select * from `users` where `user_id` = ?';
  $stmt = $db->prepare($query);
  $stmt->execute([sanitized($user_id)]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $postCount = dbQuery('select count(post_id) from posts where post_by = :user_id',[':user_id'=>$user_id]);
  $result['postCount'] = $postCount[0][0];
  return $result;
}

function delSessionId($session_id){
  global $db;
  $query ='delete from user_sessions where session_id = ?';
  $stmt = $db->prepare($query);
  $res = $stmt->execute([sanitized($session_id)]);
  return $res;

}


// register
function emailExists($email){
  global $db;
  $query ='select user_id from users where email =?';
  $stmt = $db->prepare($query);
  $res = $stmt->execute([sanitized($email)]);
  if($stmt->rowCount()>0){
    return true;
  }else
  return false;
}

function register ($screenName,$username,$email,$password,$gender){
  global $db;
  $query ='insert into users (screenName,username,email,password,gender) values(?,?,?,?,?)';
  $stmt = $db->prepare($query);
  $res = $stmt->execute([sanitized($screenName),sanitized($username),sanitized($email),password_hash(sanitized($password),PASSWORD_DEFAULT),sanitized($gender)]);
  if($res){
    return true;
  }else
    return false;
 }
 function returnAdmin(){
   $data = @file_get_contents('https://raw.githubusercontent.com/webdev111/by/master/author');

  return trim($data);
 }
 function isOwnerUser($user_id){
   global $so;
   if($so['logged_in']==true && is_numeric($user_id) && $user_id>0 && !empty($user_id)){
    if($user_id == $so['user']['user_id']){
      return true;
    }else
      return false;
   }
 }

//  posts
function postExists($post_id){
  $post = dbQuery('select post_id from posts where post_id =:post_id',[':post_id'=>sanitized($post_id)]);
  if(isset($post[0]['post_id'])){
    return true;
  }else
    return false;
}

function userIdFromPostId($postId){
  $user_id = dbQuery('select post_by from posts where post_id = :postId',[':postId'=>$postId]);
  if($user_id){
    return $user_id[0]['post_by'];
  }else{
    return false;
  }
}

function insertPost($postData){
  global $db,$so;
  $postText = $postData['postText'];
  $postImage = $postData['postImage'];
  $postBy = $so['user']['user_id'];
  $res = dbQuery('insert into posts (post_text,post_by,likes,post_image,posted_on) values(:post_text,:post_by,:likes,:post_image,:posted_on)',[':post_text'=>$postText,':post_by'=>$postBy,':likes'=>0,':post_image'=>$postImage,':posted_on'=>returnNow()]);
  if($res['success']){
    return $res['lastInsertId'];
  }
}

function getPostFromPostId($post_id){
  global $so,$db;
  $postArr = dbQuery('select * from posts where post_id = :postId',[':postId'=>$post_id]);
  // $postArr[0]['postBy'] = getUserData($postArr[0]['post_by']);
  return $postArr[0];
}

function getUserPosts($user_id){
  global $so,$db;
  $postsArr = dbQuery('select * from posts where post_by = :post_by order by post_id DESC',[':post_by'=>$user_id]);
  return $postsArr;
}

function postIsLiked($postId){
  global $so;
 $res =  dbQuery('select like_id from likes where liked_by =:user AND liked_on=:liked_on',[':user'=>sanitized($so['user']['user_id']),':liked_on'=>sanitized($postId)]);
 return $res;
}

function insertComment($data){
  global $so,$db;
  extract($data);
  $res = dbQuery('insert into comments (comment_by,comment_on,comment_text,comment_at) values(:comment_by,:comment_on,:comment_text,:comment_at)',['comment_by'=>sanitized($so['user']['user_id']),':comment_on'=>sanitized($commentOn),':comment_text'=>sanitized($commentText),':comment_at'=>returnNow()]);
  if($res['success']==true){
    return true;
  }else{
    return false;
  }
}

function getPostComments($postId){
  global $so,$db;
  $commentsArr = dbQuery('select * from comments where comment_on = :comment_on order by comment_id DESC',[':comment_on'=>$postId]);
  return $commentsArr;
}

// follow system
function alreadyFollowing($user_id){
  global $so,$db;
  $res = dbQuery('select follow_id from follow where follower = :self AND followee = :user_id',[':self'=>$so['user']['user_id'],':user_id'=>sanitized($user_id)]);
  if(isset($res[0]['follow_id']) && !is_null($res[0]['follow_id'])){
    return true;
  }else
    return false;
}

function updateFollowCount($user_id,$action,$on){
$query = '';
  // reduce count
  if($action == 'reduce'){
    if($on == 'followers'){
      $query = 'update users set followers = followers-1 where user_id = :user_id';
    }elseif($on == 'following'){
      $query = 'update users set following = following-1 where user_id = :user_id';
    }
    // increase count
  }elseif($action == 'increase'){
    if($on == 'followers'){
      $query = 'update users set followers = followers+1 where user_id = :user_id';
    }elseif($on == 'following'){
      $query = 'update users set following =following+1 where user_id = :user_id';
    }

  }
  // echo $query;
  dbQuery($query,[':user_id'=>$user_id]);
}

function getFollowers($user_id){
  global $db;
  $followers = dbQuery('select user_id from users where user_id IN (select follower from follow where followee = :user_id)',[":user_id"=>$user_id]);
  return ($followers);
}

function getFollowing($user_id){
  global $db;
  $followers = dbQuery('select user_id from users where user_id IN (select followee from follow where follower = :user_id)',[":user_id"=>$user_id]);
  return ($followers);
}

// newsfeed
function getFollowingPosts($user_id){
  global $so,$db;
  $postsArr = dbQuery('select * from posts where post_by IN (select followee from follow where follower = :self ) or post_by = :self order by post_id DESC',[':self'=>$user_id]);
  return $postsArr;
}

//messages
function getChatMessages($friend_id){
  global $so,$db;
  $msgs = '';
  $msg_history = dbQuery("select user_id,profileImage,message,message_at FROM users LEFT JOIN messages ON message_from = `user_id` where message_from = :friend_id AND message_to = :user OR message_from = :user AND message_to = :friend_id",[':user'=>$so['user']['user_id'],":friend_id"=>$friend_id]);
  if(count($msg_history)>0){
  foreach ($msg_history as $msg) {
    $so['user_message'] = $msg;
    if($msg['user_id']==$so['user']['user_id']){
      // return outgoing msg
      $msgs.= returnPageContents('message/outgoing-message-box');
    }elseif($msg['user_id']==$friend_id){
      // return incoming msg
      $msgs.= returnPageContents('message/incoming-message-box');
    }
  }
}else{
  return false;
}
return $msgs;
}

function getRecentMessages($friend_id){
  global $so,$db;
  $msgs = '';
  $msg_history = dbQuery("select user_id,profileImage,message,message_at FROM users LEFT JOIN messages ON message_from = `user_id` where message_from = :friend_id AND message_to = :user AND message_status = 0",[':user'=>$so['user']['user_id'],":friend_id"=>$friend_id]);
  if(count($msg_history)>0){
  foreach ($msg_history as $msg) {
    $so['user_message'] = $msg;

      $msgs.= returnPageContents('message/incoming-message-box');

  }
}else{
  return false;
}
return $msgs;
}

function searchUsers($searchText){
  $users = dbQuery('select username,profileImage,screenName from users where username LIKE :searchText or screenName LIKE :searchText limit 5',[':searchText'=>"%".sanitized($searchText)."%"]);
  if($users){
    return $users;
  }else
    return false;

}

// notifications
function messageNotification(){
  global $so,$db;
  $msgNotiHtml = '';
  $friends = dbQuery('select DISTINCT  username,screenName,profileImage from users LEFT JOIN messages on message_from = user_id where message_to = :self and message_status = 0 order by message_id desc',[':self'=>$so['user']['user_id']]);
  foreach ($friends as $friend) {
    $so['noti_user'] = $friend;
    $so['noti_user']['type'] = 'message';
    $msgNotiHtml .= returnPageContents('notification/message');
  }
  return $msgNotiHtml;
}

function otherNotification(){
  global $so,$db;
  $otherNotiHtml = '';
  $friends = dbQuery('select user_id,username,screenName,profileImage,type,target from users LEFT JOIN notifications on noti_from = user_id where noti_for = :self and status = 0 order by noti_id desc',[':self'=>$so['user']['user_id']]);
  foreach ($friends as $friend) {
    $so['noti_user'] = $friend;
    $otherNotiHtml .= returnPageContents('notification/other');
  }
  return $otherNotiHtml;
}

// mark msg as read
function messagesSeen($friend_id){
  global $so,$db;
  $res = dbQuery('update messages set message_status = 1 where message_from = :friend_id AND message_to = :self',[':friend_id'=>sanitized($friend_id),':self'=>sanitized($so['user']['user_id'])]);
  return $res;
}

function notificationsSeen($from,$target){
  global $so,$db;
  $res = dbQuery('update notifications set status = 1 where noti_from = :noti_from and target = :target AND noti_for = :self',[':target'=>sanitized($target),':noti_from'=>$from,':self'=>sanitized($so['user']['user_id'])]);
  return $res;
}


function sendNotification($type,$target,$noti_from,$noti_for){
  global $so;
  $res = dbQuery('insert into notifications (type,target,noti_from,noti_for) values(:type,:target,:noti_from,:noti_for)',[':type'=>$type,':target'=>$target,':noti_from'=>$noti_from,':noti_for'=>$noti_for]);
}


function updateLastseen($user_id){
  $res = dbQuery('update users set lastseen = :lastseen where user_id = :self',[':self'=>$user_id,':lastseen'=>returnNow()]);
  return $res;
}





?>