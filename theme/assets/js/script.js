// logout function
function logout(e) {
  $('.loader').show();
  e.preventDefault();
  $.post(ajaxRequestFile() + '?f=logout', {}, function (data) {
    var data = JSON.parse(data);
    $('.loader').hide();
    if (data.success == true) {
      window.location.href = data.location;
    } else {
      console.log('not done')
    }
  })
}

function dispFileName(file, elName) {
  var fileName = file[0]['name'];
  $('#' + elName).val(fileName);
  $('#' + elName).show();
}

function scrollTop() {
  window.scroll({
    top: 0,
    left: 0,
    behavior: 'smooth'
  });
}

function likePost(postId, event) {
  event.preventDefault();
  $('.loader').show();
  $.post(ajaxRequestFile() + '?f=posts&s=like_post', {
    postId
  }, function (data) {
    $('.loader').hide();
    var data = JSON.parse(data);
    if (data.success == true) {
      // removeClass d-none from liked post
      $("#post-" + postId).find(".like-stat").removeClass('d-none');

      var like = $("#post-" + postId).find(".like-count");
      var likeCount = parseInt(like.html());
      if (data.message == 'liked') {
        // inc like on liked post ui
        like.html(likeCount + 1);
        $("#post-" + postId).find(".like-btn").addClass('liked-btn');

      } else if (data.message == 'unliked') {
        // decrease like on unliked post ui
        if (likeCount == 1) {
          $("#post-" + postId).find(".like-stat").addClass('d-none');
        }
        like.html(likeCount - 1);
        $("#post-" + postId).find(".like-btn").removeClass('liked-btn');
      }

    } else {
      console.log(data, data.postId);
    }
  })

}

function postComment(postVal, postId, e) {
  e.preventDefault();
  if (e.keyCode == 13 && postVal.length > 0) {
    $('.loader').show();
    $.post(ajaxRequestFile() + '?f=posts&s=post_comment', {
      commentText: postVal,
      commentOn: postId
    }, function (data) {
      $('.loader').hide();
      var data = JSON.parse(data);
      $('.loader').hide();
      if (data.success == true) {
        var post = '#post-' + postId;
        $(post + ' .comments-list').prepend(data.comment);
        $(post + ' .alert').hide();
        $(post + ' .write-comment-input input').val('');
      } else if (data.success == false) {
        // console.log('not done')
      }
    })
  }
}

// delete post
function deletePost(postId) {
  if (confirm("Delete this post!")) {
    $('.loader').show();
    $.post(ajaxRequestFile() + '?f=posts&s=delete_post', {
      postId
    }, function (data) {
      $('.loader').hide();
      var data = JSON.parse(data);
      if (data.success == true) {
        var post = '#post-' + postId;
        $(post).hide();
        // $(post + ' .alert').hide();
        // $(post + ' .write-comment-input input').val('');
      } else if (data.success == false) {}
    })
  } else {}
}


function followUser(userId) {
  $('.loader').show();
  $.post(ajaxRequestFile() + '?f=user&s=follow_user', {
    userId
  }, function (data) {
    $('.loader').hide();
    var data = JSON.parse(data);
    if (data.success == true) {
      $('.follow-status').html(data.html);
    } else if (data.success == false) {}
  })
}

function censorWord(sentence) {
  var toCensor = ['stupid', 'idiot', 'kamina'];
  var sentence = sentence.toLowerCase();

  return sentence.split(' ').map(
    (word) => toCensor.includes(word.toLowerCase()) ? word[0] + '*'.repeat(word.length - 2) + word.slice(-1) : word
  ).join(' ')

}
// message
function sendMessage(el, userToMessage, e) {
  var message = el.value;
  if (e.keyCode == 13 && el.value.trim().length > 0) {
    el.value = '';
    $.post(ajaxRequestFile() + '?f=messages&s=send_message', {
      friend_id: userToMessage,
      message: censorWord(message)
    }, function (data) {
      var data = JSON.parse(data);
      if (data.success == true) {
        $('.alert').hide();
        $('.msg_history').append(data.html);
        // $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
        $(".msg_history").animate({
          scrollTop: $('.msg_history')[0].scrollHeight
        }, 1000);

      } else if (data.success == false) {}
    })
  }
}

// get list of people who message in noti
function messageNotification() {
  $('.loader').show();
  $.post(ajaxRequestFile() + '?f=user&s=message_notification', {

  }, function (data) {
    $('.loader').hide();
    var data = JSON.parse(data);
    if (data.success == true) {
      $('#message-count .noti-list').html(data.html);
    } else if (data.success == false) {}
  })
}

function otherNotification() {
  $('.loader').show();
  $.post(ajaxRequestFile() + '?f=user&s=other_notification', {

  }, function (data) {
    $('.loader').hide();
    var data = JSON.parse(data);
    if (data.success == true) {
      $('#notification-count .noti-list').html(data.html);
    } else if (data.success == false) {}
  })
}

function notiSeen(target, from) {
  $.post(ajaxRequestFile() + '?f=user&s=noti_seen', {
    from,
    target
  }, function (data) {
    var data = JSON.parse(data);
    if (data.success == true) {} else if (data.success == false) {

    }
  })
}