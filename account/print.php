<?php
    session_start();
    $title = 'PRINT | TIGER APPLICATION';
    include 'middleware.php';
    $page = 'print';
    include("../includes/connection.php");
    $date = date('Y-m-d'); 
    $sqlTotal = "SELECT * , SUM(total)AS sum 
    FROM `orders`
    WHERE date(date) LIKE '%$date%' ";
    $stmtTotal = $conndb->query($sqlTotal);
    $stmtTotal->execute();
    $rowTotal = $stmtTotal->fetchAll();
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
        <?php include './aside.php'?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <!-- หัวบิล -->
                        <div class="col-md-12">
                           <div class="card mt-2">
                            <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ไทเกอร์ มวยไทย ( ไทยแลนด์ ) จำกัด</th>
                                            <th> <?= 'POS :' . ' ' .$rowTotal[0]['hostname'] ?> </th>
                                            <th> <?= 'วันที่ :' . ' ' . date('d-m-Y') ?></th>
                                            <th> <?= 'ชื่อผู้ใช้งาน :' . ' ' . $_SESSION['username']  ?></th>
                                        </tr>
                                    </thead>
                                </table>
                           </div>
                        </div>

                        <!-- ยอดขายสินค้า -->
                        <div class="col-md-12">
                            <div class="card p-2">
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>รายการ</th>
                                                <th class="text-right">ยอดรวม</th>
                                                <th class="text-right">หน่วย</th>
                                            </tr>
                                            <tbody>
                                                <tr>
                                                    <td>ยอดขายทั้งหมด</td>
                                                    <td class="text-right"><?= number_format($rowTotal[0]['sum'],2)  ?></td>
                                                    <td class="text-right">บาท</td>
                                                </tr>
                                            </tbody>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- ยอดรวมส่วนลดวันนี้ -->
                        <div class="col-md-12">
                            <div class="card p2">
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
                                                $sqlDis = "SELECT `num_bill`,`fname`,`discount`,`price`
                                                FROM `orders` 
                                                WHERE  `discount` > 0  AND`date` LIKE '%$date%'";
                                                $stmtDis = $conndb->query($sqlDis);
                                                $stmtDis->execute();
                                                foreach ( $stmtDis AS $rowDis ) :?>
                                            <tr>
                                                <td><?= $rowDis['num_bill'] ?></td>
                                                <td class="text-right">
                                                    <?= $rowDis['discount'] ?> % </td>
                                                <td class="text-right">
                                                    <?= number_format(($rowDis['price'] * $rowDis['discount']) / 100 ,2 )  ?>
                                                </td>
                                            </tr>
                                            <?php $totalDis = $totalDis += ($rowDis['price'] * $rowDis['discount']) / 100 ?>
                                            <?php endforeach ?>
                                            <tr>
                                                <td colspan="2">รวม</td>
                                                <td class="text-right"><?= number_format($totalDis,2) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- ยอดรับชำระแยกประเภท -->
                        <div class="col-md-12">
                            <div class="card p-2">
                                <div class="card-header">
                                    ยอดรับชำระแยกประเภท
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
                                                $sqlCash = $conndb->query("SELECT  `pay` , COUNT(pay) AS count , SUM(total) AS sum  
                                                FROM `orders` 
                                                WHERE date(`date`) LIKE '%$date%' 
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

                    </div>
                    <div class="col-12">
                        <button class="btn btn-success" id="printButton"><i class="fas fa-print"> Print</i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.js"></script>

    <script>
        document.getElementById("printButton").addEventListener("click", function() {
            // ซ่อนปุ่มเมื่อคลิก
            this.style.display = "none";
            
            // พิมพ์
            window.print();
        });
    </script>

</body>
</html>
<?php $conndb = null;?>