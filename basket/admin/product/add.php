<?php require_once '../../templates/admin/inc/header.php' ?>
<?php require_once '../../util/DBConnectionUtil.php'; ?>
<div id="layoutSidenav">
    <?php require_once '../../templates/admin/inc/leftbar.php'  ?>
   
    <div id="layoutSidenav_content">

        <?php
        if (isset($_POST['submit'])) {
            $error = array();
            if ($_POST['name'] && $_POST['price']) {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $detail = $_POST['detail'];
                $cat = $_POST['category'];
                $subcat = $_POST['subcategory'];
                $preview = $_POST['preview'];
                $quantity=$_POST['quantity'];
            } else {
                $error['name'] = 'Chưa nhập tên sản phẩm';
                $error['price'] = 'Chưa nhập giá';
                $error['detail'] = 'Chưa nhập tên chi tiết';
                $error['number'] = 'Chưa nhập số lượng';
            }
            if (empty($error)) {
                if (isset($_FILES['image']['name'])) {

                    $file_name = $_FILES['image']['name'];
                    $arFile = explode('.', $file_name);
                    $typeFile = end($arFile);
                    $newFileName = 'Product-' . time() . '.' . $typeFile;
                    $tmp_name = $_FILES['image']['tmp_name'];
                    move_uploaded_file($tmp_name, '../../files/uploads/' . $newFileName);
                }
                $query = "INSERT INTO product( cat_id,subcat_id,name,detail, price,quantity,preview,image) VALUES ('$cat','$subcat','$name','$detail','$price','$quantity','$preview','{$newFileName}')";
                $result = mysqli_query($mysqli, $query);
                $_SESSION['success'] = "Product Inserted Successfully !!";
                // if ($result) {
                //     echo "thành công";
                //  } else {
                //      echo "không thể thêm sản phẩm";
                //  }
                $id_pro = mysqli_insert_id($mysqli);

                if (isset($_FILES['images']['name'])) {

                    $file_names = $_FILES['images']['name'];
                    foreach ($file_names as $key => $value) {
                        $tmp_names = $_FILES['images']['tmp_name'][$key];
                        move_uploaded_file($tmp_names, '../../files/uploads/' . $value);
                        mysqli_query($mysqli, "INSERT INTO img_products(product_id,image) VALUES ('{$id_pro}','{$value}')");
                    }
                }
            }
        }
        ?>
        <div class="container-fluid">
            <h1 class="mt-4">Product</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="admin/index.php">Product</a></li>
                <li class="breadcrumb-item active">Add Product</li>
            </ol>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text">Thêm mới sản phẩm</h5>
                    <div class="f-right">
                        <a href="" data-toggle="modal" data-target="#textual-input-Modal"><i class="icofont icofont-code-alt"></i></a>
                    </div>
                </div>
                <div class="modal-body">
                    <?php if (isset($_POST['submit'])) { ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Well done!</strong> <?php echo ($_SESSION['success']); ?>
                        </div>
                    <?php } ?>
                    
                    <div class="card-block">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Tên sản phẩm</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="name" type="text" value="">
                                    <p class="text-danger"><?php echo isset($error['name']) ? $error['name'] : '' ?></p>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Category</label>
                                <div class="col-sm-10">
                                    <select name="category" class="form-group" onchange="getSubcat(this.value)" required>
                                        <option value="">Select Category</option>

                                        <?php $sql = "SELECT * FROM cat ";
                                        $result = $mysqli->query($sql);
                                        while ($arOption = mysqli_fetch_assoc($result)) {

                                        ?>
                                            <option value="<?php echo $arOption['cat_id'] ?>"><?php echo $arOption['name'] ?></option>

                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Sub Category</label>
                                <div class="col-sm-10" >
                                    <select name="subcategory"  id="subcategory" required>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Giá</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="price" type="number" value="0" min="0" step="1" max="1000000000">
                                    <p class="text-danger"><?php echo isset($error['price']) ? $error['price'] : '' ?></p>
                                </div>
                            </div>       
                            
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Tồn Kho</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="quantity" type="number" value="0" min="0" step="1" max="1000000000">                               
                                </div>
                            </div>                    
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Hình đại diện</label>
                                <div class="col-sm-10">
                                    <input name="image" type="file">

                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Hình sản phẩm</label>
                                <div class="col-sm-10">
                                    <input name="images[]" type="file" multiple>

                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Mô tả sản phẩm</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="preview" type="text" value="">

                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Chi tiết sản phẩm</label>
                                <div class="col-sm-10">
                                    <textarea id="editor" class="form-control " rows="5" name="detail"></textarea>
                                    <p class="text-danger"><?php echo isset($error['detail']) ? $error['detail'] : '' ?></p>
                                    <script type="text/javascript">
                                        CKEDITOR.replace('editor', {
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
        <script>
        function getSubcat(val) {
				$.ajax({
					type: "POST",
					url: "http://localhost:8080/basket/admin/product/get_subcat.php",
					data: 'cat_id=' + val,
					success: function(data) {
						$("#subcategory").html(data);
					}
				});
			}
    </script>