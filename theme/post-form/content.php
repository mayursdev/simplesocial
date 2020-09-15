            <form action="" method='' id='write-post' class="write-post box-shadow clearfix" enctype="multipart/form-data">
              <?php echo returnPageContents('state-box/content'); ?>
              <textarea name="postText" id="" cols="30" rows="3" placeholder="What's going on?"></textarea>
              <div class="write-post-footer d-flex justify-content-between">
                <div class="upload-img d-flex;">
                  <svg xmlns="http://www.w3.org/2000/svg" class='mr-2' viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    style="color:#8bc34a;">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                  </svg>
                  <input type="file" name='postImage' onchange="dispFileName(this.files,'postImageName')" id='img' accept="image/*">
                  <span>Upload Image</span>
                </div>
                <input class='form-control' type="text" readonly id='postImageName'>
                <button class='btn btn-danger float-right'>Post</button>
              </div>
            </form>
            <style>
              #postImageName{
                width: 190px;
                  margin-left: -29%;
                  display:none
              }
            </style>
            <script>
              $('#write-post').on('submit', function (e) {
                e.preventDefault()
                var formData = new FormData(this);
                $.ajax({
                  url: "requests.php?f=posts&s=insert",
                  type: "POST",
                  data: formData,
                  contentType: false,
                  cache: false,
                  processData: false,
                  success: function (data) {
                    var data  = JSON.parse(data)
                    if(data.success==true){
                      $("#posts-container").prepend(data.post);
                      $('#posts-container').find('.alert').hide();
                      $('#write-post')[0].reset();
                      $('.state').hide();
                      $('#postImageName').hide();
                    }else{
                      // error msgs
                      $('.state').addClass('alert-danger');
                      $('.state').html(data.error);
                      $('.state').show();


                    }
                  },
                  error: function () {}
                });
              })

            </script>