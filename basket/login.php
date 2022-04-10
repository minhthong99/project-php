<?php require_once 'templates/basket/inc/header.php'; ?>
<?php require_once 'templates/basket/inc/leftbar.php'; ?>
<?php require_once 'util/DBConnectionUtil.php' ?>
<!-- Header End -->

<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="#"><i class="fa fa-home"></i> Home</a>
                    <span>Login</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Form Section Begin -->

<!-- Register Section Begin -->
<div class="register-login-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-1">
                <div class="login-form">
                    <h2>Login</h2>
                    <?php if (isset($_POST['submit'])) {
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        if ($email == "" || $password == "") {
                            echo "<script>alert('username hoặc password bạn không được để trống!')</script>";
                        } else {
                            $md5password = md5($password);
                            $query = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$md5password}' ";
                            $result = mysqli_query($mysqli, $query);
                            $infoUser = mysqli_fetch_assoc($result);
                            $num_rows = mysqli_num_rows($result);
                            if ($num_rows == 0) {
                                echo "<script>alert('tên đăng nhập hoặc mật khẩu không đúng!')</script>";
                            } else {
                                $_SESSION['login'] = $email;
                                $_SESSION['user'] = $infoUser;
                                $_SESSION['address'] = $infoUser['address'];
                                $_SESSION['username'] = $infoUser['name'];
                                $_SESSION['phone'] = $infoUser['phone'];
                                $_SESSION['userID'] = $infoUser['id'];
                                echo "<script>alert('thành công');location.href='trang-chu';</script>";
                            }
                        }
                    }
                    ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="group-input">
                            <label for="username">Username or email address *</label>
                            <input type="text" name="email">
                        </div>
                        <div class="group-input">
                            <label for="pass">Password *</label>
                            <input type="password" name="password">
                        </div>
                       
                        <button type="submit" name="submit" class="site-btn login-btn">Sign In</button>
                    </form>
                    <div class="switch-login">
                        <a href="signup" class="or-login">Or Create An Account</a>
                    </div>
                </div>

            </div>           
        </div>
    </div>
</div>
<!-- Register Form Section End -->
<!-- Footer Section Begin -->
<?php require_once('templates/basket/inc/footer.php'); ?>