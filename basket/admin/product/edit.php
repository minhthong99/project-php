<?php require_once '../../templates/admin/inc/header.php' ?>
<?php require_once '../../util/DBConnectionUtil.php'; ?>
<div id="layoutSidenav">
    <?php require_once '../../templates/admin/inc/leftbar.php'  ?>

    <div id="layoutSidenav_content">

        <?php
        #Select
        $product_id = $_GET['id'];
     
     
        #update
        #thuật toán  đặt cờ hiệu
        if (isset($_POST['submit'])) {
            $error = array();
            if ($_POST['name']  && $_POST['price'] ) {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $detail = $_POST['detail'];
                $cat = $_POST['cat_id'];             
                $preview = $_POST['preview'];
                $subcat=$_POST['subcategory'];
                
            } else {
                $error['name'] = 'Chưa nhập tên sản phẩm';
                $error['price'] = 'Chưa nhập giá';              
               
            }
            if (empty($error)) {


                #b2 viết câu lệnh truy vấn
                $query = "UPDATE product SET name ='{$name}', price = '{$price}', detail = '{$detail}',cat_id='{$cat}',subcat_id='{$subcat}',preview ='{$preview}' WHERE id={$product_id}";
                #b3 kiem tra anh
                if (isset($_FILES['image']['name'])) {
                    $file_name = $_FILES['image']['name'];
                    $arFile = explode('.', $file_name);
                    $typeFile = end($arFile);
                    $newFileName = 'Product-' . time() . '.' . $typeFile;
                    $tmp_name = $_FILES['image']['tmp_name'];
                    move_uploaded_file($tmp_name, '../../files/uploads/' . $newFileName);
                }              
                #b4 thông báo kết quả
                $result = $mysqli->query($query);
                $sqlImg = "SELECT * FROM img_products";
                $resultImg = mysqli_query($mysqli, $sqlImg);
                $arImg = mysqli_fetch_assoc($resultImg);
                if (isset($_FILES['images']['name'])) {
                    $file_names = $_FILES['images']['name'];
                    if ( $arImg['product_id'] == $product_id) {

                        foreach ($file_names as $key => $value) {
                            $tmp_names = $_FILES['images']['tmp_name'][$key];
                            move_uploaded_file($tmp_names, '../../files/uploads/' . $value);
                            mysqli_query($mysqli, "UPDATE img_products SET image='{$value}' WHERE product_id={$product_id}");
                        }
                    } else {
                        foreach ($file_names as $key => $value) {
                            $tmp_names = $_FILES['images']['tmp_name'][$key];
                            move_uploaded_file($tmp_names, '../../files/uploads/' . $value);
                            mysqli_query($mysqli, "INSERT INTO img_products(product_id,image) VALUES ('{$product_id}','{$value}')");
                        }
                    }
                }               
            }
            
        }

        ?>
        <div class="container-fluid">
            <h1 class="mt-4">Edit Product</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Product</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text">Sửa danh sách sản phẩm</h5>
                    <div class="f-right">
                        <a href="" data-toggle="modal" data-target="#textual-input-Modal"><i class="icofont icofont-code-alt"></i></a>
                    </div>
                </div>
                <div class="modal-body">
                <?php if(isset($_POST['submit'])){ ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Well done!</strong> <?php echo ("Product Updated Successfully !!"); ?>                               
                            </div>
                            <?php } ?>
                    <div class="card-block">
                        <form method="POST" enctype="multipart/form-data">
                        <?php    $select =mysqli_query($mysqli,"SELECT product.*,cat.name as catname,cat.cat_id as cid,subcat.subcategory as subcatname,subcat.id as subcatid FROM product JOIN cat ON cat.cat_id=product.cat_id JOIN subcat ON subcat.id=product.subcat_id WHERE product.id=$product_id");
                                while($infoPro=mysqli_fetch_assoc($select)){
                        ?>
                            <div class="form-group">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Tên Sản phẩm</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="name" type="text" value="<?php echo $infoPro['name'] ?>">
                                    <p class="text-danger"><?php echo isset($error['name']) ? $error['name'] : '' ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Danh mục</label>
                                <select name="cat_id" id=""  onchange="getSubcat(this.value)" required>
                                    <option value="<?php echo $infoPro['cid'] ?>"><?php echo $infoPro['catname'] ?></option>
                                    <?php $sql = "SELECT * FROM cat ";
                                    $result = $mysqli->query($sql);
                                    while ($arOption = mysqli_fetch_assoc($result)) {
                                       if($infoPro['catname'] == $arOption['name']){
                                           continue;
                                       }else{

                                       
                                    ?>
                                        <option value="<?php echo $arOption['cat_id'] ?>"><?php echo $arOption['name'] ?></option>
                                    <?php } 
                                    }?>
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Danh mục con</label>
                                <select name="subcategory" id="subcategory" required>
                                    <option value="<?php echo $infoPro['subcatid']; ?>"><?php echo $infoPro['subcatname'] ?></option>
                              
                                </select>
                            </div>                           
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Giá</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="price" type="number" value="<?php echo $infoPro['price'] ?>" min="0" step="1" max="1000000000">
                                    <p class="text-danger"><?php echo isset($error['price']) ? $error['price'] : '' ?></p>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Tồn Kho</label>
                                <div class="col-sm-10">
                                    <input class="form-control"  type="number" value="<?php echo $infoPro['quantity'] ?>" min="0" step="1" max="1000000000" disabled>                               
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
                                    <input class="form-control" name="preview" type="text" value="<?php echo $infoPro['preview'] ?>">

                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Chi tiết sản phẩm</label>
                                <div class="col-sm-10">
                                     <textarea id="editor" class="form-control " rows="5" name="detail"><?php echo $infoPro['detail'] ?></textarea>
                                    
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
                            <?php } ?>
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