<?php
include '../middleware.php';
$title = 'REPORT | APPLICATION';
$page = 'shop_total';
include('../../includes/connection.php');
date_default_timezone_set('Asia/Bangkok');
$currentDate = date("Y-m-d");
$newDate = date("Y-m-d", strtotime("-1 day", strtotime($currentDate)));

?>
<!DOCTYPE html>
<html lang="en">

<?php include('./header.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include './aside.php' ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">

                    <?php if (isset($_POST['search'])) { ?>

                    <?php } else {  ?>
                        <!-- from -->
                        <div class="row" id="formData">
                            <div class="col-md-4 mx-auto mt-2">
                                <form action="" method="post" id="form">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text">เลือกวัน</label>
                                                </div>
                                                <input type="date" name="date" class="form-control" value="<?= date("Y-m-d") ?>">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <input type="submit" id="submit" class="form-control btn btn-success" name="search" value="ค้นหารายงาน">
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (isset($_POST['search'])) {

                        $date = $_POST['date'];
                        $sqlTotal = "SELECT * , SUM(total)AS sum 
                        FROM `shop_orders`
                        WHERE date(date) LIKE '%$date%' ";
                        $stmtTotal = $conndb->query($sqlTotal);
                        $stmtTotal->execute();
                        $rowTotal = $stmtTotal->fetchAll();
                        $rowTotal[0]['sum'] = $rowTotal[0]['sum'] ?? 0;


                    ?>

                        <div class="row">
                            <!-- หัวบิล -->
                            <div class="col mt-3">
                                <table class="table">

                                    <!-- หัวบิล -->
                                    <thead>
                                        <th class="text-left">บริษัท ภูเก็ต สปอร์ต ยูโทเปีย จำกัด</th>
                                        <th> <?= 'ชื่อผู้ใช้งาน :' . ' ' . $_SESSION['username']  ?></th>
                                        <th></th>
                                        <th>Rattachai Rawai Muay Thai gym รายงานขายสินค้า </th>
                                        <th> <?= 'วันที่ :' . ' ' . date('d-m-Y') ?></th>
                                    </thead>

                                    <!-- แยกประเภทวิธีการชำระ -->
                                    <thead>
                                        <th> แยกประเภทวิธีการชำระ </th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-right"> จำนวนครั้ง </th>
                                        <th class="text-right">ยอดขายรวม</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sqlCash = $conndb->query("SELECT  `pay`, COUNT(pay) as count , SUM(total) AS total
                                        FROM `shop_orders` 
                                        WHERE date(`date`) LIKE '%$date%' AND status = 1
                                        GROUP BY `pay`
                                        ORDER BY count DESC ");
                                        $sqlCash->execute();
                                        $totalAmount = 0;
                                        foreach ($sqlCash as $rowCash) : ?>
                                            <tr>
                                                <td><?= $rowCash['pay'] ?></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right"><?= $rowCash['count'] ?></td>
                                                <td colspan="2" class="text-right"><?= number_format($rowCash['total'], 2) ?></td>
                                            </tr>
                                            <?php $totalAmount =  $totalAmount += $rowCash['total'] ?>
                                        <?php endforeach ?>
                                        <tr class="text-danger">
                                            <th>ยอดรวมทั้งหมด</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-right "><?= number_format($totalAmount, 2) ?></th>
                                        </tr>
                                    </tbody>

                                    <!-- แยกประเภทการชำระแบบมีภาษี -->
                                    <thead>
                                        <th>แยกประเภทการชำระแบบมีภาษี</th>
                                        <th></th>
                                        <th class="text-right">หมายเลขบิล</th>
                                        <th class="text-right">ยอด</th>
                                        <th class="text-right">จำนวนภาษี</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql_pay = "SELECT id , pay , num_bill , total 
                                        FROM `shop_orders` 
                                        WHERE `date` LIKE '%$date%' AND pay != 'Cash' AND status = 1
                                        GROUP BY id";
                                        $stmt_pay = $conndb->query($sql_pay);
                                        $stmt_pay->execute();
                                        $vat = 0;
                                        $sumVat = 0;
                                        $sumRowPay = 0;
                                        foreach ($stmt_pay as $row_pay) : ?>
                                            <tr>
                                                <td> <?= $row_pay['pay'] ?> </td>
                                                <td></td>
                                                <td class="text-right"> <?= $row_pay['num_bill'] ?> </td>
                                                <td class="text-right"> <?= number_format($row_pay['total'], 2) ?> </td>
                                                <?php

                                                $vat = ($row_pay['total'] * 3) / 103

                                                ?>
                                                <td class="text-right"> <?= number_format($vat, 2) ?> </td>
                                            </tr>

                                            <?php $sumRowPay = $sumRowPay += $row_pay['total'] ?>
                                            <?php $sumVat = $sumVat += $vat  ?>

                                        <?php endforeach; ?>

                                        <tr class="text-danger">
                                            <td>ยอดรวมภาษี</td>
                                            <th colspan="4" class="text-right"><?= number_format($sumVat, 2) ?></th>
                                        </tr>
                                    </tbody>

                                    <!-- ประเภทรายการ -->
                                    <thead>
                                        <th> ประเภทรายการสินค้าและบริการ </th>
                                        <th></th>
                                        <th class="text-right"> ราคาสินค้า </th>
                                        <th class="text-right"> จำนวนครั้ง </th>
                                        <th class="text-right">ยอดรวม ( ไม่มีภาษี )</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sqlProduct = "SELECT shop_order_details.product_id , shop_order_details.product_name , shop_orders.total , shop_orders.pay,
                                        SUM(shop_order_details.quantity ) AS quantity , shop_order_details.price AS price
                                        FROM `shop_orders` 
                                        INNER JOIN `shop_order_details` ON shop_order_details.order_id = shop_orders.id
                                        WHERE date(shop_orders.date) LIKE '%$date%' AND status = 1
                                        GROUP BY shop_order_details.product_id
                                        ORDER BY quantity DESC;";
                                        $stmtProduct = $conndb->query($sqlProduct);
                                        $stmtProduct->execute();
                                        $sumTotal = 0;
                                        foreach ($stmtProduct as $rowProduct) : ?>
                                            <tr>
                                                <td><?= $rowProduct['product_name'] ?></td>
                                                <td></td>
                                                <td class="text-right"><?= number_format($rowProduct['price'], 2) ?></td>
                                                <td class="text-right"><?= $rowProduct['quantity'] ?></td>
                                                <td class="text-right"><?= number_format($rowProduct['quantity'] * $rowProduct['price'], 2) ?></td>
                                            </tr>

                                            <?php $sumTotal = $sumTotal += ($rowProduct['quantity'] * $rowProduct['price']) ?>
                                        <?php endforeach ?>

                                        <tr class="text-danger">
                                            <td>ยอดรวมทั้งหมด</td>
                                            <th></th>
                                            <th colspan="3" class="text-right"><?= number_format($sumTotal, 2) ?></th>
                                        </tr>
                                    </tbody>

                                    <!-- รายการบิลที่มีส่วนลด -->
                                    <thead>
                                        <th>รายการบิลที่มีส่วนลด หมายเลขบิล</th>
                                        <th></th>
                                        <th class="text-right">ราคาสินค้าก่อนส่วนลด</th>
                                        <th class="text-right">จำนวนส่วนลด</th>
                                        <th class="text-right">ยอดสุทธิ</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sqlDiscount = "SELECT id , num_bill , price , total , discount ,sub_discount
                                        FROM `shop_orders` 
                                        WHERE date(`date`) LIKE '%$date%' AND discount != 0 AND status = 1";
                                        $stmtDiscount = $conndb->query($sqlDiscount);
                                        $stmtDiscount->execute();
                                        $sumPrice = 0;
                                        $sub_discount = 0;
                                        $discountSum = 0;
                                        foreach ($stmtDiscount as $rowDiscount) : ?>
                                            <tr>
                                                <td><?= $rowDiscount['num_bill'] ?></td>
                                                <td></td>
                                                <td class="text-right"><?= number_format($rowDiscount['price'], 2) ?></td>
                                                <td class="text-right"><?= $rowDiscount['discount'] . ' % ' . ' | ' . number_format($rowDiscount['sub_discount'], 2) ?></td>
                                                <td class="text-right"><?= number_format($rowDiscount['total'], 2) ?></td>
                                            </tr>

                                            <?php
                                                $sumPrice = $sumPrice += $rowDiscount['price'];
                                                $sub_discount = $sub_discount += $rowDiscount['sub_discount'];
                                                $discountSum = $discountSum += $rowDiscount['total'];
                                            ?>



                                        <?php endforeach ?>
                                        <tr class="text-danger">
                                            <td>ยอดรวมทั้งหมด</td>
                                            <th colspan="2" class="text-right"><?= number_format($sumPrice, 2) ?></th>
                                            <th class="text-right"><?= number_format($sub_discount, 2) ?></th>
                                            <th class="text-right"><?= number_format($discountSum, 2) ?></th>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-success mb-3 form-control" id="printButton"><i class="fas fa-print">Print</i></button>
                        </div>
                    <?php }; ?>

                </div>
            </div>
        </div>

    </div>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../dist/js/adminlte.js"></script>
    <!-- datatables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

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