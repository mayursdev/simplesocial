<?php
  if($f=='messages'){
    if($s=='get_chat_messages'){
      $data = [];
      extract($_POST);
      if(isset($friend_id) && !empty($friend_id)){
        $msg_history = getChatMessages($friend_id);
        if($msg_history!=false){
          $data['success'] = true;
          $data['message'] = $msg_history;
          //set message_status = 1
          messagesSeen($friend_id);

        }else{
          $data['success'] = true;
          $data['message'] = '<div class="alert alert-secondary p-4 h4">No Chats available currently</div>';
        }
      }else{
        $data['success'] = false;
        $data['error'] = 'friend id empty';
      }
      echo json_encode($data);
    }

    if($s=='send_message'){
      $data =[];
      extract($_POST);
      if(isset($friend_id)){
        $res = dbQuery('insert into messages (message_to,message_from,message) values(:friend_id,:self,:message)',[':friend_id'=>sanitized($friend_id),':self'=>$so['user']['user_id'],':message'=>sanitized($message)]);
        if($res['success']){
          $data['success'] = true;
          $so['user_message']['message'] = $message;
          $so['user_message']['message_at'] = date('Y-m-d h:i:s');
          $data['html'] = returnPageContents('message/outgoing-message-box');
        }else{
          $data['success'] = false;
          $data['error'] = 'error in sending message';
        }
      }else{
        $data['success'] = false;
        $data['error'] = 'friend id empty';
      }
      echo json_encode($data);
    }
    if($s=='get_recent_messages'){
      $data = [];
      extract($_POST);
      if(isset($friend_id) && !empty($friend_id)){
        $msg_history = getRecentMessages($friend_id);
        if($msg_history!=false){
          $data['success'] = true;
          $data['message'] = $msg_history;

          //set message_status = 1
          messagesSeen($friend_id);

        }
        else{
          $data['success'] = false;
          $data['message'] = 'All msgs seen';
        }
      }else{
        $data['success'] = false;
        $data['error'] = 'friend id empty';
      }
      echo json_encode($data);
    }
  }
?>