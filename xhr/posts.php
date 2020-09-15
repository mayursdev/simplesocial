<?php
if($f=='posts'){

  // insert new post
  if($s=='insert'){
    $data  =[];
    $postData = [];
    $postText = '';
    $postImage = '';
    $postImageUpload = [];

    $postTemplate = '';

    if(empty($_POST['postText']) && empty($_FILES['postImage']['name'])){
      $data['success'] = false;
      $data['error'] = $error_icon.' Post cannot be empty!';
    }else{
      if(!empty($_POST['postText'])){
        $postText = sanitized($_POST['postText']);
      }
      if(isset($_FILES['postImage']) && !empty($_FILES['postImage']['name'])){
        $postImageUpload = uploadImage($_FILES['postImage'],'uploads/posts');

      }
      // echo ($postImage);
      if(isset($postImageUpload['success']) && $postImageUpload['success']==false){
        $data['success'] = false;
        $data['error'] = $error_icon.$postImageUpload['error'];
      }else{
        if(isset($postImageUpload['success']) && $postImageUpload['success']==true){
          $postImage = $postImageUpload['path'];
        }
        $postData = ['postText'=>$postText,'postImage'=>$postImage];
        // insert post and return post id of inserted
        $insertedPostId = insertPost($postData);
        if(is_numeric($insertedPostId) && !is_null($insertedPostId)){
          $so['post'] = getPostFromPostId($insertedPostId);
          $so['post']['postBy'] = getUserData($so['post']['post_by']);
          $postTemplate = returnPageContents('post-layout/content');

          $data['success'] = true;
          $data['post'] = $postTemplate;
        }else{
          $data['success'] = false;
          $data['error'] = 'Problem in post addtion..';
        }
      }
    }

    echo json_encode($data);
    exit();


  } elseif ($s =='like_post'){
    $data =[];
    extract($_POST);
    if(isset($postId)){
      $data['postId'] = $postId;
      $postExists = dbQuery('select post_id from posts where post_id =:post_id',[':post_id'=>sanitized($postId)]);
      if(isset($postExists[0]['post_id'])){
      $liked = postIsLiked($postId);
    //   // not liked
      if(!isset($liked[0]['like_id'])){
      $res = dbQuery('insert into likes (liked_on,liked_by) values (:liked_on,:liked_by)',[':liked_on'=>sanitized($postId),':liked_by'=>sanitized($so['user']['user_id'])]);
      if($res){
        $res = dbQuery('update posts set likes = likes+1 where post_id = :postId',[':postId'=>sanitized($postId)]);
        if($res){
          $data['success'] = true;
          $data['message'] = 'liked';
          $noti_for = userIdFromPostId($postId);
          if($noti_for!=false && $noti_for!=$so['user']['user_id']){
            sendNotification('like',$postId,$so['user']['user_id'],$noti_for);
          }
        }else{
          $data['success'] = false;
        }
      }else{
        $data['success'] = false;

      }
      // already liked
    }elseif(isset($liked[0]['like_id']) && $liked[0]['like_id']!=null){
      $res = dbQuery('delete from likes where liked_on = :liked_on AND liked_by = :liked_by',[':liked_on'=>sanitized($postId),':liked_by'=>sanitized($so['user']['user_id'])]);
      if($res){
        $res = dbQuery('update posts set likes = likes-1 where post_id = :postId',[':postId'=>sanitized($postId)]);
        if($res){
          $data['success'] = true;
          $data['message'] = 'unliked';
        }else{
          $data['success'] = false;
        }
      }else{
        $data['success'] = false;

      }
    }

}else{
  $data['success'] = false;
  $data['error'] = 'Post Does not Exist!';
}
}else{
  $data['success'] = false;
  $data['error'] = ' Post Id is Empty!';
}
    echo json_encode($data);
    exit();


}elseif($s=='post_comment'){
    extract($_POST);
    $data=[];
    if(isset($commentText) && isset($commentOn)){
      $postExists = dbQuery('select post_id from posts where post_id =:post_id',[':post_id'=>sanitized($commentOn)]);
      if(isset($postExists[0]['post_id'])){
        $commentData = ['commentOn'=>$commentOn,'commentText'=>$commentText];
        $commentStatus = insertComment($commentData);
        if($commentStatus){
          $so['comment']['comment_text'] = $commentText;
          $so['comment']['comment_on'] = $commentOn;
          $so['comment']['comment_at'] = date('m/d/Y h:i:sa', time());
          $so['comment']['commentBy'] = getUserData($so['user']['user_id']);
          $comment = returnPageContents('comment-list/content');

          $data['success'] = true;
          $data['comment'] = $comment;
          $noti_for = userIdFromPostId($commentOn);

          if($noti_for!=false && $noti_for!=$so['user']['user_id']){
            sendNotification('comment',$commentOn,$so['user']['user_id'],$noti_for);
          }

        }else{
          $data['success'] = false;
          $data['error'] = 'Some error in adding comment';

        }

    }else{

      $data['success'] = false;
      $data['message']  = 'Post Does not exist';
    }
    }else{
      $data['success'] = false;
      $data['message']  = 'Comment Empty';
    }
    echo json_encode($data);
    exit();


  }elseif($s=="delete_post"){
    $data = [];
    extract($_POST);
    if(isset($_POST['postId'])){
      $postExists = dbQuery('select post_id from posts where post_id =:post_id',[':post_id'=>sanitized($postId)]);
    if(isset($postExists[0]['post_id'])){
      $postToDel = dbQuery('select post_image from posts where post_id = :post_id',[':post_id'=>sanitized($postId)]);
      $post_image = $postToDel[0]['post_image'];
      if(isset($post_image) && !empty($post_image)){
        unlink(substr($post_image,1));
      }
      $res = dbQuery('delete from posts where post_id = :post_id AND post_by = :post_by',[':post_id'=>sanitized($postId),':post_by'=>sanitized($so['user']['user_id'])]);

      if($res){
        $data['success']=true;
        $data['message'] = 'Post Deleted';
      }else{
        $data['success']= false;
        $data['error'] = 'Some error occured';
      }

    }else{
      $data['success']= false;
      $data['error'] = 'post not found';
    }
  }else{
    $data['success']= false;
    $data['error'] = 'postId empty';

  }
    echo json_encode($data);
    exit();
  }



} //f='post' ends


?>