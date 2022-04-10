<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php
$name=$_SESSION['adminname'];
$sql = "SELECT * FROM admin WHERE name='{$name}'";
$result = $mysqli->query($sql);

$admin=mysqli_fetch_assoc($result);
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="admin/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Quản lý cửa hàng</div>
                <a class="nav-link" href="admin/news/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-newspaper"></i></div>
                    Tin tức
                </a>
                <a class="nav-link" href="admin/product/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-shoe-prints"></i></div>
                    Sản phẩm
                </a>
                <a class="nav-link" href="admin/category/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Danh mục
                </a>
                <a class="nav-link" href="admin/subcat/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Danh mục con
                </a>
                <a class="nav-link" href="admin/comment/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-comments"></i></div>
                   Bình luận
                </a>
                <div class="sb-sidenav-menu-heading">Quản lý bán hàng</div>
                <a class="nav-link" href="admin/contact/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                    Liên hệ
                </a>

                <a class="nav-link" href="admin/user/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Khách hàng
                </a>
                <a class="nav-link" href="admin/transaction/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-exchange-alt"></i></div>
                    Giao dịch
                </a>
                <?php if($admin['level'] == 1){ 
              echo '<div class="sb-sidenav-menu-heading">Quản lý Thành viên</div>
                <a class="nav-link" href="admin/admin/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                    Admin
                </a>';
              } ?>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php echo $_SESSION['adminname']; ?>
        </div>
    </nav>
</div>