<?php session_start(); ?>
<?php require_once '../../util/DBconnectionUtil.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <base href="http://localhost:8080/basket/">
    <title>Hệ thống quản lý cơ sở dữ liệu</title>
    <link href="templates/admin/css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <?php if (isset($_POST['submit'])) {
                                    $username = $_POST['name'];
                                    $password = $_POST['password'];
                                    if ($username == "" || $password == "") {
                                        echo "<script>alert('username hoặc password bạn không được để trống!')</script>";
                                    } else {
                                        $md5password = md5($password);
                                        $query = "SELECT * FROM admin WHERE name = '{$username}' AND password = '{$md5password}' ";
                                        $result = $mysqli->query($query);
                                        $infoAdmin = mysqli_fetch_assoc($result);
                                        $num_rows = mysqli_num_rows($result);
                                        if ($num_rows == 0) {
                                            echo "<script>alert('tên đăng nhập hoặc mật khẩu không đúng!')</script>";
                                        } else {
                                            $_SESSION['admin'] = $infoAdmin;
                                            $_SESSION['adminname'] = $username;
                                            $_SESSION['level'] = $infoAdmin['level'];
                                            $_SESSION ['admin_id']=$infoAdmin['id'];
                                            HEADER('LOCATION:../index.php');
                                        }
                                    }
                                }
                                ?>
                                <div class="card-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">Tên Đăng nhập</label>
                                            <input class="form-control py-4" name="name" type="text" placeholder="Enter username" />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPassword">Password</label>
                                            <input class="form-control py-4" name="password"  type="password" placeholder="Enter password" />
                                        </div>                                        
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">                                        
                                        <button type="submit" name="submit" class="form-control btn btn-primary btn-login">Đăng nhập</button>
                                        </div>
                                    </form>
                                </div>                               
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
               
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>