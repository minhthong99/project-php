<?php require_once 'util/DBConnectionUtil.php';
if (isset($_POST['user_comm']) && isset($_POST['user_name'])) {
    $name = $_POST['user_name'];
    $comment = $_POST['user_comm'];
    $new_id = $_POST['new_id'];

    $query = mysqli_query($mysqli, "INSERT INTO comment (new_id, username, detail)  VALUES ('{$new_id}', '{$name}', '{$comment}') ");
    $id = mysqli_insert_id($mysqli);

    $select = "SELECT * FROM comment WHERE new_id='{$new_id}'and username='{$name}' and comment_id='{$id}'  ";
    $result2 = $mysqli->query($select);
  
    if ($row = mysqli_fetch_array($result2)) { ?>
        <div id="all_comments">
            <li class="media">
                <a class="pull-left" href="#">
                    <img class="media-object img-circle" src="https://s.nettruyen.com/Data/SiteImages/anonymous.png" alt="author" style="display: inline;">
                </a>
                <div class="media-body">
                    <div class="well well-lg">
                        <h4 class="media-heading text-uppercase reviews"><?php echo $row['username'] ?></h4>
                        <ul class="media-date text-uppercase reviews list-inline">
                            <li><?php echo $row['date'] ?></li>
                        </ul>
                        <p class="media-comment">
                            <?php echo $row['detail'] ?>
                        </p>


                    </div>
                </div>
            </li>
        </div>
<?php }
   
}

?>
<!-- // $data = array(
//  'error'  => $error
// );

// echo json_encode($data);

?> -->