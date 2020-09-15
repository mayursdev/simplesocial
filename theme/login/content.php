<div class="col-lg-4 m-auto pt-5">
        <div class="form-wrapper mt-5 col bg-white box-shadow">
          <h1 class='mb-5'>Login</h1>
          <!-- resp msg -->
          <?php echo returnPageContents('state-box/content'); ?>
          <form action="requests.php?f=login" method='post' id='loginForm' class=''>
            <div class="form-row">
              <div class="form-group col-lg-12">
                <label for="email">
                  <h4>
                    Username or Email
                  </h4>
                </label>
                <input type="text" class='form-control' name='email'>
              </div>
              <div class="form-group col-lg-12">
                <label for="password">
                  <h4>
                    Password
                  </h4>
                </label>
                <input type="password" class='form-control' name='password'>
              </div>
            </div>
            <button class="btn button-primary btn-block mt-4">
              <a href="#" class="">
                <h4>Login</h4>
                </a>
            </button>
            <p class='text-dark text-center mt-4 h2'><small>Don't have an account? <a href="<?php echo $so["site_url"]; ?>/index.php?page=register">Register</a></small></p>
          </form>
        </div>
      </div>

  <script>
        // login form ajax
  var loginForm = document.querySelector('#loginForm');
  loginForm.addEventListener('submit', function (e) {
    $('.loader').show();
    e.preventDefault();
    var email = loginForm.email.value;
    var password = loginForm.password.value;
    $.post(ajaxRequestFile() + '?f=login', {
      email: email,
      password: password
    }, function (data) {
      $('.loader').hide();
      var data = JSON.parse(data)
      if (data.success == true) {
        $('.state').html(data.message);
        $('.state').removeClass('alert-danger');
        $('.state').addClass('alert-success');
        $('.state').show();
        setTimeout(() => {
          window.location.href = data.location;
        }, 1000);

      } else {
        $('.state').html(data.error);
        $('.state').addClass('alert-danger');
        $('.state').show();
      }
    })
  })
  </script>