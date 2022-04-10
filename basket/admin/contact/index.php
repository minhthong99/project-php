<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php
$queryTSD = "SELECT count(*) AS TSD FROM contact";
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

$stmt = $mysqli->prepare("SELECT * FROM contact ORDER BY name LIMIT ?,?");

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
                    <h1 class="mt-4">Contact</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manager Contact</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Quản lý liện hệ
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Chức năng</th>
                                    </tr>

                                    <?php $query = "SELECT *FROM contact LIMIT {$offset},{$limit}  ";
                                    $result = $mysqli->query($query);
                                    $stt = 1;
                                    while ($arContact = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $stt++ ?></td>
                                            <td><?php echo $arContact['name'] ?></td>
                                            <td><?php echo $arContact['email'] ?></td>
                                            <td><?php echo $arContact['content'] ?></td>
                                            <td class="center">
                                                <a href="admin/contact/delete.php?id=<?php echo $arContact['id']; ?>" onclick="return confirm('Bạn có thật sự muốn xóa không ? ')" class="btn btn-danger"><i class="fa fa-delete"></i>Delete</a>
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
                                                        <li class="prev"><a href="admin/contact/index.php?page=<?php echo $current_page - 1 ?>">Pre</a></li>
                                                    <?php } ?>

                                                    <?php if ($current_page > 3) { ?>
                                                        <li class="start"><a href="admin/contact/index.php?page=1">1</a></li>

                                                    <?php } ?>

                                                    <?php if ($current_page - 2 > 0) { ?>
                                                        <li class="page"><a href="admin/contact/index.php?page=<?php echo $current_page - 2 ?>"><?php echo $current_page - 2 ?></a></li>
                                                    <?php } ?>
                                                    <?php if ($current_page - 1 > 0) { ?>
                                                        <li class="page"><a href="admin/contact/index.php?page=<?php echo $current_page - 1 ?>"><?php echo $current_page - 1 ?></a></li>
                                                    <?php } ?>

                                                    <li class="paginate_button active"><a href="admin/contact/index.php?page=<?php echo $current_page ?>"><?php echo $current_page ?></a></li>

                                                    <?php if ($current_page + 1 < $tongsotrang + 1) { ?>
                                                        <li class="page"><a href="admin/contact/index.php?page=<?php echo $current_page + 1 ?>"><?php echo $current_page + 1 ?></a></li>
                                                    <?php } ?>
                                                    <?php if ($current_page + 2 < $tongsotrang + 1) { ?>
                                                        <li class="page"><a href="admin/contact/index.php?page=<?php echo $current_page + 2 ?>"><?php echo $current_page + 2 ?></a></li>
                                                    <?php } ?>

                                                    <?php if ($current_page  < $tongsotrang - 2) { ?>

                                                        <li class="end"><a href="admin/contact/index.php?page=<?php echo $tongsotrang ?>"><?php echo $tongsotrang ?></a></li>
                                                    <?php } ?>

                                                    <?php if ($current_page < $tongsotrang) { ?>
                                                        <li class="next"><a href="admin/contact/index.php?page=<?php echo $current_page + 1 ?>">Next</a></li>
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