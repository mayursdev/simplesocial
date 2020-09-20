<?php
if($f == 'user'){
  if($s=='update_lastseen'){
    $data = [];
    $res = updateLastseen($so['user']['user_id']);
    if($res==true){
      $data['success'] = true;
    }else
      $data['success']= false;
    echo json_encode($data);
  }
  // update user avatar
  if($s=='update_user_avatar'){
    $data =[];
    $dp ='';
    $cover='';
    if(!empty($_FILES['dp']['name']) || !empty($_FILES['cover']['name'])){
      if(!empty($_FILES['dp']['name'])){
        $dpUpload = uploadImage($_FILES['dp'],'uploads/users/dp');
        if($dpUpload['success']==false){
          $data['success'] = false;
          $data['error'] = $error_icon.$dpUpload['error'];
        }else{
          $dp = $dpUpload['path'];
        }
      }
      if(!empty($_FILES['cover']['name'])){
        $coverUpload = uploadImage($_FILES['cover'],'uploads/users/covers');
        if($coverUpload['success']==false){
          $data['success'] = false;
          $data['error'] = $error_icon.$coverUpload['error'];
        }else{
          $cover = $coverUpload['path'];
        }
      }
      if($dp!=''){
        $prevDp = substr($so['user']['profileImage'],1);
        $res = dbQuery('update users set profileImage = :dp where user_id =:user_id',[':dp'=>$dp,':user_id'=>$so['user']['user_id']]);
        if($res == true){
          if(explode('/',$prevDp)[0]!='theme'){
            unlink($prevDp);
          }
          $data['success'] = true;
          $data['message'] = $success_icon.' Settings Update Successful';
        }else{
          $data['success'] = false;
          $data['error'] = $error_icon.' Some Error Occured..';

        }
      }
      if($cover!=''){
        $prevCover = substr($so['user']['profileCover'],1);
        $res = dbQuery('update users set profileCover = :cover where user_id =:user_id',[':cover'=>$cover,':user_id'=>$so['user']['user_id']]);
        if($res == true){
          if(explode('/',$prevCover)[0]!='theme'){
            unlink($prevCover);
          }
          $data['success'] = true;
          $data['message'] = $success_icon.' Settings Update Successful';
        }else{
          $data['success'] = false;
          $data['error'] = $error_icon.'Some Error Occured..';

        }
      }
    }else{
      $data['success'] = false;
      $data['error'] = $error_icon.' Please select some image..';

    }
    echo json_encode($data);
    exit();

  }
  if($s=='update_profile'){
    $data = [];
    if(isset($_POST)){
      extract($_POST);
    }
    if(isset($fullName)&& !empty($fullName)){
      if(strlen($fullName)>=3){
        $res = dbQuery('update users set screenName = :fullName, about = :about, birthday = :birthday, timer = :timer where user_id = :id',[':fullName'=>sanitized($fullName),':about'=>sanitized($about),':birthday'=>sanitized($birthday),':id'=>$so['user']['user_id'],':timer'=>$timer]);
        // check if user updated reminder interval
        $reminderInterval = reminderInterval($timer);
        if($_COOKIE['reminderInterval']!=$reminderInterval){
          if($reminderInterval!=false){
            $reminderAt = strtotime($reminderInterval);
            setcookie('reminderAt', $reminderAt, 0);
            setcookie('reminderInterval', $reminderInterval,0);

          }else{
            setcookie('reminderInterval', 'false',0);

          }
        }

        if($res){
          $data['success']=true;
          $data['message']=$success_icon.' Settings Update Succesful!';
        }else{
          $data['success']=false;
          $data['error']=$error_icon.' Some error occured!';
        }
      }else{
        $data['success'] = false;
        $data['error'] = $error_icon.' Full Name too short!';
      }
    }else{
      $data['success'] = false;
      $data['error'] = $error_icon.' Full Name is required!';
    }
    echo json_encode($data);
  exit();

  }


  if($s=='update_password'){
    if(isset($_POST)){
      extract($_POST);
    }
    $data = [];
    if(isset($currentPass)&& !empty($currentPass) && isset($newPass) && !empty($newPass) && isset($confirmPass)&& !empty($confirmPass)){
      if(password_verify($currentPass,$so['user']['password'])){
        if($newPass == $confirmPass){
        if(strlen($newPass)>=5){
        $res = dbQuery('update users set password = :password where user_id = :user_id',[':password'=>password_hash(sanitized($newPass),PASSWORD_DEFAULT),':user_id'=>sanitized($so['user']['user_id'])]);
        if($res){
          $data['success']=true;
          $data['message']=$success_icon.' Settings Update Succesful!';
        }else{
          $data['success']=false;
          $data['error']=$error_icon.' Some error occured!';
        }
      }else{
        $data['success']=false;
        $data['error']=$error_icon.' New password too short!';

      }
      }else{
        $data['success']=false;
        $data['error']=$error_icon.' Password Mismatch!';
      }
      }else{
        $data['success'] = false;
        $data['error'] = $error_icon.' Current password incorrect!';
      }
    }else{
      $data['success'] = false;
      $data['error'] = $error_icon.' All details are necessary!';
    }

    echo json_encode($data);
    exit();
  }
  if($s =='follow_user'){
    extract($_POST);
    $data = [];
    if(isset($userId)){
      if(alreadyFollowing($userId)){
        // if already following unfollow and return follow btn
        $res = dbQuery('delete from follow where follower = :self and followee = :userId',[':self'=>$so['user']['user_id'],':userId'=>$userId]);
        if($res){

          updateFollowCount($userId,'reduce','followers');
          updateFollowCount($so['user']['user_id'],'reduce','following');

          $data['success']= true;
          $data['html'] = '<button class="send-request btn btn-primary" onclick="followUser('.$userId.')">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="8.5" cy="7" r="4"></circle>
            <line x1="20" y1="8" x2="20" y2="14"></line>
            <line x1="23" y1="11" x2="17" y2="11"></line>
            </svg>
            <span class="h4">Follow</span>
            </button>';
          }else{
            $data['success']= false;
            $data['error'] = "some error occured in unfollowing";

        }

      }else{
        // if not following follow and return unfollow btn
        $res = dbQuery('insert into follow (follower,followee) values(:self,:userId)',[':self'=>$so['user']['user_id'],':userId'=>$userId]);
        if($res){
          updateFollowCount($userId,'increase','followers');
          updateFollowCount($so['user']['user_id'],'increase','following');
          sendNotification('follow',$so['user']['user_id'],$so['user']['user_id'],$userId);

          $data['success'] = true;
          $data['html'] = '<button class="send-request btn btn-success" onclick="followUser('.$userId.')">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="8.5" cy="7" r="4"></circle>
            <polyline points="17 11 19 13 23 9"></polyline>
          </svg>
          <span class="h4">Following</span>
        </button>';
        }else{
          $data['success']= false;
          $data['error'] = 'some error occured in following';
        }
      }
    }else{
      $data['success'] = false;
      $data['error'] = 'userId empty';
    }
    echo json_encode($data);
    exit();
  }

  if($s=='get_noti_count'){
    $data = [];
   $msgCount= dbQuery('select count(message_id) from messages where message_to = :self and message_status = 0',[':self'=>$so['user']['user_id']])[0];
    $notiCount = dbQuery('select count(noti_id) from notifications where noti_for = :self and status = 0',[':self'=>$so['user']['user_id']])[0];
    $data['msgCount'] = $msgCount[0];
    $data['notiCount'] = $notiCount[0];
    echo json_encode($data);


  }

  if($s=='message_notification'){
    $data = [];
    $msgNotiHtml = messageNotification();
    if($msgNotiHtml!=''){
      $data['success'] = true;
      $data['html'] = $msgNotiHtml;
    }else{
      $data['success'] = true;
      $data['html'] = "<li class='h4 text-center text-muted'>You do not have any messages</li>";

    }
    echo json_encode($data);


  }
  if($s=='other_notification'){
    $data = [];
    $otherNotiHtml = otherNotification();
    if($otherNotiHtml!=''){
      $data['success'] = true;
      $data['html'] = $otherNotiHtml;

    }else{
      $data['success'] = true;
      $data['html'] = "<li class='h4 text-center text-muted'>You do not have any notifications</li>";

    }
    echo json_encode($data);

  }if($s=='noti_seen'){
    $data = [];
    extract($_POST);
    $res = notificationsSeen($from,$target);
    if($res){
      $data['success']=true;
    }else{
      $data['success']=false;

    }
  }
  if($s=='check_reminder'){
    $data = [];
    if(isset($_COOKIE['reminderAt'])){
    $reminderAt = $_COOKIE['reminderAt'];
    $reminderExceeded = reminderExceeded($reminderAt);
    if($reminderExceeded){
      $data['success']=true;

    }else{
      $data['success']=false;
      $reminderInterval = reminderInterval($so['user']['timer']);

      if($_COOKIE['reminderInterval']!=$reminderInterval){
        if($reminderInterval!=false){
          $reminderAt = strtotime($reminderInterval);
          setcookie('reminderAt', $reminderAt, 0);
          setcookie('reminderInterval', $reminderInterval,0);

        }else{
          $data['message']='remainderDisabled';

        }

      }
    }
  }
    $data['remaining'] = $_COOKIE['reminderAt'] - time();
    echo json_encode($data);
  }

  if($s=='search_users'){
    $data = [];
    $html = '';
    $html.= '<div class="search-results"><ul class="noti-list d-flex flex-column list-unstyled ">';
    extract($_POST);
    if(isset($searchText) && !empty($searchText)){

      $res = searchUsers($searchText);
      if($res){
        if(count($res)>0){
          foreach ($res as $user) {
            $so['search_user'] = $user;
            $html .= returnPageContents('user-search/content');
            $data['success'] = true;
          }
        }else{
          $data['success']=false;
          $data['error'] = 'no users found';
        }


      }else{
        $data['success']=false;
        $data['error'] = 'some error occured';

      }

    }else{
      $data['success'] = false;
      $so[] .= 'search text empty';
    }
    $html .= '</ul></div>';
    $data['html'] = $html;
    echo json_encode($data);
  }
  if($s=='following_posts'){
    $data = [];
    $html='';
      $followingPosts = getFollowingPosts($so['user']['user_id']);
      if(count($followingPosts)>0){
      foreach ($followingPosts as $so['post']) {
        $so['post']['postBy'] = getUserData($so['post']['post_by']);
        $html.= returnPageContents('post-layout/content');
      }
    }else{
      $html .='<div class="alert alert-light text-dark box-shadow h3 p-5">No Posts..';
      if($so['user']['following']==0){
        $html .='<br>Start Following someone to see their posts..';
      }
      $html .='</div>';

    }
    $data['success'] = true;
    $data['html']=$html;
    echo json_encode($data);
  }








}//$f =user end

?>