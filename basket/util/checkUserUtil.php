<?php
    if(!isset($_SESSION['admin'])){
        HEADER("LOCATION:../../admin/auth/login.php");
    }
?>