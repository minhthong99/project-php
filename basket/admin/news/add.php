<?php require_once '../../templates/admin/inc/header.php' ?>
<?php require_once '../../util/DBConnectionUtil.php'; ?>
<div id="layoutSidenav">
    <?php require_once '../../templates/admin/inc/leftbar.php'  ?>
    <div id="layoutSidenav_content">

        <?php
        if (isset($_POST['submit'])) {
            $error = array();
            if ($_POST['title']  && $_POST['full']) {
                $title = $_POST['title'];
                $intro = $_POST['intro'];
                $full = $_POST['full'];               
            } else {
                $error['title'] = 'Chưa nhập tiêu đề';
                $error['intro'] = 'Chưa nhập mô tả';
                $error['full'] = 'Chưa nhập  chi tiết';
            }
            if (empty($error)) {
                if (isset($_FILES['image']['name'])) {

                    $file_name = $_FILES['image']['name'];
                    $arFile = explode('.', $file_name);
                    $typeFile = end($arFile);
                    $newFileName = 'Product-' . time() . '.' . $typeFile;
                    $tmp_name = $_FILES['image']['tmp_name'];
                    $resultUpload = move_uploaded_file($tmp_name, '../../files/uploads/' . $newFileName);
                    if ($resultUpload) {

                        $query = "INSERT INTO `news`(`title`, `introtext`, `fulltext`, `img`) VALUES ('{$title}','{$intro}','{$full}','{$newFileName}')";
                    }
                }
                $result = $mysqli->query($query);
                if ($result) {
                    $_SESSION['success'] ="Thêm tin tức thành công";
                  } else {
                  $_SESSION['error']= "không thể thêm tin tức ";
                  }
            }
        }
        ?>
        <div class="container-fluid">
            <h1 class="mt-4">Add News</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="admin/news/index.php">New</a></li>
                <li class="breadcrumb-item active">Add New</li>
            </ol>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text">Thêm bài viết mới</h5>
                    <div class="f-right">
                        <a href="" data-toggle="modal" data-target="#textual-input-Modal"><i class="icofont icofont-code-alt"></i></a>
                    </div>
                </div>
                <div class="modal-body">
                <?php if ( !empty($_SESSION['success'])) { ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Well done!</strong> <?php echo htmlentities($_SESSION['success']); ?><?php echo htmlentities($_SESSION['success'] = ""); ?>
                        </div>
                    <?php } ?>


                    <?php if (isset($_SESSION['error'] )) { ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Oh snap!</strong> <?php echo htmlentities($_SESSION['error']); ?><?php echo htmlentities($_SESSION['error'] = ""); ?>
                        </div>
                    <?php } ?>
                    <div class="card-block">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Tiêu đề bài viết</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="title" type="text" value="">
                                    <p class="text-danger"><?php echo isset($error['title']) ? $error['title'] : '' ?></p>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Hình đại diện</label>
                                <div class="col-sm-10">
                                    <input name="image" type="file">

                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Mô tả ngắn</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="intro" type="text" value="">
                                    <p class="text-danger"><?php echo isset($error['intro']) ? $error['intro'] : '' ?></p>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Chi tiết bài viết</label>
                                <div class="col-sm-10">
                                    <textarea id="editor1" class="form-control " rows="5" name="full"></textarea>
                                    <p class="text-danger"><?php echo isset($error['full']) ? $error['full'] : '' ?></p>
                                    <script type="text/javascript">
                                        CKEDITOR.replace('editor1', {
                                            filebrowserBrowseUrl: 'library/ckfinder/ckfinder.html',
                                            filebrowserImageBrowseUrl: 'library/ckfinder/ckfinder.html?type=Images',
                                            filebrowserUploadUrl: 'library/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                            filebrowserImageUploadUrl: 'library/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
                                        });
                                    </script>
                                </div>
                            </div>                           
                                <button type="submit" name="submit" class="btn btn-success waves-effect waves-light m-r-30">Submit</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <?php require_once '../../templates/admin/inc/footer.php' ?>