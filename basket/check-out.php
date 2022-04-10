<?php
ob_start();
?>
<?php require_once('templates/basket/inc/header.php'); ?>


<?php require_once('templates/basket/inc/leftbar.php'); ?>

<!-- Header End -->
<?php require_once 'util/DBConnectionUtil.php'; ?>

<?php
if(empty($_SESSION['cart'])){
    header('location:cart');
}


if (isset($_POST['order'])) {

    $name = $_POST['name'];
    $amount = $_SESSION['total'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    // if (isset($_POST['COD'])) {
    //     $method = $_POST['COD'];
    // }
    // if (isset($_POST['paypal'])) {
    //     $method = "paypal";
    // }
    $order = $_SESSION['cart'];        
    if (isset($_SESSION['login'])) {
        $user_id = $_SESSION['userID'];
    } else {
        $resultUser = mysqli_query($mysqli, "INSERT INTO users(name,email,phone,address) VALUES ('{$name}','{$email}','{$phone}','{$address}')");
        $user_id = mysqli_insert_id($mysqli);
     
    }
    $sqlCheck = "INSERT INTO orders(user_id,amount,shippingAddress,message) VALUES('{$user_id}','{$amount}','{$address}','{$message}')";
    $resultCheck = mysqli_query($mysqli, $sqlCheck);
    $order_id = mysqli_insert_id($mysqli);
    foreach ($order as $key => $value) {
        $product_id = $key;
        $qty = $value['quantity'];
     
        $price = $value['price'];
        $result =  mysqli_query($mysqli, "INSERT INTO orders_detail(order_id,product_id,qty,price)VALUES('{$order_id}','{$product_id}','{$qty}','{$price}')");
    }        
    if ($result) {
        unset($_SESSION['cart']);
        unset($_SESSION['qnty']);
        unset($_SESSION['total']);
    }
    if ($resultCheck) {

        echo "<script>alert('thêm đơn hàng thành công');location.href='index.php'</script>";
    }
}
?>
<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text product-more">
                    <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                    <a href="./shop.html">Shop</a>
                    <span>Check Out</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Shopping Cart Section Begin -->
<section class="checkout-section spad">
    <div class="container">
        <form class="checkout-form" method="POST">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <?php if (!empty($_SESSION['login'])) { ?>
                            <div class="col-lg-6">
                                <label for="fir"> Name<span>*</span></label>
                                <input type="text" name="name" id="fir" value="<?php echo $_SESSION['username'] ?>">
                            </div>
                            <div class="col-lg-12">
                                <label for="street"> Address<span>*</span></label>
                                <input name="address" type="text" value="<?php echo $_SESSION['address'] ?>">
                            </div>
                            <div class="col-lg-6">
                                <label for="email">Email Address<span>*</span></label>
                                <input type="text" name="email" id="email" value="<?php echo $_SESSION['login'] ?>">
                            </div>
                            <div class="col-lg-6">
                                <label for="phone">Phone<span>*</span></label>
                                <input type="text" name="phone" id="phone" value="<?php echo $_SESSION['phone'] ?>">
                            </div>
                            <div class="col-lg-6">
                                <label for="last">Message<span>*</span></label>
                                <textarea name="message" id="" cols="50" rows="10"></textarea>
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-6">
                                <label for="fir"> Name<span>*</span></label>
                                <input type="text" name="name" id="fir" value="" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="street"> Address<span>*</span></label>
                                <input name="address" type="text" value="" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="email">Email Address<span>*</span></label>
                                <input type="text" name="email" id="email" value="" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="phone">Phone<span>*</span></label>
                                <input type="text" name="phone" id="phone" value="" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="last">Message<span>*</span></label>
                                <textarea name="message" id="" cols="50" rows="10"></textarea>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-6">

                    <div class="place-order">
                        <h4>Your Order</h4>
                        <div class="order-total">

                            <ul class="order-table">
                                <li>Product <span>Total</span></li>
                                <?php
                                if (!empty($_SESSION['cart'])) {
                                    $products = mysqli_query($mysqli, "SELECT * FROM `product` WHERE `id` IN (" . implode(",", array_keys($_SESSION["cart"])) . ")");
                                }

                                $total = $_SESSION['total'] * 0.000044;

                                if (!empty($products)) {
                                    while ($row = mysqli_fetch_array($products)) { ?>

                                        <input type="hidden" name="quantity[<?=$row['id'] ?>]"  value="<?= $_SESSION["cart"][$row['id']]['quantity'] ?>">

                                <?php }
                                } ?>
                                <?php foreach ($_SESSION['cart'] as $value) { ?>
                                    <li class="fw-normal"><?php echo $value['name'] ?> X <?php echo $value['quantity'] ?> <span><?php echo number_format($value["price"] * $value["quantity"], 2) ?>đ</span></li>


                                <?php } ?>
                                <li class="total-price">Total <span><?php echo number_format($_SESSION['total'], 2) ?>đ</span></li>
                            </ul>



                            <div class="order-btn">
                                <button type="submit" name="order" class="site-btn place-btn">Đặt hàng</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Shopping Cart Section End -->


<!-- Footer Section Begin -->
<?php require_once('templates/basket/inc/footer.php'); ?>