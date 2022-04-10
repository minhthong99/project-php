<?php require_once '../../util/DBConnectionUtil.php'; ?>
<?php 
    
    #b1 lấy id
        $comment_id =$_GET['id'];
    #b2 xóa
        $query = "DELETE FROM comment WHERE comment_id = {$comment_id}";
    #b3 Về trang index thông báo
     if ($mysqli->query($query)){
        HEADER("LOCATION:index.php?msg=xóa bình luận thành công");

     }else{
        HEADER("LOCATION:index.php?msg=không thể xóa bình luận ");
     }

?>