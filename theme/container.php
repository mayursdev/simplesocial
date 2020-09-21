<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo $so['theme_url']; ?>/assets/css/bootstrap.css">
  <!-- <link rel="stylesheet" href="./assets/css/bootstrap-grid.css"> -->
  <link rel="stylesheet" href="<?php echo $so['theme_url']; ?>/assets/css/style.css?v=<?php echo filemtime("theme/assets/css/style.css"); ?>">
  <script src="<?php echo $so['theme_url']; ?>/assets/js/jquery.min.js"></script>
  <title>Document</title>
</head>

<body>
  <div class="loader"></div>
  <?php echo returnPageContents('navbar/content');?>
  <!-- content area start -->
  <div class="container-fluid main-content">

    <div class="row" id='content'>
      <?php echo $so['content']; ?>

    </div>
    <?php
      echo returnPageContents('reminder/content');
    ?>
  </div>
  <!-- content area end -->

  <!-- scripts -->
  <script src="<?php echo $so['theme_url']; ?>/assets/js/popper.js"></script>
  <script src='<?php echo $so['theme_url']; ?>/assets/js/bootstrap.min.js'></script>
  <script src="<?php echo $so['theme_url']; ?>/assets/js/fontawesome.js"></script>
  <script src="<?php echo $so['theme_url']; ?>/assets/js/script.js?v=<?php echo filemtime("theme/assets/js/script.js") ?>"></script>
  <script>
    function ajaxRequestFile() {
      return '<?php echo $so['site_url'];?>/requests.php';
  }
  </script>
  <?php echo returnPageContents('js/content'); ?>
</body>

</html>