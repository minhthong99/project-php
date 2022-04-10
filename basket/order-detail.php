<?php require_once('templates/basket/inc/header.php'); ?>
<?php require_once('templates/basket/inc/leftbar.php'); ?>

<?php require_once 'util/DBConnectionUtil.php'; ?>
<?php
if (!isset($_SESSION['user'])) {
    echo "<script >location.href='login.php'</script>";
}

if(isset($_GET['del'])){
    mysqli_query($mysqli,"DELETE  FROM orders WHERE id={$_GET['del']}");
  }
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
    <div class="container">     
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="cart-romove item">#</th>
                        <th class="cart-description item">Image</th>
                        <th class="cart-product-name item">Product Name</th>
                        <th class="cart-qty item">Quantity</th>                       
                        <th class="cart-sub-total item">Price Per unit</th>
                        <th class="cart-sub-total item">Shipping Charge</th>
                        <th class="cart-total item">Grandtotal</th>
                        <th class="cart-description item">Order Date</th>                     
                        <th class="cart-total last-item">Action</th>
                    </tr>
                </thead><!-- /thead -->
                <tbody>
                    <?php
                    $cnt = 1;
                    $shippcharge = 30000;
                    $sql = "SELECT product.image as pimg,product.name as pname ,product.id as pid,orders_detail.product_id as orpid, orders_detail.qty as oqty,product.price as pprice,orders.created as ocreate,orders.status as ostatus,orders.id as orid FROM orders_detail JOIN product ON orders_detail.product_id=product.id JOIN orders ON orders.id=orders_detail.order_id WHERE orders_detail.order_id='{$_GET['order_id']}' ";
                
                    $query = $mysqli->query($sql);                  
          
                    $num=mysqli_num_rows($query);
                    if($num>0){
                        while ($order = mysqli_fetch_assoc($query)) {
                    ?>
                            <tr>
                                <td><?php echo $cnt; ?></td>
                                <td class="cart-image">
                                    <a class="entry-thumbnail" href="detail.html">
                                        <img src="files/uploads/<?php echo $order['pimg']; ?>" alt="" width="100">
                                    </a>
                                </td>
                                <td class="cart-product-name-info">
                                    <h4 class='cart-product-description'><a href="product.php?product_id=<?php echo $order['orpid']; ?>" style="color:black;">
                                            <?php echo $order['pname']; ?></a></h4>

                                </td>
                                <td class="cart-product-quantity">
                                    <?php echo $qty = $order['oqty']; ?>
                                </td>
                        
                                <td class="cart-product-sub-total"><?php echo $price = $order['pprice']; ?> </td>
                                <td class="cart-product-sub-total"><?php echo $shippcharge; ?> </td>
                                <td class="cart-product-grand-total"><?php echo (($qty * $price) + $shippcharge); ?></td>
                                <td class="cart-product-sub-total"><?php echo $order['ocreate']; ?> </td>
                               
                                <td> <a href="order-history.php?del=<?php echo $order['orid'] ?>" onclick="return confirm('Bạn có thật sự muốn xóa không ? ')" class="btn btn-danger">Delete</a></td>
                            </tr>
                        <?php $cnt = $cnt + 1;
                        } 
                    }
            ?>
                </tbody>
            </table>
        
    </div>
</section>
<?php require_once('templates/basket/inc/footer.php'); ?>