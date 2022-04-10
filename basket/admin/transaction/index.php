<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php


$queryTSD = "SELECT count(*) AS TSD FROM orders";
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

$stmt = $mysqli->prepare("SELECT * FROM orders ORDER BY id LIMIT ?,?");

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
                    <h1 class="mt-4">Order Management</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Order Management</a></li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Danh sách đơn hàng

                        </div>


                        <div class="card-body">
                            <?php if (isset($_GET['msg']) || !empty($_GET['msg'])) { ?>
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Well done!</strong> <?php echo ($_GET['msg']); ?>
                                </div>
                            <?php } ?>
                            <?php if (isset($_GET['del_msg']) || !empty($_GET['del_msg'])) { ?>
                                <div class="alert alert-warning">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Oh snap!</strong> <?php echo ($_GET['del_msg']); ?>
                                </div>
                            <?php } ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                    <tr>
                                        <th>Id</th>
                                        <th>Khách hàng</th>
                                        <th>Điện thoại</th>
                                        <th>Địa chỉ</th>
                                        <th>Tổng tiền</th>
                                        <th>Ngày tạo</th>
                                        <th>Trạng thái</th>
                                        <th colspan="2" style="text-align: center;">Xử lý đơn</th>
                                        <th> Thao tác</th>
                                    </tr>

                                    <?php $query = "SELECT orders.*,users.name as user_name,users.phone as phoneuser FROM orders INNER JOIN users ON orders.user_id = users.id ORDER BY orders.id DESC LIMIT {$offset},{$limit} ";
                                    $result = $mysqli->query($query);
                                    $stt = 1;
                                    while ($arTra = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $stt++ ?></td>
                                            <td><?php echo $arTra['user_name'] ?></td>
                                            <td><?php echo $arTra['phoneuser'] ?></td>
                                            <td><?php echo $arTra['shippingAddress'] ?></td>
                                            <td><?php echo $arTra['amount'] ?>VNĐ</td>
                                            <td><?php echo $arTra['created'] ?></td>
                                            <td><?php switch ($arTra['status']) {
                                                    case '0':
                                                        echo 'Đang chờ duyệt';
                                                        break;
                                                    case '1':
                                                        echo 'Đang giao hàng';
                                                        break;
                                                    case '2':
                                                        echo 'Đã giao';
                                                        break;
                                                } ?></td>
                                            <?php if ($arTra['status'] == 1) { ?>
                                                <td><a href="admin/transaction/status.php?id=<?php echo $arTra['id'] ?>" class="btn btn-xs <?php echo $arTra['status'] == 1 ? 'btn-info' : 'btn-success' ?>   "><?php echo $arTra['status'] == 1 ?  'Xác nhận thanh toán' : 'Thành công' ?>
                                                    </a>
                                                </td>
                                            <?php } elseif ($arTra['status'] == 0 || $arTra['status'] == 1) { ?>
                                                <td>

                                                    <a href="admin/transaction/status.php?id=<?php echo $arTra['id'] ?>" class="btn btn-xs <?php echo $arTra['status'] == 0 ? 'btn-danger' : 'btn-info' ?>"><?php echo $arTra['status'] == 0 ? 'Chưa Xử Lý ' : 'Đã Xử Lý' ?></a>
                                                </td>
                                            <?php } else {
                                            ?>
                                                <td></td>
                                            <?php  }
    
                                            ?>
                                            <td> <a href="admin/transaction/detail.php?id=<?php echo $arTra['id']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-eye-open"></i>Xem </a></td>
                                            <td class="center">
                                                <a href="admin/transaction/delete.php?id=<?php echo $arTra['id']; ?>" onclick="return confirm('Bạn có thật sự muốn xóa không ? ')" class="btn btn-danger"><i class="fa fa-delete"></i>Delete</a>
                                            </td>
                                        </tr>
                                    <?php    } ?>
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
                                                        <li class="prev"><a href="admin/transaction/index.php?page=<?php echo $current_page - 1 ?>">Pre</a></li>
                                                    <?php } ?>

                                                    <?php if ($current_page > 3) { ?>
                                                        <li class="start"><a href="admin/transaction/index.php?page=1">1</a></li>

                                                    <?php } ?>

                                                    <?php if ($current_page - 2 > 0) { ?>
                                                        <li class="page"><a href="admin/transaction/index.php?page=<?php echo $current_page - 2 ?>"><?php echo $current_page - 2 ?></a></li>
                                                    <?php } ?>
                                                    <?php if ($current_page - 1 > 0) { ?>
                                                        <li class="page"><a href="admin/transaction/index.php?page=<?php echo $current_page - 1 ?>"><?php echo $current_page - 1 ?></a></li>
                                                    <?php } ?>

                                                    <li class="paginate_button active"><a href="admin/transaction/index.php?page=<?php echo $current_page ?>"><?php echo $current_page ?></a></li>

                                                    <?php if ($current_page + 1 < $tongsotrang + 1) { ?>
                                                        <li class="page"><a href="admin/transaction/index.php?page=<?php echo $current_page + 1 ?>"><?php echo $current_page + 1 ?></a></li>
                                                    <?php } ?>
                                                    <?php if ($current_page + 2 < $tongsotrang + 1) { ?>
                                                        <li class="page"><a href="admin/transaction/index.php?page=<?php echo $current_page + 2 ?>"><?php echo $current_page + 2 ?></a></li>
                                                    <?php } ?>

                                                    <?php if ($current_page  < $tongsotrang - 2) { ?>

                                                        <li class="end"><a href="admin/transaction/index.php?page=<?php echo $tongsotrang ?>"><?php echo $tongsotrang ?></a></li>
                                                    <?php } ?>

                                                    <?php if ($current_page < $tongsotrang) { ?>
                                                        <li class="next"><a href="admin/transaction/index.php?page=<?php echo $current_page + 1 ?>">Next</a></li>
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