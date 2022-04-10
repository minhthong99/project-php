<?php require_once '../../templates/admin/inc/header.php'; ?>
<?php require_once '../../util/DBConnectionUtil.php'; ?>
<div id="layoutSidenav">
    <?php require_once '../../templates/admin/inc/leftbar.php'  ?>
    <div id="layoutSidenav_content">

        <?php
        if (isset($_POST['submit'])) {
            $error = array();

            if ($_POST['name'] && $_POST['email'] && $_POST['password']) {
                $name = $_POST['name'];
                $password = $_POST['password'];
                $email = $_POST['email'];
                $address = $_POST['address'];
                $phone = $_POST['phone'];
            } else {
                $error['name'] = 'Chưa nhập tên người dùng';
                $error['password'] = 'Chưa nhập mật khẩu';

                $error['email'] = 'Chưa nhập full name';
                
                $error['phone'] = 'Không được để trống';
                $error['address'] = 'Không được để trống';

                if ($_POST['password'] != $_POST['repassword']) {
                    $error['repassword'] = 'Mật khẩu chưa chính xác';
                } else {
                    $error['repassword'] = 'Chưa nhập mật khẩu';
                }
            }

            if (empty($error)) {

                $md5Password = md5($password);
                $query = "INSERT INTO users(name,email,password,phone,address) VALUES ('{$name}','{$email}','{$md5Password}','{$phone}','{$address}') ";
                $result = $mysqli->query($query);
                if ($result) {
                    $_SESSION['success'] ="Thêm người dùng thành công";
                  } else {
                  $_SESSION['error']= "không thể thêm  người dùng ";
                  }
            }
        }

        ?>
        <div class="container-fluid">
            <h1 class="mt-4">User</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">User</a></li>
                <li class="breadcrumb-item active">Add</li>
            </ol>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text">Thêm Danh mục</h5>
                    <div class="f-right">
                        <a href="" data-toggle="modal" data-target="#textual-input-Modal"><i class="icofont icofont-code-alt"></i></a>
                    </div>
                </div>
                <div class="modal-body">
                <?php if ( !empty($_SESSION['success'])) { ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Well done!</strong> <?php echo htmlentities($_SESSION['success']); ?><?php echo htmlentities($_SESSION['success'] = ""); ?>
                        </div>
                    <?php } ?>


                    <?php if (isset($_SESSION['error'] )) { ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Oh snap!</strong> <?php echo htmlentities($_SESSION['error']); ?><?php echo htmlentities($_SESSION['error'] = ""); ?>
                        </div>
                    <?php } ?>
                    <div class="card-block">
                        <form role="form" method="POST">
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="name" type="text" value="">
                                    <p class="text-danger"><?php echo isset($error['name']) ? $error['name'] : '' ?></p>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-email-input" class="col-xs-2 col-form-label form-control-label">Email</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="email" type="email" value="" id="example-email-input">
                                    <p class="text-danger"><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-password-input" class="col-xs-2 col-form-label form-control-label">Password</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="password" type="password" value="" id="example-password-input">
                                    <p class="text-danger"><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-password-input" class="col-xs-2 col-form-label form-control-label">Re-Password</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="repassword" type="password" value="" id="example-password-input">
                                    <p class="text-danger"><?php echo isset($error['repassword']) ? $error['repassword'] : '' ?></p>
                                </div>
                            </div>

                            <div class="form-group ">
                                 <label for="example-tel-input" class="col-xs-2 col-form-label form-control-label">Telephone</label>
                                 <div class="col-sm-10">
                                    <input class="form-control" name="phone"  value="" >
                                    <p class="text-danger"><?php echo isset($error['phone']) ? $error['phone'] : '' ?></p>
                                 </div>
                              </div>
                              <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Address</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="address" type="text" value="">
                                    <p class="text-danger"><?php echo isset($error['address']) ? $error['address'] : '' ?></p>
                                </div>
                            </div>

                            <button type="submit" name="submit" class="btn btn-success waves-effect waves-light m-r-30">Submit</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <?php require_once '../../templates/admin/inc/footer.php' ?>