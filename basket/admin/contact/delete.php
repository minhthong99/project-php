<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php 
    $id =$_GET['id'];
    $sql = "DELETE FROM contact WHERE id= {$id} ";
    $result=$mysqli->query($sql);
    if($result){
        HEADER("LOCATION:index.php?msg=xóa liên hệ thành công");
    }else{
        HEADER("LOCATION:index.php?msg=không thể xóa liên hệ ");
    }
?>