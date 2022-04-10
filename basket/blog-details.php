<?php require_once('templates/basket/inc/header.php'); ?>
<?php $currentpage ='blog'; ?>
<?php require_once('templates/basket/inc/leftbar.php'); ?>
<?php require_once 'util/DBConnectionUtil.php'; ?>
<!-- Header End -->


<?php
$id = $_GET['blog_id'];
$sql = "SELECT * FROM news WHERE id=$id";
$query = $mysqli->query($sql);
$arNew = mysqli_fetch_assoc($query);

?>
<!-- Blog Details Section Begin -->
<section class="blog-details spad">
    <div class="container">
        <div class="row">

            <div class="col-lg-12">
                <div class="blog-details-inner">
                    <div class="blog-detail-title">
                        <h2><?php echo $arNew['title'] ?></h2>
                        <p> <span>- <?php echo $arNew['created_at'] ?></span></p>
                    </div>
                    <div class="blog-large-pic">
                        <img src="files/uploads/<?php echo $arNew['img'] ?>" alt="">
                    </div>
                    <div class="blog-detail-desc">
                        <p>
                            <?php echo $arNew['fulltext'] ?>
                        </p>
                    </div>
                    <!-- <div class="posted-by">
                        <div class="pb-pic">
                            <img src="templates/basket/img/blog/post-by.png" alt="">
                        </div>
                        <div class="pb-text">
                            <a href="#">
                                <h5>Shane Lynch</h5>
                            </a>
                            <p>Aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                                velit esse cillum bore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                amodo</p>
                        </div>
                    </div> -->
                    <div class="leave-comment" style="margin-bottom: 30px;">
                        <h4>Leave A Comment</h4>                    
                            <form action="" method="POST" onsubmit="return post();">
                                <div class="col-lg-6">
                                <?php if(isset($_SESSION['username'])){ ?>
                                <input style="width: 100%; margin-bottom:30px; height:50px;" value="<?php echo $_SESSION['username'] ?>" type="text"  id="name" >
                                <?php }else{ ?>
                                <input style="width: 100%; margin-bottom:30px; height:50px;" placeholder="name" type="text"  id="name" >
                                <?php } ?>
                                </div>
                                <div class="col-lg-12">
                                    <textarea name="comment" id="comment" placeholder="Messages" cols="100" rows="5"></textarea>
                                    <input type="hidden" name="new_id" id="new_id" value="<?php echo $id ?>" />
                                 
                                </div>
                                <button  type="submit" name="button_insert" id="button_insert" class="site-btn">Send message</button>
                            </form>
                    </div>
                     
                    </div>
                    <div id="all_comments" >
                        <?php $query = "SELECT * FROM comment WHERE new_id='{$id}' ORDER BY comment_id DESC";
                        $result = $mysqli->query($query);
                        while ($row = mysqli_fetch_array($result)) { ?>
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
                        <?php }        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Section End -->


<script type="text/javascript">
    function post() {
        var name = document.getElementById("name").value;
        var comment = document.getElementById("comment").value;
        var new_id = <?php echo $id; ?>;
        if (comment && name ) {
            $.ajax({
                type: 'POST',
                url: 'addcomment.php',
                data: {
                    user_comm: comment,
                    user_name: name,
                    new_id : new_id
                },
                success: function(response) {
                    document.getElementById("all_comments").innerHTML = response + document.getElementById("all_comments").innerHTML ;
                    document.getElementById("comment").value = "";
                    document.getElementById("name").value = "";
                  
                    alert("Comment has success");
                }
            });
        }

        return false;
    }
</script>


<!-- Footer Section Begin -->
<?php require_once('templates/basket/inc/footer.php'); ?>