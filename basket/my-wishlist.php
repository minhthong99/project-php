<?php require_once('templates/basket/inc/header.php'); ?>
<?php require_once('templates/basket/inc/leftbar.php'); ?>

<?php require_once 'util/DBConnectionUtil.php'; ?>
<?php

if (strlen($_SESSION['login']) == 0) {
    echo "<script >location.href='login.php'</script>";
} else{

if(isset($_GET['del'])){
   mysqli_query($mysqli,"DELETE  FROM wishlist WHERE id={$_GET['del']}");
 }

?>
<div class="breacrumb-section">
    <div class="container">
        <div class="order">
            <div class="col-lg-12">
                <div class="breadcrumb-text product-more">
                    <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                    <span>Wishlist</span>
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
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="4">My Wishlist</th>

                    </tr>
                </thead><!-- /thead -->
                <tbody>
                    <?php

                   $sql = "SELECT product.image as pimg,product.price as pprice,product.name as pname ,product.id as pid,wishlist.product_id as wishpid, wishlist.id as wid FROM wishlist JOIN product ON wishlist.product_id=product.id WHERE wishlist.user_id='{$_SESSION['userID']}' ";
                    
                    $query = $mysqli->query($sql);
                    
                    $num=mysqli_num_rows($query);
                    if($num > 0){
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                        <tr>

                            <td class="col-md-2">
                                <a class="entry-thumbnail" href="detail.html">
                                    <img src="files/uploads/<?php echo $row['pimg']; ?>" alt="" width="100">
                                </a>
                            </td>
                            <td class="col-md-6">
                                <h4 class='cart-product-description' ><a href="product.php?product_id=<?php echo $row['wishpid']; ?>"style="color:black;">
                                        <?php echo $row['pname']; ?></a></h4>
                                <div class="price">
                                    <?php echo ($row['pprice']); ?> VNĐ

                                </div>

                            </td>                            

                          

                            <td class="col-md-2 close-btn"> <a href="my-wishlist.php?del=<?php echo $row['wid'] ?>" onclick="return confirm('Bạn có thật sự muốn xóa không ? ')" class="btn btn-danger">Delete</a></td>
                        </tr>
                    <?php
                    } 
                }else {
                    ?>
                    <tr>
                        <td>Your Wishlist is Empty</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</section>
<?php require_once('templates/basket/inc/footer.php'); ?>
<?php } ?>