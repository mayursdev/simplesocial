<div class="col-lg-5 m-auto pt-5">
        <div class="form-wrapper my-5 col bg-white box-shadow">
          <h1 class='mb-5'>Sign Up</h1>
          <!-- resp msg -->
          <?php echo returnPageContents('state-box/content'); ?>
          <form action="" class='' id='registerForm'>
            <div class="form-row">
              <div class="form-group col-lg-12">
                <label for="username">
                  <h4>
                    Full Name
                  </h4>
                </label>
                <input type="text" class='form-control' name='screenName' required>
              </div>
              <div class="form-group col-lg-12">
                <label for="username">
                  <h4>
                    Username
                  </h4>
                </label>
                <input type="text" class='form-control' name='username' required>
              </div>
              <div class="form-group col-lg-12">
                <label for="email">
                  <h4>
                    Email
                  </h4>
                </label>
                <input type="email" class='form-control' name='email' required>
              </div>
              <div class="form-group col-lg-12">
                <label for="password">
                  <h4>
                    Password
                  </h4>
                </label>
                <input type="password" class='form-control' name='password' required>
              </div>
              <div class="form-group col-lg-12">
                <label for="confirmPassword">
                  <h4>
                    Confirm Password
                  </h4>
                </label>
                <input type="password" class='form-control' name='confirmPassword' required>
              </div>
              <div class="form-group col-lg-12">
                <label for="gender" class='d-block'>
                  <h4>
                    Gender
                  </h4>
                </label>
                <select name="gender" id="gender" required>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>
            <button class="button-primary btn btn-block mt-4">
              <a href="#" id='register'>
                <h4>Register</h4>
              </a>
            </button>
            <p class='text-dark text-center mt-4 h2'><small>Already have an account? <a href="<?php echo $so['site_url'] ?>/index.php?page=login">Login</a></small></p>

          </form>
        </div>
      </div>

      <script>
        var registerForm = document.querySelector('#registerForm');
        registerForm.addEventListener('submit',function(e){
          $('.loader').show();
          e.preventDefault();
          var screenName = registerForm.screenName.value;
          var username = registerForm.username.value;
          var email = registerForm.email.value;
          var password = registerForm.password.value;
          var confirmPassword = registerForm.confirmPassword.value;
          var gender = registerForm.gender.value;
          $.post(ajaxRequestFile() + '?f=register', {
            screenName,
            username,
            email,
            password,
            confirmPassword,
            gender
          }, function (data) {
            $('.loader').hide();
            var data = JSON.parse(data)
            // console.log(data);
            if (data.success == true) {
              $('.state').html(data.message);
              $('.state').removeClass('alert-danger');
              $('.state').addClass('alert-success');
              $('.state').show();
              scrollTop();
              setTimeout(() => {
                window.location.href = data.location;
              }, 2000);

            } else {
              $('.state').html(data.error);
              $('.state').addClass('alert-danger');
              $('.state').show();
              scrollTop();
            }
          })


        })

      </script>