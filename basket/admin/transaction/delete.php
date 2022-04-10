<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php 
    $id =$_GET['id'];
    $sql = "DELETE FROM orders WHERE id= {$id} ";
    $result=$mysqli->query($sql);
    if($result){
        HEADER("LOCATION:index.php?del_msg=xóa giao dịch thành công");
    }else{
        HEADER("LOCATION:index.php?del_msg=không thể xóa  ");
    }
?>