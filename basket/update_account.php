<?php require_once('templates/basket/inc/header.php'); ?>
<?php ob_start(); ?>
<?php require_once('templates/basket/inc/leftbar.php'); ?>
<!-- Header End -->
<?php require_once 'util/DBConnectionUtil.php'; ?>

<?php
$id = (int)$_GET['id'];
$sqlTran = "SELECT * FROM transaction WHERE transaction_id='{$id}' ";
$resultTran = $mysqli->query($sqlTran);
$EditTransaction = mysqli_fetch_assoc($resultTran);
$status = 2;
$sqlUpdate = "UPDATE transaction SET status='{$status}' WHERE transaction_id='{$EditTransaction['transaction_id']}'";
$sql="UPDATE `order` SET `status`='{$status}' WHERE  transaction_id='{$id}' ";
$result=$mysqli->query($sql);
if($result){
    echo "thanh cong order";
}else{
    echo "that bai order";
    exit;
}
$resultUpdate = $mysqli->query($sqlUpdate);
if ($resultUpdate) {
    $_SESSION['success'] = "Cập nhật thành công";
    $sqlOrder = "SELECT product_id,qty FROM order WHERE transaction_id='{$id}'";
   
    $resultOrder = $mysqli->query($sqlOrder);
   

   
    $data=[];
    if($resultOrder){
        while($num=mysqli_fetch_assoc($resultOrder)){
            $data[]=$num;
        }
        return $data;
    }
    $Order=$data;
    
        foreach ($Order as $item) {
            $idPro = $item['product_id'];
            $sqlPro = "SELECT * FROM product WHERE id='{$idPro}' ";
            $resultPro = $mysqli->query($sqlPro);
            $product = mysqli_fetch_assoc($resultPro);
            $number = $product['number'] - $item['qty'];
            $sqlUpdatePro = "UPDATE product SET number='{$number}' WHERE id='{$idPro}'";
            $resultUpdatePro = $mysqli->query($sqlUpdatePro);
            if ($resultUpdatePro) {
                echo "<script >alert('thành công');location.href='account.php'</script>";
            }
        }
        echo "<script >alert('thành công');location.href='account.php'</script>";
} else {
    $_SESSION['error'] = "dữ liệu không thay đổi";
}

?>
<?php require_once 'templates/admin/inc/footer.php' ?>