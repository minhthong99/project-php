<?php require_once '../../templates/admin/inc/header.php' ?>
<?php require_once '../../util/DBConnectionUtil.php'; ?>
<div id="layoutSidenav">
    <?php require_once '../../templates/admin/inc/leftbar.php'  ?>
    <div id="layoutSidenav_content">

        <?php

        $cat_id =intval( $_GET['cat_id']);
        if (isset($_POST['submit'])) {

            $name = $_POST['name'];
            $description = $_POST['description'];
            $query = "UPDATE cat SET name='$name',cat_description='$description' WHERE cat_id='$cat_id' ";
            $resultCat = $mysqli->query($query);
      
        }
        ?>
        <div class="container-fluid">
            <h1 class="mt-4">Category</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="admin/dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit Category</li>
            </ol>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text">Sửa Danh mục</h5>
                    <div class="f-right">
                        <a href="" data-toggle="modal" data-target="#textual-input-Modal"><i class="icofont icofont-code-alt"></i></a>
                    </div>
                </div>
                <div class="modal-body">
                <?php if(isset($_POST['submit'])){ ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Well done!</strong> <?php echo ("Category Update !!"); ?>
                            </div>
                            <?php } ?>
                    <div class="card-block">
                        <form method="POST">
                            <?php 
                            $sql = "SELECT * FROM cat WHERE cat_id = {$cat_id}";
                            $result = $mysqli->query($sql);
                            while ($arCat=mysqli_fetch_assoc($result)){      ?>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Category Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="name" type="text" value="<?php echo $arCat['name'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="description" cols="30" rows="5"><?php echo $arCat['cat_description'] ?></textarea>
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