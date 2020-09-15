<?php
  $data =[];
  $error ='';
  if(isset($_POST['email']) && isset($_POST['password'])){
    extract($_POST);
    if($email =='' || $password ==''){
      $error =$error_icon.'Details cannot not be empty!';
    }
    if($error !=''){
      $data['error']=$error;
      $data['success']=false;

    }else{
      $result = login($email,$password);
      if($result){
        // create and set session, cookie;
        $user_id = getUserIdFromUsername($email);
        $session = insertUserSessionId($user_id);
        $_SESSION['session_id'] = $session;
        setcookie('session_id',$session,time()+30*86400);


        $data['message']=$success_icon.'Welcome!';
        $data['success']=true;
        $data['location']=$site_url;
        setcookie("remainderAt", "", time() - 3600);
        setcookie("remainderInterval", "", time() - 3600);

      }else{
        $data['error']=$error_icon.'Incorrect email or password';
        $data['success']=false;

      }
    }

    echo json_encode($data);
  }

?>