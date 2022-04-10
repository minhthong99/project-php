<?php require_once '../../templates/admin/inc/header.php' ?>
<?php require_once '../../util/DBConnectionUtil.php'; ?>
<div id="layoutSidenav">
    <?php require_once '../../templates/admin/inc/leftbar.php'  ?>
    <div id="layoutSidenav_content">
        <?php
        $product_id = $_GET['id'];

        $query = mysqli_query($mysqli, "SELECT * FROM product WHERE id =$product_id");

        $item = mysqli_fetch_array($query);
        if (isset($_POST['submit'])) {
            $quantity = $_POST['qty'];
            $number =  $quantity + $item['quantity'];
            $query_update = "UPDATE product SET quantity = $number WHERE id=$product_id";
            $results = $mysqli->query($query_update);
         
          
        }



 

        ?>
        <div class="container-fluid">
            <h1 class="mt-4">Product</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Tables</li>
            </ol>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text">Nhập hàng</h5>
                    <div class="f-right">
                        <a href="" data-toggle="modal" data-target="#textual-input-Modal"><i class="icofont icofont-code-alt"></i></a>
                    </div>
                </div>
                <div class="modal-body">

                    <div class="card-block">
                        <form method="POST">
                            <?php
                            $query = mysqli_query($mysqli, "SELECT * FROM product WHERE id =$product_id");

                            while ($array = mysqli_fetch_assoc($query)) {      ?>
                                <div class="form-group ">
                                    <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Tên sản phẩm</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" value="<?php echo $array['name'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Số lượng tồn kho</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="<?php echo $array['quantity'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="example-text-input" class="col-xs-2 col-form-label form-control-label">Số lượng nhập thêm</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="qty" type="number" min="0">
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