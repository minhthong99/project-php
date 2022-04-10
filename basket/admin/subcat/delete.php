<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php 
    $cat_id =$_GET['id'];
    $sql = "DELETE FROM subcat WHERE id= '{$cat_id}' ";
    $result=$mysqli->query($sql);
    if($result){
        HEADER("LOCATION:index.php?msg=xóa danh mục thành công");
    }else{
        HEADER("LOCATION:index.php?msg=không thể xóa danh mục ");
    }
?>