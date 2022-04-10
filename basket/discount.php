<?php session_start();
ob_start();
?>
<?php require_once 'util/DBConnectionUtil.php';
?>
<?php
if (isset($_SESSION["cart"])) {
    $sum = 0;
    foreach ($_SESSION["cart"] as $value) {
        $sum1 = ($value["price"] * $value["quantity"]);
    }
}

if (isset($_POST['apply'])) {
    $code = $_POST['coupon'];
    
    if (empty($code)) {
        $error['code'] = '<p>Mã giảm giá không tồn tại!</p>';
    } else {
        $queryCode = "SELECT * FROM discount WHERE code='{$code}' AND status = 1";
        $resultCode = $mysqli->query($queryCode);
        $infoCode = mysqli_fetch_assoc($resultCode);
        $d = getdate();
        $today = $d['year'] . "-" . $d['mon'] . "-" . $d['mday'];
        $_SESSION['price_code']=$infoCode['discount'];

        if(isset($_SESSION['price_code'])){
            $error['code'] = '<p>Mỗi đơn hàng chỉ áp dụng 1 Mã giảm giá !!</p>';
        } 
        if ($infoCode['payment_limit'] >= $sum1) {
            $error['code'] = '<p> Mã giảm giá này chỉ áp dụng cho đơn hàng từ ' . number_format($infoCode['payment_limit']) . ' đ trở lên !</p>';
        } elseif ($infoCode['limit_number'] - $infoCode['number_user'] == 0) {
            $error['code'] = '<p>Mã giảm giá ' . $code . ' đã hết số lần nhập !</p>';
        } elseif (strtotime($today) >= strtotime($infoCode['expiration_date'])) {
            $error['code'] = '<p>Mã giảm giá  đã hết hạn sử dụng  !</p>';
        } else {
            $error['code'] = ' <p>Mã giảm giá ' . $infoCode['code'] . ' đã được kích hoạt !</p>';
            $_SESSION['coupon'] = $infoCode;
            $number = $infoCode['number_user'] + 1;
            $query = "UPDATE discount set number_user = '{$number}' WHERE code ='{$code}' ";

            $result = $mysqli->query($query);
        }
    }
}
?>