<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php


$queryTSD = "SELECT count(*) AS TSD FROM product";
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

$stmt = $mysqli->prepare("SELECT * FROM product ORDER BY name LIMIT ?,?");

if ($stmt) {
    //offset

    $stmt->bind_param('ii', $offset, $limit);
    $stmt->execute();
    $ketqua = $stmt->get_result();

?>
    <?php require_once '../../templates/admin/inc/header.php'; ?>

    <div id="layoutSidenav">
        <?php require_once '../../templates/admin/inc/leftbar.php';  ?>
        <div id="layoutSidenav_content">
            
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Product</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Product</a></li>
                        <li class="breadcrumb-item active">Manage Product</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Danh sách sản phẩm
                            
                                <button type="submit" class="btn "><a href="admin/product/add.php">Add</a></button>
                        
                        </div>


                        <div class="card-body">
                            <?php if (isset($_GET['msg']) || !empty($_GET['msg'])) { ?>
                                <div class="alert alert-warning">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Oh snap!</strong> <?php echo ($_GET['msg']); ?>
                                </div>
                            <?php } ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                    <tr>
                                        <th>Id</th>
                                        <th width="100px">Hình</th>
                                        <th>Product Name</th>
                                        <th>Số lượng trong kho</th>                                        
                                        <th>Category </th>
                                        <th>Subcategory</th>
                                        <th>Product Creation Date</th>
                                        <th>Nhập hàng</th>
                                        <th>Action</th>
                                    </tr>                                  
                                        <?php $query = "SELECT product.*,cat.name as catName,subcat.subcategory  FROM product  JOIN cat ON product.cat_id = cat.cat_id JOIN subcat ON subcat.id=product.subcat_id ORDER BY product.id DESC LIMIT {$offset},{$limit} ";
                                        $result = $mysqli->query($query);
                                        $stt = 1;
                                        while ($arPro = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $stt++ ?></td>
                                                <td><img width="70" src="files/uploads/<?php echo $arPro['image'] ?>" alt=""></td>
                                                <td><?php echo $arPro['name'] ?></td>
                                                <td><?php echo $arPro['quantity'] ?></td>                                               
                                                <td><?php echo $arPro['catName'] ?></td>
                                                <td><?php echo $arPro['subcategory'] ?></td>
                                                <td><?php echo $arPro['created'] ?></td>
                                                <td><a href="admin/product/import.php?id=<?php echo $arPro['id'] ?>" class="btn btn-success">Nhập hàng</a></td>
                                                <td class="center">                                                   
                                                        <a href="admin/product/edit.php?id=<?php echo $arPro['id']; ?>" class="btn btn-primary"><i class="fa fa-edit"></i>Sửa</a>                                                 
                                                    <a href="admin/product/delete.php?id=<?php echo $arPro['id']; ?>" onclick="return confirm('Bạn có thật sự muốn xóa không ? ')" class="btn btn-danger"><i class="fa fa-delete"></i>Delete</a>
                                                </td>
                                            </tr>
                                        <?php    } ?>
                                    </form>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="dataTables_info" id="dataTables-example_info" style="margin-top:27px">Hiển thị từ <?php echo $current_page ?> đến <?php echo $tongsotrang ?> của <?php echo $result->num_rows; ?> kết quả </div>
                                    </div>
                                    <div class="col-sm-6" style="text-align: right;">
                                        <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                                            <?php if ($tongsotrang > 0) { ?>
                                                <ul class="pagination">
                                                    <?php if ($current_page > 1) { ?>
                                                        <li class="prev"><a href="admin/product/index.php?page=<?php echo $current_page - 1 ?>">Pre</a></li>
                                                    <?php } ?>

                                                    <?php if ($current_page > 3) { ?>
                                                        <li class="start"><a href="admin/product/index.php?page=1">1</a></li>

                                                    <?php } ?>

                                                    <?php if ($current_page - 2 > 0) { ?>
                                                        <li class="page"><a href="admin/product/index.php?page=<?php echo $current_page - 2 ?>"><?php echo $current_page - 2 ?></a></li>
                                                    <?php } ?>
                                                    <?php if ($current_page - 1 > 0) { ?>
                                                        <li class="page"><a href="admin/product/index.php?page=<?php echo $current_page - 1 ?>"><?php echo $current_page - 1 ?></a></li>
                                                    <?php } ?>

                                                    <li class="paginate_button active"><a href="admin/product/index.php?page=<?php echo $current_page ?>"><?php echo $current_page ?></a></li>

                                                    <?php if ($current_page + 1 < $tongsotrang + 1) { ?>
                                                        <li class="page"><a href="admin/product/index.php?page=<?php echo $current_page + 1 ?>"><?php echo $current_page + 1 ?></a></li>
                                                    <?php } ?>
                                                    <?php if ($current_page + 2 < $tongsotrang + 1) { ?>
                                                        <li class="page"><a href="admin/product/index.php?page=<?php echo $current_page + 2 ?>"><?php echo $current_page + 2 ?></a></li>
                                                    <?php } ?>

                                                    <?php if ($current_page  < $tongsotrang - 2) { ?>

                                                        <li class="end"><a href="admin/product/index.php?page=<?php echo $tongsotrang ?>"><?php echo $tongsotrang ?></a></li>
                                                    <?php } ?>

                                                    <?php if ($current_page < $tongsotrang) { ?>
                                                        <li class="next"><a href="admin/product/index.php?page=<?php echo $current_page + 1 ?>">Next</a></li>
                                                    <?php } ?>
                                                </ul>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php require_once '../../templates/admin/inc/footer.php' ?>
        <?php $stmt->close();
    } ?>