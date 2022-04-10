
<?php
  session_start();
  if(isset($_SESSION['user']) && $_SESSION['username'] !=NULL){
    unset($_SESSION['user']);
    unset($_SESSION['username']);
    unset($_SESSION['cart']);
    unset($_SESSION['qnty']);
    unset($_SESSION['login']);
    unset($_SESSION['address']);
    unset($_SESSION['phone']);
    HEADER("LOCATION:trang-chu");
  }

?>