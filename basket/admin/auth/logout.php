
<?php
  session_start();
  if(isset($_SESSION['admin']) && $_SESSION['adminname'] !=NULL){
    unset($_SESSION['admin']);
    unset($_SESSION['adminname']);
    HEADER("location:../auth/login.php");
  }

?>