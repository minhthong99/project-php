<?php require_once('templates/basket/inc/header.php'); ?>
<?php $currentpage = 'blog'; ?>
<?php require_once('templates/basket/inc/leftbar.php'); ?>
<?php require_once 'util/DBConnectionUtil.php'; ?>
<!-- Header End -->
<?php
$queryTSD = "SELECT count(*) AS TSD FROM news";
$resultTSD = $mysqli->query($queryTSD);
$arTmp = mysqli_fetch_assoc($resultTSD);
$tongSoDong = $arTmp['TSD'];
// số truyện trên 1 trang
$limit = 5;

//tổng số trang
$tongsotrang = ceil($tongSoDong / $limit);

//trang hiện tại
$current_page = 1;
if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
}
//offset
$offset = ($current_page - 1) * $limit;

$stmt = $mysqli->prepare("SELECT * FROM news ORDER BY id  LIMIT ?,?");

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
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->
    <?php
    $queryCat = "SELECT * FROM cat ";
    $result = $mysqli->query($queryCat);
    $queryNew = "SELECT * FROM news ORDER BY id DESC  LIMIT 3";
    $queryNews = "SELECT * FROM news  LIMIT {$offset},{$limit} ";
    $resultNew = $mysqli->query($queryNew);
    $resultNews = $mysqli->query($queryNews);
    ?>
    <!-- Blog Section Begin -->
    <section class="blog-section spad">
        <div class="container">
            <div class="row">
               
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1">
                    <div class="blog-sidebar">
                        <div class="blog-catagory">
                            <h4>Categories</h4>
                            <ul>
                                <?php while ($arCat = mysqli_fetch_assoc($result)) {
                                     $nameCat = $arCat['name'];
                                     $cat_id = $arCat['cat_id'];
                                     $nameReplace = utf8ToLatin($nameCat);
                                     $url = $nameReplace . '-' . $cat_id;
                                      ?>
                                    <li><a href="<?php echo $url; ?>"><?php echo $arCat['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="recent-post">
                            <h4>Recent Post</h4>
                            <?php while ($arNew = mysqli_fetch_assoc($resultNew)) {
                                $title=$arNew['title'];
                                $id=$arNew['id'];
                                $nameReplace = utf8ToLatin($title);
                                $url = $nameReplace . '-' . $id.'.html';
                                ?>
                                <div class="recent-blog">
                                    <a href="tin-tuc/<?php echo $url ?>" class="rb-item">
                                        <div class="rb-pic">
                                            <img src="files/uploads/<?php echo $arNew['img'] ?>" alt="">
                                        </div>
                                        <div class="rb-text">
                                            <h6><?php echo $arNew['title'] ?></h6>
                                            <p> <span><?php echo $arNew['created_at'] ?></span></p>
                                        </div>
                                    </a>

                                </div>
                            <?php } ?>
                        </div>
                        <div class="blog-tags">
                            <h4>Product Tags</h4>
                            <div class="tag-item">
                                <a href="blog.php">Shoes</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="row">
                        <?php while ($arNews = mysqli_fetch_assoc($resultNews)) { 
                              $titles=$arNews['title'];
                              $ids=$arNews['id'];
                              $nameReplaceBlog = utf8ToLatin($titles);
                              $urls = $nameReplaceBlog . '-' . $ids.'.html';
                            ?>
                            <div class="col-lg-6 col-sm-6">
                                <div class="blog-item">
                                    <div class="bi-pic">
                                        <img src="files/uploads/<?php echo $arNews['img'] ?>" alt="" style="with: 250px;height: 300px;">
                                    </div>
                                    <div class="bi-text">
                                        <a href="tin-tuc/<?php echo $urls; ?>">
                                            <h4><?php echo $arNews['title'] ?></h4>
                                        </a>
                                        <h6>  <?php echo $arNews['introtext'] ?></h6>
                                        <p> <span>- <?php echo $arNews['created_at'] ?></span></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="col-sm-12">
                        <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                            <?php if ($tongsotrang > 0) { ?>
                                <ul class="pagination">
                                    <?php if ($current_page > 1) { ?>
                                        <li class="prev"><a href="blog.php?page=<?php echo $current_page - 1 ?>">Pre</a></li>
                                    <?php } ?>

                                    <?php if ($current_page > 3) { ?>
                                        <li class="start"><a href="blog.php?page=1">1</a></li>

                                    <?php } ?>

                                    <?php if ($current_page - 2 > 0) { ?>
                                        <li class="page"><a href="blog.php?page=<?php echo $current_page - 2 ?>"><?php echo $current_page - 2 ?></a></li>
                                    <?php } ?>
                                    <?php if ($current_page - 1 > 0) { ?>
                                        <li class="page"><a href="blog.php?page=<?php echo $current_page - 1 ?>"><?php echo $current_page - 1 ?></a></li>
                                    <?php } ?>

                                    <li class="paginate_button active"><a href="blog.php?page=<?php echo $current_page ?>"><?php echo $current_page ?></a></li>

                                    <?php if ($current_page + 1 < $tongsotrang + 1) { ?>
                                        <li class="page"><a href="blog.php?page=<?php echo $current_page + 1 ?>"><?php echo $current_page + 1 ?></a></li>
                                    <?php } ?>
                                    <?php if ($current_page + 2 < $tongsotrang + 1) { ?>
                                        <li class="page"><a href="blog.php?page=<?php echo $current_page + 2 ?>"><?php echo $current_page + 2 ?></a></li>
                                    <?php } ?>

                                    <?php if ($current_page  < $tongsotrang - 2) { ?>

                                        <li class="end"><a href="blog.php?page=<?php echo $tongsotrang ?>"><?php echo $tongsotrang ?></a></li>
                                    <?php } ?>

                                    <?php if ($current_page < $tongsotrang) { ?>
                                        <li class="next"><a href="blog.php?page=<?php echo $current_page + 1 ?>">Next</a></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>             

              
             
            </div>
        </div>
    </section>
    <!-- Blog Section End -->



    <!-- Footer Section Begin -->
    <?php require_once('templates/basket/inc/footer.php'); ?>
<?php $stmt->close();
} ?>