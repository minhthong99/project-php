<?php require_once('templates/basket/inc/header.php'); ?>

<?php $currentpage = 'shop'; ?>
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
                    <span>Detail</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->
<!-- Product Shop Section Begin -->
<section class="product-shop spad page-details">
    <div class="container">
        <div class="row">
            <?php

            $id = $_GET['product_id'];

            $query = "SELECT product.*,cat.name as cat_name,cat.cat_id as categoryid FROM product  JOIN cat ON product.cat_id = cat.cat_id WHERE id='{$id}'";
            $result = $mysqli->query($query);
            $arPro  =  mysqli_fetch_assoc($result);
            $queryImage = "SELECT image FROM img_products WHERE product_id='{$id}'";
            $results = $mysqli->query($queryImage);

            ?>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="product-pic-zoom">
                            <img class="product-big-img" src="files/uploads/<?php echo $arPro['image'] ?>" alt="">
                            <div class="zoom-icon">
                                <i class="fa fa-search-plus"></i>
                            </div>
                        </div>
                        <div class="product-thumbs">
                            <div class="product-thumbs-track ps-slider owl-carousel">
                                <?php while ($arImg = mysqli_fetch_assoc($results)) { ?>

                                    <div class="pt" data-imgbigurl="files/uploads/<?php echo $arImg['image'] ?>"><img src="files/uploads/<?php echo $arImg['image'] ?>" alt=""></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="product-details">
                            <div class="pd-title">
                                <span><?php echo $arPro['cat_name'] ?></span>
                                <h3><?php echo $arPro['name'] ?></h3>
                                <a href="product.php?pid=<?php echo $arPro['id'] ?>&&action=wishlist" class="heart-icon"><i class="icon_heart_alt"></i></a>
                            </div>

                            <div class="pd-desc">
                                <p><?php echo $arPro['preview'] ?></p>
                                <h4><?php echo $arPro['price'] ?>đ</h4>
                            </div>

                            <ul class="pd-tags">
                                <li><span>Tình trạng: </span><?php if ($arPro['quantity'] > 0) {
                                                                    echo "Còn Hàng";
                                                                } else {
                                                                    echo "Hết Hàng";
                                                                }
                                                                ?></li>

                            </ul>
                            <?php if ($arPro['quantity'] > 0) { ?>
                                <form  action="cart.php">

                                
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="number" name="quantity" value="1" min="1">
                                    </div>
                                   
                                    <input type="submit"  class="primary-btn pd-cart" value="Add to Cart" />
                                </div>
                                <input type="hidden" name="id" value="<?php echo $arPro['id'] ?>">
                            </form>
                               
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="product-tab">
                    <div class="tab-item">
                        <ul class="nav" role="tablist">
                            <li>
                                <a class="active" data-toggle="tab" href="#tab-1" role="tab">DESCRIPTION</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-item-content">
                        <div class="tab-content">
                            <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                                <div class="product-content">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <p><?php echo $arPro['detail'] ?> </p>

                                        </div>
                                        <div class="col-lg-5">
                                            <img src="files/uploads/<?php echo $arPro['image'] ?>" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Shop Section End -->

<!-- Related Products Section End -->
<div class="related-products spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Sản phẩm liên quan</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $catid = $arPro['cat_id'];
            $sqlPro = "SELECT * FROM product WHERE cat_id={$catid} LIMIT 3";
            $resultArray = $mysqli->query($sqlPro);
            while ($array = mysqli_fetch_assoc($resultArray)) {
                $name = $array['name'];
                $id = $array['id'];
                $nameReplace = utf8ToLatin($name);
                $url = $nameReplace . '-' . $id . '.html';
            ?>

                <div class="col-lg-3 col-sm-6">
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="files/uploads/<?php echo $array['image'] ?>" alt="" style="with:200px;height: 200px;">

                            <ul>
                                <li class="quick-view"><a href="product/<?php echo $url ?>">+ Quick View</a></li>
                         
                            </ul>
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name"></div>
                            <a href="#">
                                <h5><?php echo $array['name'] ?></h5>
                            </a>
                            <div class="product-price">
                                <?php echo $array['price'] ?>đ

                            </div>
                        </div>
                    </div>

                </div>


            <?php } ?>
        </div>
    </div>
    <!-- Related Products Section End -->


    <!-- Footer Section Begin -->
    <?php require_once 'templates/basket/inc/footer.php' ?>