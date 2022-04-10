<?php session_start();
ob_start();
?>
<?php require_once 'util/DBConnectionUtil.php';
?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$action = (isset($_GET['action'])) ? $_GET['action'] : 'add';
$quantity = (isset($_GET['quantity'])) ? $_GET['quantity'] : 1;
// var_dump($action);
// die();
$query = "SELECT * FROM product WHERE id=$id";
$result = $mysqli->query($query);
if ($result) {
    $product = mysqli_fetch_assoc($result);
}
$item = [
    'id' => $product['id'],
    'name' => $product['name'],
    'image' => $product['image'],
    'price' => $product['price'],
    'quantity' => $quantity
];

if ($action == 'add') {
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$id] = $item;
    }
    if ($_SESSION['cart'][$id]['quantity'] > $product['quantity']) {
        $_SESSION['cart'][$id]['quantity'] = $product['quantity'];
      
    }
}

if ($action == 'delete') {
    // var_dump("ok");die();
    unset($_SESSION['cart'][$id]);
}
header('location:cart');
// $product=array();
// foreach($result as $value){
//     $product[$value['id']] = $value;

// }
// if(isset($_POST['add_to_cart'])){    
//     $quantity=$_POST['so_luong'];
//     if(!isset($_SESSION['cart']) || $_SESSION['cart'] == NULL){
// 		//tao moi gio hang          
//         $product[$id]["so_luong"] = $quantity;        
//         $_SESSION['cart'][$id]= $product[$id];  

//     }else{	
//     if(array_key_exists($id,$_SESSION['cart'])){
//             $_SESSION['cart'][$id]["so_luong"] += $quantity; 


//     } 
//     else{
//         $product[$id]["so_luong"] = $quantity;        
//         $_SESSION['cart'][$id]=$product[$id];
//     }

//     }

//  echo "<script >alert('Thêm sản phẩm thành công! ');location.href='cart'</script>";

// }
?>
  
