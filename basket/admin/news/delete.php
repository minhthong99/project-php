<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php
    $id = $_GET['id'];
    $query = "DELETE FROM news WHERE id = ('{$id}')";
   
    $result = $mysqli->query($query);
    if($result){
        HEADER("LOCATION:index.php?msg=xóa tin tức  thành công");

    }else{
        HEADER("LOCATION:index.php?msg=không thể xóa c ");
    }
 ?>
