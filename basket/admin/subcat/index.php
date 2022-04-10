
<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php
$queryTSD = "SELECT count(*) AS TSD FROM cat";
$resultTSD = $mysqli->query($queryTSD);
$arTmp = mysqli_fetch_assoc($resultTSD);
$tongSoDong = $arTmp['TSD'];
// số truyện trên 1 trang
$limit = 4;

//tổng số trang
$tongsotrang = ceil($tongSoDong / $limit);

//trang hiện tại
$current_page = 1;
if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
}
//offset
$offset = ($current_page - 1) * $limit;
$stmt = $mysqli->prepare("SELECT * FROM cat ORDER BY name LIMIT ?,?");

if ($stmt) {    //offset

    $stmt->bind_param('ii', $offset, $limit);
    $stmt->execute();
    $ketqua = $stmt->get_result();

?>
    <?php require_once '../../templates/admin/inc/header.php'; ?>

    <div id="layoutSidenav">
        <?php require_once '../../templates/admin/inc/leftbar.php';  ?>
        <div id="layoutSidenav_content">
            <?php
            if (isset($_POST['submit'])) {               
              
                $category = $_POST['category'];
                $subcat = $_POST['subcat'];           
                $query = "INSERT INTO subcat(category_id,subcategory) VALUES ('{$category}','{$subcat}')";
                $resultCat = $mysqli->query($query);
                $_SESSION['sucess']="Category Created !!";
        
            }
      
            ?>
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Sub Category</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Sub Category</a></li>
                        <li class="breadcrumb-item active">Sub Category Manager</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Category
                        </div>
                        <div class="card-body">
                            <?php if(isset($_POST['submit'])){ ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Well done!</strong> <?php echo ($_SESSION['sucess']); ?>
                            </div>
                            <?php } ?>
                         <?php if (isset($_GET['msg']) || !empty($_GET['msg'])) { ?>
										<div class="alert alert-warning">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Oh snap!</strong> <?php echo ($_GET['msg']); ?>
										</div>
									<?php } ?>
                            <div class="table-responsive">
                                <form method="POST">
                                    <div class="form-group ">
                                        <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Sub Category Name</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="subcat" type="text" value="" required>                                            
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Category</label>
                                        <div class="col-sm-10">
                                            <select name="category" id="" class="form-control">
                                                <option value="">Select Category</option>
                                                <?php $sql=$mysqli->query("SELECT * FROM cat");
                                                    while ($row = mysqli_fetch_assoc($sql)){
                                                ?>
                                                <option value="<?php echo $row['cat_id'] ?>"><?php echo $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-success waves-effect waves-light m-r-30">Create</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                           Sub Category                        
                        </div>


                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                    <tr>
                                        <th>Id</th>
                                        <th>Sub Category</th>
                                        <th>Category</th>                                       
                                        <th>Creation date</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>

                                    <?php $query = "SELECT subcat.id,subcat.subcategory,cat.name,subcat.created,subcat.updated FROM subcat JOIN cat ON cat.cat_id=subcat.category_id";

                                    $result = $mysqli->query($query);
                                    $stt = 1;
                                    while ($arCat = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $stt++ ?></td>
                                            <td><?php echo $arCat['subcategory'] ?></td>
                                            <td><?php echo $arCat['name'] ?></td>
                                            <td><?php echo $arCat['created'] ?></td>
                                            <td><?php echo $arCat['updated'] ?></td>
                                            <td class="center">
                                                <a href="admin/subcat/edit.php?id=<?php echo $arCat['id']; ?>" class="btn btn-primary"><i class="fa fa-edit"></i>Sửa</a>
                                                <a href="admin/subcat/delete.php?id=<?php echo $arCat['id']; ?>" onclick="return confirm('Bạn có thật sự muốn xóa không ? ')" class="btn btn-danger"><i class="fa fa-delete"></i>Delete</a>
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
                                                        <li class="prev"><a href="admin/subcat/index.php?page=<?php echo $current_page - 1 ?>">Pre</a></li>
                                                    <?php } ?>

                                                    <?php if ($current_page > 3) { ?>
                                                        <li class="start"><a href="admin/subcat/index.php?page=1">1</a></li>

                                                    <?php } ?>

                                                    <?php if ($current_page - 2 > 0) { ?>
                                                        <li class="page"><a href="admin/subcat/index.php?page=<?php echo $current_page - 2 ?>"><?php echo $current_page - 2 ?></a></li>
                                                    <?php } ?>
                                                    <?php if ($current_page - 1 > 0) { ?>
                                                        <li class="page"><a href="admin/subcat/index.php?page=<?php echo $current_page - 1 ?>"><?php echo $current_page - 1 ?></a></li>
                                                    <?php } ?>

                                                    <li class="paginate_button active"><a href="admin/subcat/index.php?page=<?php echo $current_page ?>"><?php echo $current_page ?></a></li>

                                                    <?php if ($current_page + 1 < $tongsotrang + 1) { ?>
                                                        <li class="page"><a href="admin/subcat/index.php?page=<?php echo $current_page + 1 ?>"><?php echo $current_page + 1 ?></a></li>
                                                    <?php } ?>
                                                    <?php if ($current_page + 2 < $tongsotrang + 1) { ?>
                                                        <li class="page"><a href="admin/subcat/index.php?page=<?php echo $current_page + 2 ?>"><?php echo $current_page + 2 ?></a></li>
                                                    <?php } ?>

                                                    <?php if ($current_page  < $tongsotrang - 2) { ?>

                                                        <li class="end"><a href="admin/subcat/index.php?page=<?php echo $tongsotrang ?>"><?php echo $tongsotrang ?></a></li>
                                                    <?php } ?>

                                                    <?php if ($current_page < $tongsotrang) { ?>
                                                        <li class="next"><a href="admin/subcat/index.php?page=<?php echo $current_page + 1 ?>">Next</a></li>
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