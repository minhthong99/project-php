<?php require_once '../../templates/admin/inc/header.php' ?>
<?php require_once '../../util/DBConnectionUtil.php'; ?>
<div id="layoutSidenav">
    <?php require_once '../../templates/admin/inc/leftbar.php'  ?>
    <div id="layoutSidenav_content">

        <?php
        #Select
        $id = $_GET['user_id'];
        $select = "SELECT * FROM users WHERE id = {$id}";
        if ($mysqli->query($select)) {
            $infoUser = mysqli_fetch_assoc($mysqli->query($select));
        }

        #update

        #thuật toán  đặt cờ hiệu
        if (isset($_POST['submit'])) {
            $error = array();
            if ($_POST['name'] && $_POST['email'] && $_POST['password'] ) {
                $name = $_POST['name'];
                $password = $_POST['password'];
                $email = $_POST['email'];
                $address = $_POST['address'];
                $phone = $_POST['phone'];
            } else {
                $error['name'] = 'Chưa nhập tên người dùng';
             
                $error['email'] = 'Chưa nhập full name';
                $error['phone'] = 'Không được để trống';
                $error['address'] = 'Không được để trống';
              
            }
            if (empty($error)) {

                $md5password = md5($password);
                #b2 viết câu lệnh truy vấn
                $query = "UPDATE users SET name ='{$name}', password = '{$md5password}', email = '{$email}',phone ='{$phone}',address='{$address}' WHERE id = {$id}";
                #b3 thêm dữ liệu vào database
                $result = $mysqli->query($query);
                #b4 thông báo kết quả     
                if ($result) {
                    $_SESSION['success'] ="Cập nhật tài khoản thành công";
                  }  else {
                    $_SESSION['error']= "không thể cập nhật tài khoản ";
                    }     
            }
   
        }

        ?>
        <div class="container-fluid">
            <h1 class="mt-4">Users</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="admin/dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit User</li>
            </ol>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text">Sửa Khách hàng</h5>
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
                        <form method="POST" name="changePass" onsubmit="return valid();">
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">User Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="name" type="text" value="<?php echo $infoUser['name'] ?>">
                                    <p class="text-danger"><?php echo isset($error['name']) ? $error['name'] : '' ?></p>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-email-input" class="col-xs-2 col-form-label form-control-label">Email</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="email" type="email" value="<?php echo $infoUser['email'] ?>" id="example-email-input">
                                    <p class="text-danger"><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-password-input" class="col-xs-2 col-form-label form-control-label">Password</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="password" type="password" value="<?php echo $infoUser['password'] ?>" id="example-password-input">
                               
                                </div>
                            </div>
                          
                            <div class="form-group ">
                                <label for="example-password-input" class="col-xs-2 col-form-label form-control-label">Re-Password</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="re_password" type="password" value="<?php echo $infoUser['password'] ?>" id="example-password-input">
                                   
                                </div>
                            </div>                           
                                  
                            <div class="form-group ">
                                 <label for="example-tel-input" class="col-xs-2 col-form-label form-control-label">Telephone</label>
                                 <div class="col-sm-10">
                                    <input class="form-control" name="phone"  value="<?php echo $infoUser['phone'] ?>" >
                                    <p class="text-danger"><?php echo isset($error['phone']) ? $error['phone'] : '' ?></p>
                                 </div>
                              </div>
                              <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Address</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="address" type="text" value="<?php echo $infoUser['address'] ?>">
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
        <script type="text/javascript">
			function valid() {
			 if (document.changePass.password.value == "") {
					alert("New Password Filed is Empty !!");
					document.changePass.password.focus();
					return false;
				} else if (document.changePass.re_password.value == "") {
					alert("Confirm Password Filed is Empty !!");
					document.changePass.re_password.focus();
					return false;
				} else if (document.changePass.password.value != document.changePass.re_password.value) {
					alert("Password and Confirm Password Field do not match  !!");
					document.changePass.re_password.focus();
					return false;
				}
				return true;
			}
		</script>