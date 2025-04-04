<?php
    session_start();
    $title = 'PRINT | TIGER APPLICATION';
    include './middleware.php';
    $page = 'print';
    $hostname = gethostname();
    require_once '../includes/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">
    <title><?=$title?></title>
    <link rel="stylesheet" href="../dist/css/font.css">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="card mt-2 p-2">
                            <div class="col-md-12">
                                <?php 
                                    // echo "ชื่อคอมพิวเตอร์: " . $hostname; 
                                    // echo '<br>';
                                    // echo "ชื่อพนักงาน: " . $_SESSION['username']
                                ?>
                                <table class="table">
                                    <tr>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <!-- ยอดรับชำระแยกประเภท -->
                        <div class="col-md-12 mt-1">
                            <div class="card p-2">
                                <div class="card-header">
                                    ยอดรับชำระแยกประเภท ( <?= date("d-m-Y") ?> )
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm" id="tablePay">
                                        <thead>
                                            <th>ประเภท</th>
                                            <th class="text-center">จำนวนครั้ง</th>
                                            <th class="text-right">ยอดขายรวม</th>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $date = date('Y-m-d');
                                                $sqlCash = $conndb->query("SELECT  `pay` , COUNT(pay) AS count , SUM(total) AS sum  
                                                FROM `orders` 
                                                WHERE `date` LIKE '%$date%' 
                                                GROUP BY `pay`");
                                                $sqlCash->execute();
                                                $total = 0;
                                                foreach ( $sqlCash AS $rowCash ) :?>
                                            <tr>
                                                <td><?= $rowCash['pay'] ?></td>
                                                <td class="text-center"><?= $rowCash['count'] ?></td>
                                                <td class="text-right"><?= number_format($rowCash['sum'],2) ?></td>
                                            </tr>
                                            <?php $total = $total += $rowCash['sum'] ?>
                                            <?php endforeach ?>
                                            <tr>
                                                <th>ยอดรวมทั้งหมด</th>
                                                <th></th>
                                                <th class="text-right"><?= number_format($total,2) ?></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- ยอดรวมส่วนลดวันนี้ -->
                        <div class="col-md-12">
                            <div class="card p2">
                                <div class="card-header">
                                    ยอดรวมส่วนลดวันนี้ ( <?= date("d-m-Y") ?> )
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <thead>
                                            <th>หมายเลขบิล</th>
                                            <th class="text-right">ส่วนลด</th>
                                            <th class="text-right">จำนวนส่วนลด</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $totalDis = 0;
                                                $date = date("Y-m-d");
                                                $sqlDis = "SELECT `num_bill`,`fname`,`discount`,`price`,`order_date` 
                                                FROM `orders` 
                                                WHERE  `discount` > 0  AND`date` LIKE '%$date%'";
                                                $stmtDis = $conndb->query($sqlDis);
                                                $stmtDis->execute();
                                                foreach ( $stmtDis AS $rowDis ) :?>
                                            <tr>
                                                <td><?= $rowDis['num_bill'] ?></td>
                                                <td class="text-right"><?= $rowDis['discount'] ?> % </td>
                                                <td class="text-right">
                                                    <?= number_format(($rowDis['price'] * $rowDis['discount']) / 100 ,2 )  ?>
                                                </td>
                                            </tr>
                                            <?php $totalDis = $totalDis += ($rowDis['price'] * $rowDis['discount']) / 100 ?>
                                            <?php endforeach ?>
                                            <tr>
                                                <td colspan="2">ยอดรวมทั้งหมด</td>
                                                <td class="text-right"><?= number_format($totalDis,2) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- ยอดขายสินค้า -->
                        <div class="col-md-12">
                            <div class="card p-2">
                                <div class="card-header">
                                    ยอดขายสินค้า ( vat ) ( <?= date("d-m-Y") ?> )
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm" id="tableProduct">
                                        <thead>
                                            <th>ประเภท</th>
                                            <th class="text-right">จำนวนครั้ง</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $date = date('Y-m-d');
                                                $sqlProduct = "SELECT `product_name`, COUNT(product_name) AS count , 
                                                od.total AS od ,o.total AS o , o.date
                                                FROM `orders` AS o
                                                INNER JOIN `order_details` AS od
                                                ON od.order_id = o.id
                                                WHERE o.date LIKE '%$date%'
                                                GROUP BY od.product_name";
                                                $stmtProduct = $conndb->query($sqlProduct);
                                                $stmtProduct->execute();
                                                $totalProduct = 0;
                                                foreach ( $stmtProduct AS $rowProduct ) :?>
                                            <tr>
                                                <td><?= $rowProduct['product_name'] ?></td>
                                                <td class="text-right"><?= $rowProduct['count'] ?></td>
                                            </tr>
                                            <?php endforeach ?>
                                            <tr>
                                                <td colspan="1">ยอดรวมทั้งหมด</td>
                                                <th class="text-right"><?= number_format($total,2) ?></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.js"></script>

    <script>
    window.print();
    setTimeout(function() {
        // window.location.href = 'print.php';
        window.close();
    });
    </script>
</body>

</html>
<?php $conndb = null;?>