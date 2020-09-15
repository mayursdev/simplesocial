<nav>

    <div class="nav-left">
      <h3 class='logo'><a href="<?php echo $so['site_url']; ?>">SIMPLE SOCIAL</a></h3>
    </div>

    <div class="nav-right h4">
      <a href="<?php if($so['page']=='login') echo $so['site_url'].'/index.php?page=register';
            elseif($so['page']=='register') echo $so['site_url'].'/index.php?page=login'; ?>" class='btn btn-outline-light'>
        <h4 class='m-0 px-4 pb-2 pt-1'>
        <?php
            if($so['page']=='login') echo 'Register';
            elseif($so['page']=='register') echo 'Login';
            ?>
        </h4>
      </a>
<?php

?>
    </div>
  </nav>