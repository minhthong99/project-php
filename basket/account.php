<?php require_once('templates/basket/inc/header.php'); ?>
<?php require_once('templates/basket/inc/leftbar.php'); ?>
<?php require_once 'util/DBConnectionUtil.php' ?>
<?php if (!isset($_SESSION['user'])) {
    echo "<script >location.href='login.php'</script>";
} else {
    if (isset($_POST['update'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['street'];
        $sql1 = "UPDATE users SET name='$name',phone='{$phone}',address='{$address}' WHERE id='{$_SESSION['id']}' ";
    }
    if (isset($_POST['submit'])) {

        $query2 = $mysqli->query("SELECT password FROM users WHERE password ='" . md5($_POST['cpass']) . "' && id ='{$_SESSION['userID']}' ");
        $num = mysqli_fetch_array($query2);
        if ($num > 0) {
            $sql2 = $mysqli->query("UPDATE users SET password = '" . md5($_POST['npass']) . "'  WHERE  id='{$_SESSION['userID']}'");
            echo "<script>alert('Password changed successfully!!!');</script>";
        } else {
            echo "<script>alert('Current Password not match !!');</script>";
        }
    }
}
?>

<!-- Header End -->

<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text product-more">
                    <a href="./index.php"><i class="fa fa-home"></i> Home</a>

                    <span>Account</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Shopping Cart Section Begin -->
<section class="checkout-section spad">
    <div class="container">     
        <form class="checkout-form" name="changePass" method="POST" onsubmit="return valid();">
            <div class="row">
                <div class="col-lg-6">
                    <h4>My ProFile</h4>
                    <div class="row">
                        <?php
                        $sql = "SELECT * FROM users WHERE id='{$_SESSION['userID']}' ";
                        $query = $mysqli->query($sql);
                        while ($value = mysqli_fetch_assoc($query)) {
                        ?>
                            <div class="col-lg-12">
                                <label for="fir"> Name<span>*</span></label>
                                <input type="text" id="fir" value="<?php echo $value['name'] ?>">
                            </div>
                            <div class="col-lg-12">
                                <label for="email">Email Address<span>*</span></label>
                                <input type="text" id="email" value="<?php echo $value['email'] ?>" readonly>
                            </div>
                            <div class="col-lg-12">
                                <label for="street"> Address<span>*</span></label>
                                <input type="text" id="street" class="street-first" value="<?php echo $value['address'] ?>">
                            </div>
                            <div class="col-lg-12">
                                <label for="phone">Phone<span>*</span></label>
                                <input type="text" id="phone" value="<?php echo $value['phone'] ?>">
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" name="update" class="site-btn place-btn">Update</button>
                            </div>
                        <?php } ?>
                    </div>

                </div>
                <div class="col-lg-6">

                    <?php $resultOrder = mysqli_query($mysqli, "SELECT id,user_id FROM orders WHERE user_id='{$_SESSION['userID']}'");
                    $array = mysqli_fetch_assoc($resultOrder);
                    ?>
                    <div class="place-order">
                        <h4>YOUR CHECKOUT PROGRESS</h4>
                        <div class="order-total">
                            <ul class="order-table">
                                <li class="fw-normal"><a href="account.php" style="color: black;">My Account</a></li>
                                <li class="fw-normal"><a href="order-history.php?user_id=<?php echo $array['user_id'] ?>" style="color: black;">Order History</a></li>
                            </ul>
                        </div>
                        <br>
                        <div class="place-order">
                            <h4>Change My Password</h4>
                         
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="fir"> Current Password<span>*</span></label>
                                        <input type="password" id="cpass" name="cpass">
                                    </div>
                                    <div class="col-lg-12">
                                        <label for="fir"> New Password<span>*</span></label>
                                        <input type="password" id="npass" name="npass">
                                    </div>
                                    <div class="col-lg-12">
                                        <label for="fir"> Confirm Password<span>*</span></label>
                                        <input type="password" id="cnfpass" name="cnfpass" required="required">
                                    </div>
                                    <button type="submit" name="submit" class="site-btn place-btn">Change</button>
                                </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Shopping Cart Section End -->

<!-- Partner Logo Section Begin -->

<!-- Partner Logo Section End -->

<!-- Footer Section Begin -->
<?php require_once('templates/basket/inc/footer.php'); ?>
<script type="text/javascript">
function valid(){
    if (document.changePass.value == "") {
        alert("Current Password is Empty !! ");
        document.changePass.cpass.focus();
        return false;
    } else if (document.changePass.npass.value == "") {
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