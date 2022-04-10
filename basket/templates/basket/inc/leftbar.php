<?php require_once 'util/DBConnectionUtil.php'; ?>


<?php

if (isset($_GET['pid']) && $_GET['action'] == "wishlist") {
    $pid = intval($_GET['pid']);
    if (strlen($_SESSION['login']) == 0) {
        header('location:signin');
    } else {
        mysqli_query($mysqli, "insert into wishlist(user_id,product_id) values('" . $_SESSION['userID'] . "','$pid')");
        echo "<script>alert('Product added in wishlist');</script>";
        header('location:wishlist');
    }
}
?>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="header-top">
            <div class="container">
                <div class="ht-left">
                    <?php if (isset($_SESSION['username'])) { ?>
                        <div class="mail-service">
                            <i class="icon fa fa-user">Welcome -</i>
                            <?php echo $_SESSION['username'] ?>
                        </div>


                    <?php } ?>
                    <div class="mail-service">
                        <a href="wishlist" style="color: black;"><i class="icon fa fa-heart">Wishlist</i></a>

                    </div>
                    <?php if (!isset($_SESSION['username'])) { ?>
                        <div class="mail-service">
                            <a href="signin" style="color:black;"> <i class="icon fa fa-sign-in">Login</i>
                            </a>
                        </div>
                    <?php } else { ?>
                        <div class="mail-service">
                            <a href="logout.php" style="color:black;"> <i class="icon fa fa-sign-out">Logout</i>
                            </a>
                        </div>

                    <?php } ?>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="inner-header">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="logo">
                            <a href="./trang-chu">
                                <img src="templates/basket/img/logo.png" style="" alt="">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-7">

                        <div class="advanced-search">
                            <button type="button" class="category-btn">All Categories</button>
                            <form method="POST" name="search" action="search.php" class="input-group">

                                <input type="text" name="product_search" placeholder="What do you need?" style="color:black" required="required">
                                <button type="submit" name="search"><i class="ti-search"></i></button>
                            </form>
                        </div>

                    </div>
                    <div class="col-lg-3 text-right col-md-3">


                        <ul class="nav-right">
                            <li class="heart-icon">
                                <a href="tai-khoan">
                                    <img src="templates/basket/img/account.png" alt="" style="width: 40px;height:40px">
                                    Tài khoản

                                </a>
                            </li>
                            <li class="cart-icon">



                                <div class="cart-hover" style="overflow: auto; max-height:290px;">
                                    <ul>
                                        <?php if (!empty($_SESSION['cart'])) { ?>
                                            <?php
                                            $sql = "SELECT * FROM product WHERE id IN (";
                                            foreach ($_SESSION['cart'] as $id => $value) {
                                                $sql .= $id . ",";
                                            }
                                            $sql = substr($sql, 0, -1) . ") ORDER BY id ASC";
                                            $query = $mysqli->query($sql);
                                            $totalprice = 0;
                                            $totalqty = 0;

                                            while ($row = mysqli_fetch_assoc($query)) {
                                                $quantity = $_SESSION['cart'][$row['id']]["quantity"];
                                                $subtotal = $_SESSION['cart'][$row['id']]["quantity"] * $row['price'];
                                                $totalprice += $subtotal;
                                                $totalqty  += $quantity;
                                            ?>

                                                <li class="select-items">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td class="si-pic"><img src="files/uploads/<?php echo $row['image'] ?>" alt=""></td>
                                                                <td class="si-text">
                                                                    <div class="product-selected">
                                                                        <p><?php echo $row['price'] ?>x<?php echo $_SESSION['cart'][$row['id']]['quantity']; ?></p>
                                                                        <h6><?php echo $row['name'] ?></h6>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </li>

                                            <?php }
                                            ?>
                                    </ul>
                                    <div class="select-total">
                                        <span>total:</span>
                                        <h5><?php echo $totalprice; ?>đ</h5>
                                    </div>

                                <?php } else { ?>

                                    <div class="select-items">
                                        Your Shopping Cart is Empty.
                                    </div>
                                <?php } ?>
                                <div class="clearfix"></div>
                                <div class="select-button" style="width: 100%; float:left;">
                                    <a href="cart" class="primary-btn view-card">VIEW CARD</a>
                                    <a href="check-out.php" class="primary-btn checkout-btn">CHECK OUT</a>
                                </div>
                                </div>
                                <a href="cart">
                                    <i class="icon_bag_alt"></i>
                                    <?php if (isset($totalqty)) { ?>
                                        <span><?php echo $totalqty; ?></span>
                                    <?php } else { ?>
                                        <span>0</span>
                                    <?php } ?>

                                </a>
                            </li>


                            <li class="cart-price"></li>

                        </ul>

                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <div class="container">
                <nav class="nav-menu mobile-menu">
                    <ul>
                        <li> <a href="trang-chu">Home</a></li>

                        <li> <a href="tin-tuc">Blog</a></li>
                        <li> <a href="lien-he">Contact</a></li>
                        <?php
                        $sql = "SELECT cat_id,name FROM cat limit 6 ";
                        $result = $mysqli->query($sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $nameCat = $row['name'];
                            $cat_id = $row['cat_id'];
                            $nameReplace = utf8ToLatin($nameCat);
                            $url = $nameReplace . '-' . $cat_id;
                        ?>
                            <li> <a href="<?php echo $url; ?>"><?php echo $row['name']; ?></a></li>


                        <?php

                        }
                        ?>


                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>