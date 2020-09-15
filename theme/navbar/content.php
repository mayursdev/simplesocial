<?php

if($so['logged_in']){
  echo returnPageContents('navbar/nav-logged-in');
}else{
  echo returnPageContents('navbar/nav-logged-out');
}
 ?>