<?php
require_once '../../util/DBConnectionUtil.php'; 
if(!empty($_POST["cat_id"])) 
{
 $id=intval($_POST['cat_id']);
$sql="SELECT * FROM subcat WHERE category_id=$id";
$query=$mysqli->query($sql);
?>
<option value="">Select Subcategory</option>
<?php
 while($row=mysqli_fetch_assoc($query))
 {
  ?>
  <option value="<?php echo ($row['id']); ?>"><?php echo ($row['subcategory']); ?></option>
  <?php
 }
}
?>