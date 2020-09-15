<nav>

  <div class="nav-left">
    <h3 class='logo'><a href="<?php echo $so['site_url']; ?>">SIMPLE SOCIAL</a></h3>
    <form action="" class='search-form'>
      <input type="text" class='search-text'>
      <button class='search-icon'>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round" class="">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </button>
      <div class="search-results-container">
       <!-- users search result here -->
      </div>
    </form>
  </div>
  <div class="nav-right">
    <div class="noti-icons">
      <div class="dropdown" id='message-count'>
        <div class="noti-icon" data-toggle='dropdown' onclick="messageNotification()">
          <span class='noti-count d-none'></span>

          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
              d="M14.45 19L12 22.5 9.55 19H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-6.55zm-1.041-2H20V5H4v12h6.591L12 19.012 13.409 17z"
              fill="currentColor"></path>
          </svg>
        </div>
        <div class="dropdown-menu dropdown-menu-right">
          <h4 class='h4 p-3'>Messages</h4>
          <ul class='noti-list d-flex flex-column list-unstyled'>
            <!-- messageNotification dumped here -->
          </ul>
        </div>
      </div>
      <div class="dropdown" id='notification-count'>
        <div class="noti-icon" data-toggle='dropdown' onclick="otherNotification()">
          <span class='noti-count d-none'></span>

          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M20 17h2v2H2v-2h2v-7a8 8 0 1 1 16 0v7zm-2 0v-7a6 6 0 1 0-12 0v7h12zm-9 4h6v2H9v-2z"
              fill="currentColor"></path>
          </svg>
        </div>
        <div class="dropdown-menu dropdown-menu-right">
          <h4 class='h4 p-3'>Notifications</h4>
          <ul class='noti-list d-flex flex-column list-unstyled'>
            <!-- liked followed noti here -->
          </ul>
        </div>
      </div>

    </div>

    <div class="nav-user">
      <div class="dropdown">
        <div class="nav-logged-user-info inline-items" data-toggle='dropdown'>
          <div class="logged-user-avatar-container">
            <img src="<?php echo $so['site_url'].$so['user']['profileImage']; ?>" class='logged-user-avatar' alt="">
          </div>
          <a href=""><?php echo $so['user']['screenName']; ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
          </a>
        </div>
        <div class="dropdown-menu dropdown-menu-right ">
          <a class="dropdown-item text-dark h4"
            href="<?php echo "{$so['site_url']}/index.php?page=timeline&u={$so['user']['username']}"; ?>">My Profile</a>
          <a class="dropdown-item text-dark h4"
            href="<?php echo $so['site_url']."/index.php?page=settings" ?>">Settings</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-dark h4 logout" onclick="logout(event)" href="#">Logout</a>
        </div>
      </div>
    </div>
  </div>
</nav>
<script>
  $('.search-form').on('submit',function(e){
    e.preventDefault();
  })
  $('.search-text').keyup(function(){
    var searchText = $(this).val();
    $.post(ajaxRequestFile() + '?f=user&s=search_users', {
    searchText
  }, function (data) {
    var data = JSON.parse(data);
    if (data.success == true) {
      $('.search-results-container').html(data.html);
    } else if (data.success == false) {
      $('.search-results').hide();
      console.log('not found');
    }
  })

  })
</script>