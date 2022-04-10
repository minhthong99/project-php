<?php require_once('templates/basket/inc/header.php'); ?>
<?php require_once('templates/basket/inc/leftbar.php'); ?>

<?php require_once 'util/DBConnectionUtil.php'; ?>
<?php
if (!isset($_SESSION['user'])) {
    echo "<script >location.href='login.php'</script>";
}
if (isset($_GET['del'])) {
    mysqli_query($mysqli, "DELETE  FROM orders WHERE id={$_GET['del']}");
}
$id = $_GET['user_id'];
$query_not = mysqli_query($mysqli, "SELECT * FROM `orders` WHERE user_id = $id AND status ='0' ");
$query= mysqli_query($mysqli, "SELECT * FROM orders WHERE user_id = $id AND status != '0' ");
?>
<div class="breacrumb-section">
    <div class="container">
        <div class="order">
            <div class="col-lg-12">
                <div class="breadcrumb-text product-more">
                    <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                    <span>Shopping Cart</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Shopping Cart Section Begin -->
<section class="checkout-section spad">
    <form method="GET">
    <div class="container">    
            
            <h4>Danh sách đơn hàng chưa duyệt</h4>


            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="cart-romove item">#</th>
                        <th class="cart-description item">Order Date</th>
                        <th class="cart-sub-total item">Order Value</th>
                        <th class="cart-sub-total item">Status</th>
                        <th class="cart-total last-item" style="text-align: center;" colspan="2">Action</th>
                    </tr>
                </thead><!-- /thead -->
                <tbody>
                    <?php $cnt = 0;
                    while ($row = mysqli_fetch_assoc($query_not)) { ?>

                        <tr>
                            <td><?php echo $cnt++; ?></td>
                            <td class="cart-product-sub-total"><?php echo $row['created']; ?> </td>
                            <td><?php echo $row['amount'] ?></td>
                            <td class="cart-product-sub-total">
                                <?php
                                switch ($row['status']) {
                                    case '0':
                                        echo 'Đang đợi duyệt';
                                        break;
                                }

                                ?>
                            </td>
                            <td width="120"><span><a style="color:#0f9ed8;" href="order-detail.php?order_id=<?php echo $row['id'] ?>">Xem chi tiết </a></span></td>
                            <td width="120"> <a href="order-history.php?del=<?php echo $row['id'] ?>" onclick="return confirm('Bạn có thật sự muốn xóa không ? ')" class="btn btn-danger">Delete</a></td>
                        </tr>

                    <?php } ?>

                </tbody>
            </table>

      
            <h4>Danh sách đơn hàng đã duyệt</h4>


            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="cart-romove item">#</th>
                        <th class="cart-description item">Order Date</th>
                        <th class="cart-sub-total item">Order Value</th>
                        <th class="cart-sub-total item">Status</th>
                        <th class="cart-total last-item" style="text-align: center;" colspan="2">Action</th>
                    </tr>
                </thead><!-- /thead -->
                <tbody>
                    <?php $cnt = 0;
                    while ($value = mysqli_fetch_assoc($query)) { ?>

                        <tr>
                            <td><?php echo $cnt++; ?></td>
                            <td class="cart-product-sub-total"><?php echo $value['created']; ?> </td>
                            <td><?php echo $value['amount'] ?></td>
                            <td class="cart-product-sub-total">
                                <?php
                                switch ($value['status']) {
                                    case '1':
                                        echo 'Đang giao hàng';
                                        break;
                                    case '2':
                                        echo 'Đã nhận hàng';
                                        break;
                                }

                                ?>
                            </td>
                            <td width="120"><span><a style="color:#0f9ed8;" href="order-detail.php?order_id=<?php echo $value['id'] ?>">Xem chi tiết </a></span></td>
                        </tr>

                    <?php } ?>

                </tbody>
            </table>
      
       
    </div>
    </form>
</section>
<?php require_once('templates/basket/inc/footer.php'); ?>