<?php require_once '../../templates/admin/inc/header.php'; ?>
<?php require_once '../../util/DBConnectionUtil.php'; ?>
<div id="layoutSidenav">
	<?php require_once '../../templates/admin/inc/leftbar.php'  ?>
	<div id="layoutSidenav_content">
		<main>
			<?php
			$id = $_GET['id'];
			$queryOrder = "SELECT orders_detail.*,product.name as product_name,product.price as product_price FROM orders_detail JOIN product ON orders_detail.product_id=product.id WHERE orders_detail.order_id = {$id}";

			$resultOrder = $mysqli->query($queryOrder);	
			?>
			 <div class="container-fluid">
                    <h1 class="mt-4">Orders</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Orders</a></li>
                        <li class="breadcrumb-item active">Orders Detail</li>
                    </ol>
			<section class="content">
				<!-- Info boxes -->
				<div class="row">
					<div class="col-md-12">
						<div class="box">
							<div class="box-body">
								<!--ND-->
								<div id="view">
									<form action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">

									
										<div class="table-responsive">
											<table class="table table-hover table-bordered">
												<thead>
													<tr>
														<th class="text-center">STT</th>
														<th>Tên sản phẩm</th>													
														<th class="text-center" style="width:100px">Số lượng</th>
														<th style="width:120px">Giá bán</th>
														<th class="text-right" style="width:120px">Thành tiền</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$stt = 1;
													$total = 0;
											
																						
													while ($row = mysqli_fetch_assoc($resultOrder)){
													
														// $queryPro = "SELECT * FROM product WHERE id='{$order['product_id']}'";
														// $resultPro = $mysqli->query($queryPro);
														// $product = mysqli_fetch_assoc($resultPro);
													?>
													
														<tr>
															<td class="text-center"><?php  echo $stt++; ?></td>
															<td><?php echo $row['product_name']; ?></td>															
															<td class="text-center"><?php echo $row['qty']; ?></td>
															<td><?php echo number_format($row['product_price']); ?>₫</td>
															<td class="text-right">
																<?php
																$price = $row['product_price'] * $row['qty'];
																echo number_format($price);
																$total += $price;

																?>₫
															</td>
														</tr>
														<?php } ?>
													<tr>
														<td colspan="6" class="text-right" style="border: none; font-size: 1.1em;">Tổng cộng: <?php echo number_format($total); ?>₫</td>
													</tr>

													<tr>
														<td colspan="6" class="text-right" style="border: none; font-size: 0.9em;"><i>Phí vận chuyển: </i>
															<?php echo "30000"; ?>₫
														</td>
													</tr>
													<tr>
														<td colspan="6" class="text-right" style="border: none; color: red; font-size: 1.3em;">Thành tiền: <?php echo number_format($total + 30000); ?>₫</td>
													</tr>


												</tbody>
											</table>
										</div>
										<!-- <div class="row">
								<div class="col-md-12 text-right">
									<ul class="pagination">
									</ul>
								</div>
							</div> -->
									</form>
								</div>
								<!--/.ND-->
							</div>
						</div><!-- /.box -->
					</div><!-- /.col -->
				</div><!-- /.row -->
			</section><!-- /.content -->
			 </div>
		</main>

		<?php require_once '../../templates/admin/inc/footer.php' ?>