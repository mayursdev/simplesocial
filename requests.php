<?php
require_once('includes/init.php');
$f ='';
$s ='';
if(isset($_GET['f'])){
  $f = $_GET['f'];
}
if(isset($_GET['s'])){
  $s = $_GET['s'];
}


include('xhr/'.$f.'.php');


?>