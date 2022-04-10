<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php
$id = (int)$_GET['id'];
$sqlTran = "SELECT * FROM orders WHERE id='{$id}' ";
$resultTran = $mysqli->query($sqlTran);
$EditTransaction = mysqli_fetch_assoc($resultTran);
if (empty($EditTransaction)) {
    $_SESSION['error'] = "Dữ liệu không tồn tại";
    header("LOCATION:index.php");
}
if ($EditTransaction['status'] == 1) {
    $status=2;
    $sql="UPDATE `orders` SET `status`='{$status}' WHERE  id='{$id}' ";
    $query= mysqli_query($mysqli,"SELECT qty,product_id FROM orders_detail WHERE order_id=$id");
   
     while (  $rowdetail=mysqli_fetch_assoc($query)){
         $idproduct= $rowdetail['product_id'];
         $qty=$rowdetail['qty'];
         $queryPro=mysqli_query($mysqli,"SELECT quantity FROM product WHERE id=$idproduct");
         $row=mysqli_fetch_array($queryPro);
         $quantity=$row['quantity'] - $qty;
         $update=mysqli_query($mysqli,"Update product SET quantity =  $quantity WHERE id =$idproduct");
     }
}else{
$status = 1;
// $sqlUpdate = "UPDATE transaction SET status='{$status}' WHERE transaction_id='{$EditTransaction['transaction_id']}'";
$sql="UPDATE `orders` SET `status`='{$status}' WHERE  id='{$id}' ";
}
$result=$mysqli->query($sql);

// if($result){
//     echo "thanh cong order";
// }else{
//     echo "that bai order";
//     exit;
// }
// $resultUpdate = $mysqli->query($sqlUpdate);
if ($result) {


      HEADER("LOCATION:index.php?msg=cập nhật thành công");
    // $sqlOrder = "SELECT product_id,qty FROM order WHERE transaction_id='{$id}'";
   
    // $resultOrder = $mysqli->query($sqlOrder);
   

   
    // $data=[];
    // if($resultOrder){
    //     while($num=mysqli_fetch_assoc($resultOrder)){
    //         $data[]=$num;
    //     }
    //     return $data;
    // }
    // $Order=$data;
    
    //     foreach ($Order as $item) {
    //         $idPro = $item['product_id'];
    //         $sqlPro = "SELECT * FROM product WHERE id='{$idPro}' ";
    //         $resultPro = $mysqli->query($sqlPro);
    //         $product = mysqli_fetch_assoc($resultPro);
    //         $number = $product['number'] - $item['qty'];
    //         $sqlUpdatePro = "UPDATE product SET number='{$number}' WHERE id='{$idPro}'";
    //         $resultUpdatePro = $mysqli->query($sqlUpdatePro);
    //         if ($resultUpdatePro) {
    //             echo "<script >alert('thành công');location.href='admin/transaction/index.php'</script>";
    //         }
    //     }
    //     echo "<script >alert('thành công');location.href='admin/transaction/index.php'</script>";
} else {
    HEADER("LOCATION:index.php?msg=không thể cập nhật");
}

?>