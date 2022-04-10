<?php require_once('templates/basket/inc/header.php'); ?>

<?php $currentpage ='home'; ?>
<?php require_once('templates/basket/inc/leftbar.php'); ?>

<!-- Hero Section Begin -->
<?php $sqlNew = "SELECT * FROM product  ORDER BY id DESC Limit 4";
$pro_New = $mysqli->query($sqlNew);
$queryNews="SELECT * FROM news ORDER BY id DESC LIMIT 3";
$resultNews=$mysqli->query($queryNews);
$queryCat = "SELECT cat_id,name FROM cat limit 6";
$result = $mysqli->query($queryCat);

?>
<section class="hero-section">
    <div class="hero-items owl-carousel">
        <div class="single-hero-items set-bg" data-setbg="files/images/antetentokoumpobasket.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">

                        <a href="#" class="primary-btn">Shop Now</a>
                    </div>
                </div>
                <div class="off-card">
                    <h2>Sale <span>50%</span></h2>
                </div>
            </div>
        </div>
        <div class="single-hero-items set-bg" data-setbg="files/images/westbrook.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">                     
                    </div>
                </div>
                <div class="off-card">
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Banner Section Begin -->
<div class="banner-section spad">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="single-banner">
                    <img src="files/images/basketball-thumbs-01-d.jpg" alt="">
                    <div class="inner-text">                   
                        <h4><a href="footwear-12" style="color:black">FootWear</a></h4>
                     
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="single-banner">
                    <img src="files/images/basketball-thumbs-02-d.jpg" alt="" >
                    <div class="inner-text">
                        <h4><a href="clothing-15" style="color:black">Clothing</a></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="single-banner">
                    <img src="files/images/DSA01524.jpg" alt="">
                    <div class="inner-text">                    
                        <h4><a href="equipments-13" style="color:black">Equipments</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner Section End -->

<!-- Women Banner Section Begin -->
<section class="women-banner spad">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">

                <div class="product-large set-bg" data-setbg="templates/basket/img/products/wp7169421.png">
                    <h2>Sản phẩm mới</h2>
                    <a href="#">Discover More</a>
                </div>
            </div>
            <div class="col-lg-8 offset-lg-1">
                <div class="filter-control">
                    <ul>
                    <?php while($array =mysqli_fetch_assoc($result)){
                        $nameCat = $array['name'];
                        $cat_id = $array['cat_id'];
                        $nameReplace = utf8ToLatin($nameCat);
                        $url = $nameReplace . '-' . $cat_id;
                        ?>
                       <li ><a style="color: black;" href="<?php echo $url ?>"><?php echo $array['name'] ?></a></li>
                      <?php } ?>
                    </ul>
                </div>
                <div class="product-slider owl-carousel">
                    <?php while ($row = mysqli_fetch_assoc($pro_New)) {
                        $name = $row['name'];
                        $id = $row['id'];
                        $nameReplace = utf8ToLatin($name);
                        $url = $nameReplace . '-' . $id . '.html';
                        ?>
                        <div class="product-item">
                            <div class="pi-pic">
                                <img src="files/uploads/<?php echo $row['image'] ?>" alt="" style="with: 270px;height: 330px;">

                                
                                <ul>                                   
                                    <li class="quick-view"><a href="product/<?php echo $url ?>">+ Quick View</a></li>
                                   
                                </ul>
                            </div>
                            <div class="pi-text">
                                <div class="catagory-name"></div>
                                <a href="product/<?php echo $url; ?>">
                                    <h5><?php echo $row['name'] ?></h5>
                                </a>
                                <div class="product-price">
                                    <?php echo $row['price'] ?>VNĐ
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!-- Latest Blog Section Begin -->
<section class="latest-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>From The Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
        <?php while($arNews=mysqli_fetch_assoc($resultNews)){
             $titles=$arNews['title'];
             $ids=$arNews['id'];
             $nameReplaceBlog = utf8ToLatin($titles);
             $urls = $nameReplaceBlog . '-' . $ids.'.html';
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="single-latest-blog">
                    <img src="files/uploads/<?php echo $arNews['img'] ?>" alt=""  style="with: 270px;height: 300px;">
                    <div class="latest-text">
                        <div class="tag-list">
                            <div class="tag-item">
                                <i class="fa fa-calendar-o"></i>
                               <?php echo $arNews['created_at'] ?>
                            </div>
                            <!-- <div class="tag-item">
                                <i class="fa fa-comment-o"></i>
                                5
                            </div> -->
                        </div>
                        <a href="tin-tuc/<?php echo $urls; ?>">
                            <h4><?php echo $arNews['title'] ?></h4>
                        </a>
                        <p><?php echo $arNews['introtext'] ?></p>
                    </div>
                </div>
            </div>
       <?php } ?>
           
        </div>
        <div class="benefit-items">
            <div class="row">
                <div class="col-lg-4">
                    <div class="single-benefit">
                        <div class="sb-icon">
                            <img src="templates/basket/img/icon-1.png" alt="">
                        </div>
                        <div class="sb-text">
                            <h6>Free Shipping</h6>
                            <p>For all order over 99$</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-benefit">
                        <div class="sb-icon">
                            <img src="templates/basket/img/icon-2.png" alt="">
                        </div>
                        <div class="sb-text">
                            <h6>Delivery On Time</h6>
                            <p>If good have prolems</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-benefit">
                        <div class="sb-icon">
                            <img src="templates/basket/img/icon-1.png" alt="">
                        </div>
                        <div class="sb-text">
                            <h6>Secure Payment</h6>
                            <p>100% secure payment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest Blog Section End -->



<!-- Footer Section Begin -->
<?php require_once 'templates/basket/inc/footer.php' ?>