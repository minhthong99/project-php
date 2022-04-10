<?php require_once('templates/basket/inc/header.php'); ?>
<?php
if (isset($_POST["update"])) {
    if (isset($_SESSION["cart"])) {
        foreach ($_SESSION["cart"] as $value) {

            $_SESSION["cart"][$value["id"]]["quantity"] = $_POST["quantity" . $value["id"]];
        }
        header("location:cart");
    }
}
?>
<?php require_once('templates/basket/inc/leftbar.php'); ?>
<?php require_once 'util/DBConnectionUtil.php'; ?>
<!-- Header End -->


<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text product-more">
                    <a href="./home.html"><i class="fa fa-home"></i> Home</a>
                    <a href="./shop.html">Shop</a>
                    <span>Shopping Cart</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <?php if (!empty($_SESSION['cart'])) { ?>
                <form action="" method="POST">
                    <div class="col-lg-12">
                        <div class="cart-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th class="p-name">Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th><i class="ti-close"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sum = 0;
                                    foreach ($_SESSION['cart'] as $value) {
                                    ?>
                                        <tr>
                                            <td class="cart-pic first-row"><img src="files/uploads/<?php echo $value["image"] ?>" alt=""></td>
                                            <td class="cart-title first-row">
                                                <h5><?php echo $value["name"] ?></h5>
                                            </td>
                                            <td class="p-price first-row"><?php echo  $value["price"] ?>đ</td>
                                            <td class="qua-col first-row">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <input type="number" min="1" name="quantity<?php echo $value["id"] ?>" value="<?php echo $value['quantity'] ?>">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="total-price first-row"><?php echo number_format($value["price"] * $value["quantity"]);   ?>đ</td>
                                            <td class="close-td first-row"><a href="cart.php?id=<?php echo $value["id"] ?>&action=delete" style="color:black"><i class="ti-close"></i></a></td>
                                        </tr>

                                    <?php

                                        $sum = $sum + ($value["price"] * $value["quantity"]);

                                        $_SESSION["namePro"] = $value['name'];
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="cart-buttons">
                                    <a href="javascript:history.back()" class="primary-btn continue-shop" style="font-size: 12px;">Continue shopping</a>

                                    <button type="submit" name="update" class="primary-btn up-cart" style="font-size: 12px;">Update Cart</button>

                                </div>

                            </div>
                            <div class="col-lg-4 offset-lg-4">                             
                                <div class="proceed-checkout">
                                    <ul>                                     

                                        <li class="cart-total">Total <span><?php                                                                      
                                                                                $_SESSION["total"] = $sum * 100 / 100;
                                                                                echo number_format($_SESSION["total"]);                                                                           

                                                                            ?> đ </span></li>
                                    </ul>
                                
                                    <a href="check-out.php" class="proceed-btn">PROCEED TO CHECK OUT</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php } else { ?>
                <div class="col-lg-12">
                    <h3> Chưa có sản phẩm nào trong giỏ hàng ! </h3>
                    <br>
                    <div class="col-lg-4">
                        <div class="cart-buttons">
                            <button class="primary-btn continue-shop" style="font-size: 12px;color:black" onclick="window.location.href='trang-chu'">Continue shopping</button>
                        </div>
                    </div>
                </div>
            <?php    } ?>
        </div>
    </div>
</section>
<!-- Shopping Cart Section End -->
<!-- Footer Section Begin -->
<?php require_once('templates/basket/inc/footer.php'); ?>