<?php
// delete session_id from db
$data =[];
if(delSessionId($so['user']['session_id'])){
unset($_SESSION['session_id']);
setcookie('session_id','',time()-60);


$data['success']=true;
$data['location']=$so['site_url'];


}else{
  $data['success']=true;
  $data['location']=$so['site_url'];
}
$data = json_encode($data);
echo $data;

?>