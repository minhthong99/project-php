<?php require_once '../../templates/admin/inc/header.php' ?>
<?php require_once '../../util/DBConnectionUtil.php'; ?>
<div id="layoutSidenav">
    <?php require_once '../../templates/admin/inc/leftbar.php'  ?>
    <div id="layoutSidenav_content">

        <?php

        $id = intval($_GET['id']);
        if (isset($_POST['submit'])) {

            $subcat = $_POST['subcat'];
            $cat_id = $_POST['cat_id'];
            $query = "UPDATE subcat SET subcategory='$subcat',category_id='$cat_id' WHERE id='$id' ";
            $resultCat = $mysqli->query($query); 
        }
        ?>
        <div class="container-fluid">
            <h4 class="mt-4">Sub Category</h4>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Tables</li>
            </ol>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text">Sửa Danh mục</h5>
                    <div class="f-right">
                        <a href="" data-toggle="modal" data-target="#textual-input-Modal"><i class="icofont icofont-code-alt"></i></a>
                    </div>
                </div>
                <div class="modal-body">
                    <?php if (isset($_POST['submit'])) { ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Well done!</strong> <?php echo ("Category Update !!"); ?>
                        </div>
                    <?php } ?>
                    <div class="card-block">
                        <form method="POST">
                            <?php
                            $sql = "SELECT cat.cat_id,cat.name,subcat.subcategory FROM subcat JOIN cat ON cat.cat_id = subcat.category_id WHERE subcat.id='$id'";
                            $result = $mysqli->query($sql);
                            while ($arCat = mysqli_fetch_assoc($result)) {      ?>
                                <div class="form-group ">
                                    <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Sub Category Name</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" placeholder="Enter category name " name="subcat" type="text" value="<?php echo $arCat['subcategory'] ?>" required>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Category</label>
                                    <div class="col-sm-10">
                                        <select name="cat_id" id="" class="form-control">
                                            <option value="<?php echo $arCat['cat_id'] ?>"><?php echo $catname=$arCat['name'] ?></option>
                                            <?php $sql = $mysqli->query("SELECT * FROM cat");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                echo $cat = $row['name'];
													if ($catname == $cat) {
																continue;
															} else {
                                            ?>
                                                <option value="<?php echo $row['cat_id'] ?>"><?php echo $row['name'] ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <button type="submit" name="submit" class="btn btn-success waves-effect waves-light m-r-30">Update</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <?php require_once '../../templates/admin/inc/footer.php' ?>