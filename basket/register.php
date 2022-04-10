<?php require_once('templates/basket/inc/header.php'); ?>
<?php require_once('templates/basket/inc/leftbar.php'); ?>
<!-- Header End -->

<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="#"><i class="fa fa-home"></i> Home</a>
                    <span>Register</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Form Section Begin -->
<?php
if (isset($_POST['submit'])) {

        $email=$_POST['email'];
        $name = $_POST['username'];
        $md5pass = md5($_POST['npass']);
        $sql = "INSERT INTO users(name,email,password) VALUES ('{$name}','{$email}','{$md5pass}')";
        $result = mysqli_query($mysqli, $sql);
        if ($result) {
            echo "<script>alert('thành công');location.href='login.php'</script>";
        } else {
            echo "<script>alert('thất bại');</script>";
        }
    
}

?>
<!-- Register Section Begin -->
<div class="register-login-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="register-form">
                    <h2>Register</h2>
                    <form name="changePass" method="POST" onsubmit="return valid();">
                        <div class="group-input">
                            <label for="username">Username </label>
                            <input type="text" id="username" name="username">
                        </div>
                        <div class="group-input">
                            <label for="username"> email address </label>
                            <input type="text" id="email" name="email" required>
                        </div>
                        <div class="group-input">
                            <label for="pass">Password *</label>
                            <input type="text" id="pass" name="npass" required>
                        </div>
                        <div class="group-input">
                            <label for="con-pass">Confirm Password *</label>
                            <input type="text" id="con-pass" name="cnfpass" required>
                        </div>
                        <button type="submit" name="submit" class="site-btn register-btn">REGISTER</button>
                    </form>
                    <div class="switch-login">
                        <a href="./login.php" class="or-login">Or Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register Form Section End -->



<!-- Footer Section Begin -->
<?php require_once('templates/basket/inc/footer.php'); ?>
<script type="text/javascript">
function valid(){
   if (document.changePass.npass.value == "") {
        alert("New Password is empty");
        document.changePass.npass.focus();
        return false;
    } else if (document.changePass.cnfpass.value == "") {
        alert("Confirm Password is empty");
        document.changePass.cnfpass.focus();
        return false;
    } else if (document.changePass.npass.value != document.changePass.cnfpass.value) {
        alert("Password and Confirm Password Field do not match  !!");
        document.changePass.cnfpass.focus();
        return false;
    }
    return true;
}
</script>