<?php require_once('templates/basket/inc/header.php'); ?>
<?php require_once 'templates/basket/inc/leftbar.php'; ?>
<?php require_once 'util/DBConnectionUtil.php' ?>


<?php 
$key= "%{$_POST['product_search']}%";
$sqlPro = "SELECT * FROM product WHERE  name LIKE '%$key%' OR preview LIKE '%$key%' OR detail LIKE '%$key%' ";
$resultPro = $mysqli->query($sqlPro);


?>

<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="#"><i class="fa fa-home"></i> Home</a>
                    <span>Shop</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

<!-- Product Shop Section Begin -->
<section class="product-shop spad">
    <div class="container">
        <div class="row">



            <div class="col-lg-9 order-1 order-lg-2">
                <div class="product-show-option">
                    <div class="row">
                        <div class="col-lg-7 col-md-7">

                        </div>

                    </div>
                </div>
                <div class="product-list">

                    <div class="row">
                    
                        <?php 
                        if($resultPro){
                        while ($arPro = mysqli_fetch_assoc($resultPro)) { 
                            $name=$arPro['name'];
                            $id = $arPro['id'];
                            $nameReplace = utf8ToLatin($name);
                            $url = $nameReplace . '-' . $id . '.html';
                            ?>
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="files/uploads/<?php echo $arPro['image'] ?>" alt="" style="with:200px;height: 200px;">
                                        <div class="sale pp-sale">Sale</div>
                                        <div class="icon">
                                            <i class="icon_heart_alt"></i>
                                        </div>
                                        <ul>
                                            <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                            <li class="quick-view"><a href="<?php echo $url ?>">+ Quick View</a></li>
                                            <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="pi-text">
                                        <a href="<?php echo $url ?>">
                                            <h6><?php echo $arPro['name'] ?></h6>
                                        </a>
                                        <div class="product-price">

                                            <?php echo $arPro['price'] ?>$
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        }else{ ?>
                            <p class="text-center text-danger font-weight-bold">No Products Available</p> 
                     <?php   } ?>
                    </div>
                   
                           
                        
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once('templates/basket/inc/footer.php'); ?>
