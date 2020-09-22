<?php
// general functionalities

function returnPageContents($file_name){
  global $so;
  ob_start();
  include('./theme/'.$file_name.'.php');
  $contents = ob_get_clean();
  return $contents;
}

function returnNow(){
  return date("Y-m-d H:i:s",time());
}
function sanitized($string){
  $string = trim($string);
  $string = htmlspecialchars($string, ENT_QUOTES);
  $string = filter_var($string, FILTER_SANITIZE_STRING);
  return $string;
}

function uploadImage($file,$folderPath){
  $data = [];
  $fileFullName = ($file['name']);
  $fileName = pathinfo($fileFullName, PATHINFO_FILENAME);
  $fileExt = pathinfo($fileFullName, PATHINFO_EXTENSION);
  $uploadPath = $folderPath."/".$fileName.time().".".$fileExt;
  $fileSize = $file['size'];
  $fileTmp = $file['tmp_name'];
  $allowed_ext = ['jpg','png','jpeg'];
  if(in_array($fileExt,$allowed_ext)){
    if($fileSize<=4000000){
      $uploadFileStatus = move_uploaded_file($fileTmp,$uploadPath);
      if($uploadFileStatus == true){
        $data['success'] = true;
        $data['path']="/".$uploadPath;
      }
      else{
        $data['success'] = false;
        $data['error']=' Some error while uploading file!';
      }
    }else{
      $data['success'] = false;
      $data['error'] = ' File size is too large!';
    }
  }else{
    $data['success'] = false;
    $data['error'] = ' Invalid file type!';
  }
  return $data;

}

function time_ago($timestamp){
  $secondsDiff = time() - $timestamp;
  $seconds = round($secondsDiff);
  $minutes = round($secondsDiff/(60));
  $hours = round($secondsDiff/(60*60));
  // $days = $secondsDiff/(60*60*24);
  $months = $secondsDiff/(2600640);
  if($seconds<60){
    if($seconds < 5) return 'Just Now';
    return $seconds."s ago";
  }elseif($minutes<(60)){
    return $minutes."m ago";
  }elseif($hours<(24)){
    return $hours."h ago";
  }elseif($months<(12)){
    return date('M j',$timestamp);
  }else{
    return date('j M Y',$timestamp);
  }
}

function reminderInterval($timer){//timer = $so['user']['timer'];
  if($timer=='disable'){
    return false;
  }elseif($timer =='one'){
    return '+1 Minute';
  }elseif($timer == 'twenty'){
    return '+20 Minutes';
  }elseif($timer == 'thirty'){
    return '+30 Minutes';
  }
}

function reminderExceeded($reminderAt){
  if(time()<=$reminderAt){
    return false;
  }else{
    return true;
  }
}

// online ot offline
function lastseenStatus($time){

  if($time>=time()-10){
    // online
    return '<span class="last-seen text-success">online</span>';

  }else{
    //offline
   return '<span class="last-seen text-muted">'.time_ago($time).'</span>';
  }
}
?>