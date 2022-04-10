<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php
if ( ($_SESSION['level'] =! 1)) {
    echo "<script type='text/javascript'>alert('bạn không được phép truy cập');location.href='../dashboard/index.php'</script>";

    die();
}
?>
<?php
$id = $_GET['admin_id'];
$query = "DELETE FROM admin WHERE id = {$id}";
$result = $mysqli->query($query);
if ($result) {
    HEADER("LOCATION:index.php?del_msg=xóa quản lý thành công");
} else {
    HEADER("LOCATION:index.php?del_msg=không thể xóa tài khoản ");
}

?>
