<?php
include("middleware.php");
$date = date('Y-m-d');
$title = 'DASHBOARD | ' . $date;
$page = 'index';

include("../includes/connection.php");
$sqlTotal = "SELECT * , SUM(total)AS sum 
  FROM `orders`
  WHERE date(date) LIKE '%$date%' ";
$stmtTotal = $conndb->query($sqlTotal);
$stmtTotal->execute();
$rowTotal = $stmtTotal->fetchAll();
$rowTotal[0]['sum'] = $rowTotal[0]['sum'] ?? 0;
include("layout/header.php");
?>


<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include './aside.php' ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">

                    <div class="row">

                        <!-- หัวบิล -->
                        <div class="col-md-12 mt-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-left">บริษัท ภูเก็ต สปอร์ต ยูโทเปีย จำกัด</th>
                                        <th> <?= 'ชื่อผู้ใช้งาน :' . ' ' . $_SESSION['username']  ?></th>
                                        <th>Rattachai muay thai gym ( Rawai )</th>
                                        <th> <?= 'วันที่ :' . ' ' . date('d-m-Y') ?></th>
                                    </tr>
                                </thead>
                                <!-- 
                                <thead>
                                    <tr>
                                        <th class="text-left">รายการ</th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-right">ยอดรวม</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-danger">
                                        <td>ยอดขายทั้งหมด</td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right"><?= number_format((float)$rowTotal[0]['sum'], 2) ?></td>

                                    </tr>
                                </tbody> -->

                                <thead>
                                    <th>ประเภท การจ่าย</th>
                                    <th class="text-right">จำนวนครั้ง</th>
                                    <th></th>
                                    <th class="text-right">ยอดขายรวม</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sqlCash = $conndb->query("SELECT  `pay`, COUNT(pay) as count , SUM(total) AS total
                                        FROM `orders` 
                                        WHERE date(`date`) LIKE '%$date%'
                                        GROUP BY `pay`
                                        ORDER BY count DESC ");
                                    $sqlCash->execute();
                                    $totalAmount = 0;
                                    foreach ($sqlCash as $rowCash) : ?>
                                        <tr>
                                            <td><?= $rowCash['pay'] ?></td>
                                            <td class="text-right"><?= $rowCash['count'] ?></td>
                                            <td colspan="2" class="text-right"><?= number_format($rowCash['total'], 2) ?></td>
                                        </tr>
                                        <?php $totalAmount =  $totalAmount += $rowCash['total'] ?>
                                    <?php endforeach ?>
                                    <tr class="bg-danger">
                                        <th>ยอดรวมทั้งหมด</th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-right "><?= number_format($totalAmount, 2) ?></th>
                                    </tr>
                                </tbody>

                                <thead>
                                    <tr>
                                        <th>ประเภาทการจ่าย</th>
                                        <th class="text-right">หมายเลขบิล</th>
                                        <th class="text-right">ยอด</th>
                                        <th class="text-right">จำนวนภาษี</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_pay = "SELECT id , pay , num_bill , total 
                                        FROM `orders` 
                                        WHERE `date` LIKE '%$date%' AND pay != 'Cash'
                                        GROUP BY id";
                                    $stmt_pay = $conndb->query($sql_pay);
                                    $stmt_pay->execute();
                                    $vat = 0;
                                    $sumVat = 0;
                                    foreach ($stmt_pay as $row_pay) : ?>
                                        <tr>
                                            <td> <?= $row_pay['pay'] ?> </td>
                                            <td class="text-right"> <?= $row_pay['num_bill'] ?> </td>
                                            <td class="text-right"> <?= number_format($row_pay['total'], 2) ?> </td>
                                            <?php

                                            $vat = ($row_pay['total'] * 3) / 103

                                            ?>
                                            <td class="text-right"> <?= number_format($vat, 2) ?> </td>
                                        </tr>

                                        <?php $sumVat = $sumVat += $vat  ?>

                                    <?php endforeach; ?>

                                    <tr class="bg-danger">
                                        <td>ยอดรวมภาษี</td>
                                        <!-- <td style="color: red;">ยอดรวมทั้งหมด</td> -->
                                        <td colspan="2"></td>
                                        <th class="text-right"><?= number_format($sumVat, 2) ?> </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- ถอดvat -->

                        <!-- รายการสินค้า ไม่รวมภาษี-->
                        <div class="col-md-12">
                            <table class="table table-sm">
                                <thead>
                                    <th>ประเภทรายการ</th>
                                    <th> ราคาสินค้า </th>
                                    <th>ประเภทการชำระ</th>
                                    <th>ขาย / จำนวนครั้ง</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sqlProduct = "SELECT order_details.product_id , order_details.product_name , orders.total , orders.pay,
                                        SUM(order_details.quantity ) AS quantity , order_details.price AS price
                                        FROM `orders` 
                                        INNER JOIN `order_details` ON order_details.order_id = orders.id
                                        WHERE date(orders.date) LIKE '%$date%'
                                        GROUP BY order_details.product_id
                                        ORDER BY quantity DESC;";
                                    $stmtProduct = $conndb->query($sqlProduct);
                                    $stmtProduct->execute();
                                    $sumTotal = 0;
                                    foreach ($stmtProduct as $rowProduct) : ?>
                                        <tr>
                                            <td><?= $rowProduct['product_name'] ?></td>
                                            <td><?= number_format($rowProduct['price'], 2) ?></td>
                                            <td><?= $rowProduct['pay'] ?></td>
                                            <td><?= $rowProduct['quantity'] ?></td>
                                            <!-- <td><?= $rowProduct['total'] ?></td> -->
                                            <td class="text-right"><?= number_format($rowProduct['quantity'] * $rowProduct['total'], 2) ?></td>
                                        </tr>
                                    <?php endforeach ?>

                                </tbody>

                            </table>
                        </div>

                        <table class="table table-sm" id="tableProduct">
                            <thead>
                                <th class="text-left">หมายเลขบิล</th>
                                <th></th>
                                <th class="text-right">ส่วนลด</th>
                                <th class="text-right">จำนวนส่วนลด</th>
                            </thead>
                            <tbody>
                                <?php
                                $totalDis = 0;
                                $sqlDis = "SELECT `num_bill`,`fname`,`discount`,`price`
                                        FROM `orders` 
                                        WHERE  `discount` > 0  AND date(date) LIKE '%$date%'";
                                $stmtDis = $conndb->query($sqlDis);
                                $stmtDis->execute();
                                foreach ($stmtDis as $rowDis) : ?>
                                    <tr>
                                        <td><?= $rowDis['num_bill'] ?></td>
                                        <td class="text-right"><?= $rowDis['discount'] ?> % </td>
                                        <td class="text-right">
                                            <?= number_format(($rowDis['price'] * $rowDis['discount']) / 100, 2)  ?>
                                        </td>
                                    </tr>
                                    <?php $totalDis = $totalDis += ($rowDis['price'] * $rowDis['discount']) / 100 ?>
                                <?php endforeach ?>
                                <tr>
                                    <td colspan="2">รวม</td>
                                    <td class="text-right"><?= number_format($totalDis, 2) ?></td>
                                </tr>
                            </tbody>

                        </table>

                    </div>
                    <div class="col-12">
                        <button class="btn btn-success mb-3 form-control" id="printButton"><i class="fas fa-print">Print</i></button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include("layout/footer.php"); ?>

    <script>
        document.getElementById("printButton").addEventListener("click", function() {
            // ซ่อนปุ่มเมื่อคลิก
            this.style.display = "none";
            // พิมพ์
            window.print();
        });

        $(function() {
            $("#tableProduct").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": false
                // "buttons": ["excel"],
                // "stateSave": true
            });
        });
    </script>
</body>

</html>
<?php $conndb = null; ?>