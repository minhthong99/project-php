<?php require_once '../../templates/admin/inc/header.php' ?>
<?php require_once '../../util/DBConnectionUtil.php'; ?>
<div id="layoutSidenav">
    <?php require_once '../../templates/admin/inc/leftbar.php'  ?>
    <div id="layoutSidenav_content">

        <?php
        #Select
        $id = $_GET['id'];
        $select = "SELECT * FROM news WHERE id = {$id}";
        if ($mysqli->query($select)) {
            $infoNew = mysqli_fetch_assoc($mysqli->query($select));
        }
        #update
        #thuật toán  đặt cờ hiệu
        if (isset($_POST['submit'])) {
            $error = array();
            if ($_POST['title'] && $_POST['full'] ) {
                $title = $_POST['title'];
                $full = $_POST['full'];               
                $intro = $_POST['intro'];               
            } else {
                $error['name'] = 'Chưa nhập tiêu đề';
                $error['full'] = 'Chưa nhập chi tiết';               
             }
            if (empty($error)) {


                #b2 viết câu lệnh truy vấn
                $query= " UPDATE `news` SET `title`='{$title}',`introtext`='{$intro}',`fulltext`='{$full}' WHERE  id={$id}";
               
                #b3 kiem tra anh
                if (isset($_FILES['image']['name'])) {
                    $file_name = $_FILES['image']['name'];
                    $arFile = explode('.', $file_name);
                    $typeFile = end($arFile);
                    $newFileName = 'Product-' . time() . '.' . $typeFile;
                    $tmp_name = $_FILES['image']['tmp_name'];
                    $resultUpload =  move_uploaded_file($tmp_name, '../../files/uploads/' . $newFileName);

                    if ($resultUpload) {
                        $query= " UPDATE `news` SET `title`='{$title}',`introtext`='{$intro}',`fulltext`='{$full}',`img`='{$newFileName}' WHERE  id={$id}";
                    }
                }
                #b4 thông báo kết quả
                $result = $mysqli->query($query);               
            }
        }

        ?>
        <div class="container-fluid">
            <h1 class="mt-4">News</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit News</li>
            </ol>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text">Cập nhật bài viết</h5>
                    <div class="f-right">
                        <a href="" data-toggle="modal" data-target="#textual-input-Modal"><i class="icofont icofont-code-alt"></i></a>
                    </div>
                </div>
                <div class="modal-body">
                <?php if(isset($_POST['submit'])){ ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Well done!</strong> <?php echo ("News Updated Successfully !!"); ?>
                            </div>
                            <?php } ?>
                    <div class="card-block">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Tiêu đề bài viết</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="title" type="text" value="<?php echo $infoNew['title'] ?>">
                                    <p class="text-danger"><?php echo isset($error['title']) ? $error['title'] : '' ?></p>
                                </div>
                            </div>                          
                        
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Hình sản phẩm</label>
                                <div class="col-sm-10">
                                    <input name="image" type="file">

                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Mô tả ngắn</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="intro" type="text" value="<?php echo $infoNew['introtext'] ?>">
                                 
                                </div>
                            </div>              
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Chi tiết bài viết</label>
                                <div class="col-sm-10">
                                     <textarea id="editor1" class="form-control " rows="5" name="full"><?php echo $infoNew['fulltext'] ?></textarea>                                   
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