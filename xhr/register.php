<?php
$data  = [];
if(isset($_POST) AND !empty($_POST)){
  extract($_POST);
  if(empty($screenName)||empty($username)||empty($email)||empty($password)||empty($confirmPassword)||empty($gender)){
    $data['success'] = false;
    $data['error'] = $error_icon." Details cannot be empty!";
  }else{
    if($confirmPassword !== $password){
      $data['success'] = false;
      $data['error'] = $error_icon." Passwords do not match!";
    }else{
      if(!(strlen($password)>=5)){
        $data['success'] = false;
        $data['error'] = $error_icon." Password too short!";

      }else{
        if((strlen($username)<3)){
          $data['success'] = false;
          $data['error'] = $error_icon." Username too short!".strlen($username);
        }else{
        $usernameExists = getUserIdFromUsername($username);
        if($usernameExists){
          $data['success'] = false;
          $data['error'] = $error_icon." Username already exists!";

        }else{
          if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $data['success'] = false;
            $data['error'] = $error_icon." Invalid Email!";

          }else{
          $emailExists = emailExists($email);
          if(($emailExists)){
            $data['success'] = false;
            $data['error'] = $error_icon." Email already registered!";
          }else{
            $status = register($screenName,$username,$email,$password,$gender);
            if($status == true){
              //  send success message w/ location
              $data['success'] = true;
              $data['location'] = $so['site_url']."?page=login";
              $data['message'] = $success_icon." Registered Successfully! Login to continue..";
              setcookie("remainderAt", "", time() - 3600);
              setcookie("remainderInterval", "", time() - 3600);

           }else{
            //  send error message
            $data['success'] = false;
            $data['error'] = $error_icon." Failed..something went wrong!";


           }
          }
        }
        }}
      }


    }
  }


  echo json_encode($data);
}


?>