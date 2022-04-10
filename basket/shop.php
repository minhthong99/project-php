<?php require_once('templates/basket/inc/header.php'); ?>
<?php $currentpage = 'shop'; ?>
<!--  -->
<?php require_once('templates/basket/inc/leftbar.php'); ?>
<!-- Header End -->
<?php require_once 'util/DBConnectionUtil.php' ?>
<?php

if (isset($_GET['cat_id'])) {
    $queryTSD = "SELECT count(*) AS TSD FROM product WHERE cat_id='{$_GET['cat_id']}' ";
    if (isset($_GET['subcat_id'])) {
        $queryTSD = "SELECT count(*) AS TSD FROM product WHERE cat_id='{$_GET['cat_id']}' AND subcat_id='{$_GET['subcat_id']}'  ";
    }
} else {
    $queryTSD = "SELECT count(*) AS TSD FROM product ";
}

$resultTSD = $mysqli->query($queryTSD);
$arTmp = mysqli_fetch_assoc($resultTSD);
$tongSoDong = $arTmp['TSD'];
// số sp trên 1 trang
$limit = 6;

//tổng số trang
$tongsotrang = ceil($tongSoDong / $limit);

//trang hiện tại
$current_page = 1;
if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
}
//tim start
$offset = ($current_page - 1) * $limit;

$stmt = $mysqli->prepare("SELECT * FROM product ORDER BY name LIMIT ?,?");

if ($stmt) {
    //offset
    $stmt->bind_param('ii', $offset, $limit);
    $stmt->execute();
    $ketqua = $stmt->get_result();

?>
    <!-- Breadcrumb Section Begin -->
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

                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                    <div class="filter-widget">
                        <h4 class="fw-title">Categories</h4>
                        <?php if (isset($_GET['cat_id'])) { ?>
                            <ul class="filter-catagories">
                                <?php
                                $query = "SELECT * FROM subcat WHERE category_id='{$_GET['cat_id']}'";
                                $resultCat = $mysqli->query($query);
                                while ($arCat = mysqli_fetch_assoc($resultCat)) {
                                    // $nameCat = $arCat['subcategory'];
                                    $cat_id = $arCat['category_id'];
                                    $subcat_id = $arCat['id'];
                                    // $nameReplace = utf8ToLatin($nameCat);
                                    // $url = $nameReplace . '-' . $cat_id . '-subcat-' . $subcat_id;
                                ?>
                                    <li><a href="shop.php?cat_id=<?php echo $cat_id; ?>&subcat_id=<?php echo $subcat_id; ?>"><?php echo $arCat['subcategory'] ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>

                </div>

                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="product-show-option">
                        <div class="row">
                            <?php
                            if (isset($_GET['cat_id'])) {
                                $SumProduct = "SELECT count(*) AS tong FROM product WHERE  cat_id='{$_GET['cat_id']}'";
                                if (isset($_GET['subcat_id'])) {
                                    $SumProduct = "SELECT count(*) AS tong FROM product WHERE cat_id='{$_GET['cat_id']}' AND subcat_id='{$_GET['subcat_id']}'";
                                }
                            }
                            $resultSum = $mysqli->query($SumProduct);
                          
                            ?>
                            <div class="col-lg-5 col-md-5 text-left">
                                <p>Show <?php echo $current_page ?> - <?php echo $tongsotrang ?> của <?php while(  $sum = mysqli_fetch_assoc($resultSum)){echo $sum['tong'];} ?> Sản phẩm </p>
                            </div>
                        </div>
                    </div>
                    <div class="product-list">
                        <?php if (isset($_GET['cat_id'])) { ?>
                            <div class="row">
                                <?php
                                if (isset($_GET['subcat_id'])) {
                                    $resultPro = mysqli_query($mysqli, "SELECT * FROM product WHERE cat_id='{$_GET['cat_id']}' AND subcat_id='{$_GET['subcat_id']}' ORDER BY subcat_id DESC LIMIT {$offset},{$limit}");
                                } else {
                                    $resultPro = mysqli_query($mysqli, "SELECT * FROM product WHERE cat_id='{$_GET['cat_id']}' ORDER BY id DESC LIMIT {$offset},{$limit}");
                                }
                                while ($arPro = mysqli_fetch_assoc($resultPro)) {
                                    $namePro = $arPro['name'];
                                    $Pro_id = $arPro['id'];
                                    $nameReplace = utf8ToLatin($namePro);
                                    $url = $nameReplace . '-' . $Pro_id . '.html';

                                ?>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="product-item">
                                            <div class="pi-pic">
                                                <img src="files/uploads/<?php echo $arPro['image'] ?>" alt="" style="with:200px;height: 200px;">
                                              
                                                <ul>
                                                  
                                                    <li class="quick-view"><a href="product/<?php echo $url ?>">+ Quick View</a></li>
                                                   
                                                </ul>
                                            </div>
                                            <div class="pi-text">
                                                <a href="<?php echo $url ?>">
                                                    <h6><?php echo $arPro['name'] ?></h6>
                                                </a>
                                                <div class="product-price">

                                                    <?php echo $arPro['price'] ?>đ
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <?php if (isset($_GET['cat_id'])) { ?>
                                <!-- <?php $num = mysqli_fetch_assoc($mysqli->query("SELECT name FROM cat WHERE cat_id='{$_GET['cat_id']}'")) ?> -->

                                <div class="col-sm-12">
                                    <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                                        <?php if ($tongsotrang > 0) { ?>
                                            <ul class="pagination">
                                                <?php if ($current_page > 1) { ?>
                                                    <li class="prev"><a href="shop.php?cat_id=<?php echo $_GET['cat_id']; ?> <?php if (isset($_GET['subcat_id'])) { ?>&subcat_id=<?php echo $_GET['subcat_id']; ?> <?php } ?>&page=<?php echo $current_page - 1 ?>">Pre</a></li>

                                                <?php } ?>

                                                <?php if ($current_page > 3) { ?>
                                                    <li class="start"><a href="shop.php?cat_id=<?php echo $_GET['cat_id']; ?><?php if (isset($_GET['subcat_id'])) { ?>&subcat_id=<?php echo $_GET['subcat_id']; ?> <?php } ?>&page=1">1</a></li>

                                                <?php } ?>

                                                <?php if ($current_page - 2 > 0) { ?>
                                                    <li class="page"><a href="shop.php?cat_id=<?php echo $_GET['cat_id']; ?><?php if (isset($_GET['subcat_id'])) { ?>&subcat_id=<?php echo $_GET['subcat_id']; ?> <?php } ?>&page=<?php echo $current_page - 2 ?>"><?php echo $current_page - 2 ?></a></li>
                                                <?php } ?>
                                                <?php if ($current_page - 1 > 0) { ?>
                                                    <li class="page"><a href="shop.php?cat_id=<?php echo $_GET['cat_id']; ?><?php if (isset($_GET['subcat_id'])) { ?>&subcat_id=<?php echo $_GET['subcat_id']; ?> <?php } ?>&page=<?php echo $current_page - 1 ?>"><?php echo $current_page - 1 ?></a></li>
                                                <?php } ?>

                                                <li class="paginate_button active"><a href="shop.php?cat_id=<?php echo $_GET['cat_id']; ?><?php if (isset($_GET['subcat_id'])) { ?>&subcat_id=<?php echo $_GET['subcat_id']; ?> <?php } ?>&page=<?php echo $current_page ?>"><?php echo $current_page ?></a></li>

                                                <?php if ($current_page + 1 < $tongsotrang + 1) { ?>
                                                    <li class="page"><a href="shop.php?cat_id=<?php echo $_GET['cat_id']; ?><?php if (isset($_GET['subcat_id'])) { ?>&subcat_id=<?php echo $_GET['subcat_id']; ?> <?php } ?>&page=<?php echo $current_page + 1 ?>"><?php echo $current_page + 1 ?></a></li>
                                                <?php } ?>
                                                <?php if ($current_page + 2 < $tongsotrang + 1) { ?>
                                                    <li class="page"><a href="shop.php?cat_id=<?php echo $_GET['cat_id']; ?><?php if (isset($_GET['subcat_id'])) { ?>&subcat_id=<?php echo $_GET['subcat_id']; ?> <?php } ?>&page=<?php echo $current_page + 2 ?>"><?php echo $current_page + 2 ?></a></li>
                                                <?php } ?>

                                                <?php if ($current_page  < $tongsotrang - 2) { ?>

                                                    <li class="end"><a href="shop.php?cat_id=<?php echo $_GET['cat_id']; ?><?php if (isset($_GET['subcat_id'])) { ?>&subcat_id=<?php echo $_GET['subcat_id']; ?> <?php } ?>&subcat_id=<?php echo $_GET['subcat_id']; ?>&page=<?php echo $tongsotrang ?>"><?php echo $tongsotrang ?></a></li>
                                                <?php } ?>

                                                <?php if ($current_page < $tongsotrang) { ?>
                                                    <li class="next"><a href="shop.php?cat_id=<?php echo $_GET['cat_id']; ?><?php if (isset($_GET['subcat_id'])) { ?>&subcat_id=<?php echo $_GET['subcat_id']; ?> <?php } ?>&page=<?php echo $current_page + 1 ?>">Next</a></li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->
    <!-- Footer Section Begin -->
    <?php require_once('templates/basket/inc/footer.php'); ?>
<?php $stmt->close();
} ?>