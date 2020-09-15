<div class="post-card box-shadow" id="post-<?php echo $so['post']['post_id']; ?>">
  <div class="post-card-header inline-items d-flex justify-content-between">
    <div class="post-uploader-avatar-container">
      <img src="<?php echo $so['site_url'].$so['post']['postBy']['profileImage']; ?>" alt=""
        class="post-uploader-avatar">
    </div>
    <div class="post-uploader-info mr-auto">
      <a href="<?php echo $so['site_url']."/index.php?page=timeline&u=".$so['post']['postBy']['username']; ?>">
        <h4 class='post-uploader-name'><?php echo $so['post']['postBy']['screenName']; ?></h4>
      </a>
      <p class='post-upload-time text-muted'><?php echo time_ago(strtotime($so['post']['posted_on'])); ?></p>
    </div>
 <?php if($so['post']['postBy']['user_id']==$so['user']['user_id']){ ?>
    <span class="dropdown">
      <a href="" class="text-dark" data-toggle='dropdown'>
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"> <polyline points="6 9 12 15 18 9"></polyline> </svg>
      </a>
      <ul class="dropdown-menu dropdown-menu-right">
        <li onclick='deletePost(<?php echo $so["post"]["post_id"]; ?>)' class='text-danger h5 m-0'>Delete</li>
      </ul>
    </span>
  <?php } ?>

  </div>
  <div class="post-card-content">
    <?php if($so['post']['post_text']!=null){ ?>
    <p class="post-description"><?php echo $so['post']['post_text']; ?></p>
    <?php } ?>
    <?php if($so['post']['post_image']!=null){ ?>
    <div class="post-description-image-container">
      <img src="<?php echo $so['site_url'].$so['post']['post_image']; ?>" alt="" class="post-description-image">
    </div>
    <?php } ?>
    <div class="like-stat inline-items <?php if($so['post']['likes']==0) echo 'd-none'; ?>">
      <div class="like-emoji">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" stroke="#1da1f3" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
          <path
            d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
          </path>
        </svg>
      </div>
      <div class="like-count"><?php echo $so['post']['likes']; ?></div>
    </div>
  </div>
  <div class="post-card-reactions">

    <a href="#" class='like-btn <?php
    $liked = postIsLiked($so["post"]["post_id"]);
    if(isset($liked[0]["like_id"])) echo "liked-btn"; ?>' onclick='likePost(<?php echo $so["post"]["post_id"];
    ?>,event)'>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="" stroke-width=""
        stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
        <path
          d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
        </path>
      </svg>
      Like
    </a>

    <a href="" class='comment-btn' data-toggle="collapse" data-target="#comments-<?php echo $so['post']['post_id'];?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle">
        <path
          d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
        </path>
      </svg>
      Comment</a>
    <!--share btn copy link to clipboard => index.php?page=home&post={postId} -->
    <!-- <a href="#" class='share-btn'>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2">
        <circle cx="18" cy="5" r="3"></circle>
        <circle cx="6" cy="12" r="3"></circle>
        <circle cx="18" cy="19" r="3"></circle>
        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
      </svg>
      Share
    </a> -->
  </div>
  <div class='post-card-comments collapse out' id='comments-<?php echo $so['post']['post_id']; ?>'>
    <div class="write-comment d-flex py-3 pb-4">
      <div class="chat-user-avatar-container comment-item-left">
        <!-- img src = $so['user']['profileImage']-->
        <img src="<?php echo $so['site_url'].$so['user']['profileImage']; ?>" alt="user-profile-image">
      </div>
      <div class="write-comment-input" style='width:93%'>
        <input type="text" class='form-control' name='commentText' placeholder='write your comment and press enter..' onkeyup = 'postComment(this.value,<?php echo $so["post"]["post_id"]; ?>,event)'>
      </div>
    </div>
    <ul class="comments-list d-flex flex-column pt-4">
      <!-- loop -->
      <?php $postComments = getPostComments($so["post"]["post_id"]);
        if(count($postComments)>0){
          foreach ($postComments as $so["comment"]) {
            $so["comment"]["commentBy"] = getUserData($so["comment"]["comment_by"]);
            echo returnPageContents("comment-list/content");
        }
        }else
          echo "<div class='alert alert-secondary h4 p-3'>No Comments</div>";

      ?>
    </ul>
  </div>
</div>

<style>
  .write-comment{
    border-bottom:1px solid #e5e5e5;
  }
  .write-comment-input input{
    border-radius:500px
  }
</style>