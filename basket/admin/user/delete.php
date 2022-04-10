<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php    
    $id = $_GET['user_id'];
    $query = "DELETE FROM users WHERE id = {$id}";
    $result = $mysqli->query($query);
    if($result){
        HEADER("LOCATION:index.php?msg=xóa người dùng thành công");
    }else{
        HEADER("LOCATION:index.php?msg=không thể xóa người dùng ");
    }

?>
