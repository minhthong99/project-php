<?php require_once '../../templates/admin/inc/header.php'; ?>
<?php require_once '../../util/checkUserUtil.php' ?>
<div id="layoutSidenav">
    <?php require_once '../../templates/admin/inc/leftbar.php'  ?>
    <?php
    $sqlProduct = "SELECT count(id) AS sohang FROM product";
    $resultProduct = $mysqli->query($sqlProduct);
    $arrayProduct = mysqli_fetch_assoc($resultProduct);
    $sumProduct = $arrayProduct['sohang'];

    $sqlTran = "SELECT count(id) AS soTran FROM orders";
    $resultTran = $mysqli->query($sqlTran);
    $arrayTran = mysqli_fetch_assoc($resultTran);
    $sumTran = $arrayTran['soTran'];

    $sqlNew = "SELECT count(id) AS soNew FROM news";
    $resultNew = $mysqli->query($sqlNew);
    $arrayNew = mysqli_fetch_assoc($resultNew);
    $sumNew = $arrayNew['soNew'];

    $sqlUser = "SELECT count(id) AS soUser FROM users";
    $resultUser = $mysqli->query($sqlUser);
    $arrayUser = mysqli_fetch_assoc($resultUser);
    $sumUser = $arrayUser['soUser'];

    ?>


    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">

                            <div class="card-body">
                                <h3><?php echo $sumProduct ?></h3>
                                <p>Sản phẩm</p>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="admin/product/index.php">Danh sách sản phẩm</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">
                                <h3><?php echo $sumTran ?></h3>
                                <p>Giao dịch</p>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="admin/transaction/index.php">Danh sách Giao dịch</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">
                                <h3><?php echo $sumNew ?></h3>
                                <p>Bài viết</p>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="admin/news/index.php">Danh sách bài viết</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">
                                <h3><?php echo $sumUser ?></h3>
                                <p>Khách hàng</p>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="admin/user/index.php">Liên hệ khách hàng</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area mr-1"></i>
                                Area Chart Example
                            </div>
                            <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Bar Chart Example
                            </div>
                            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        DataTable Example
                    </div>

                    <div class="card-body">
                        <div class="chart">
                            <div id="chart_div" style="width: 100%; height: 250px;"></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
</main>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawVisualization);

    function drawVisualization() {
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Bán ra', 'Đơn hàng'],
            <?php
            $d = getdate();
            $year = $d['year'];
            for ($i = 1; $i <= 12; $i++) {
                $query="SELECT * FROM orders WHERE MONTH(created) = $i AND YEAR(created) = $year  AND status  = 2";

                $result=$mysqli->query($query);
               
               $count=0;
                $sum = 0;
                while ( $list_orders =mysqli_fetch_array($result)) {
                    $id=$list_orders['id'];
                    $query_detail="SELECT * FROM orders_detail WHERE order_id=$id ";
                         
                    $result_detail=$mysqli->query($query_detail);
                    while($order_detail = mysqli_fetch_array($result_detail)){
                   
                        $sum += $order_detail['qty'];
                    }
                  $count++;
                }
               
                if ($i >= 1 && $i <= 9) {
                    echo "['0" . $i . '/' . $year . "'," . $sum . "," . $count . "],";
                } else {
                    echo "['" . $i . '/' . $year . "'," . $sum . "," .  $count. "],";
                }
            }
            ?>

        ]);

        var options = {
            title: 'Số lượng bán ra từ 01/2021 - 12/2021',
            seriesType: 'bars'
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
<?php require_once '../../templates/admin/inc/footer.php' ?>
