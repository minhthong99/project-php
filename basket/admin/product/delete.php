<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php
    $product_id = $_GET['id'];
    $query = "DELETE FROM product WHERE id = ('{$product_id}')";
   
    $result = $mysqli->query($query);
    if($result){
        HEADER("LOCATION:index.php?msg=xóa sản phẩm thành công");

    }else{
        HEADER("LOCATION:index.php?msg=không thể xóa sản phẩm ");
    }
 ?>
