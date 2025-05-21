<?php
$title = 'รายการขายสินค้า';
include './middleware.php';
$page = 'recordshop';
require_once '../includes/connection.php';
include './layout/header.php';
?>

<div class="wrapper">
    <?php include './aside.php' ?>
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12 p-1">
                        <div class="card p-1">
                            <div class="card-header bg-info">
                                <span style="float: left;">
                                    <h3>ประวัติการขายสินค้า</h3>
                                </span>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm" id="example1">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ.</th>
                                            <th hidden>หมายเลขบัตร</th>
                                            <th>หมายเลขบิล</th>
                                            <th>รายการ</th>
                                            <th>ส่วนลด</th>
                                            <th>ประเภทการจ่าย</th>
                                            <th>ภาษี 7%</th>
                                            <th>ภาษี 3%</th>
                                            <th>ยอดรวม</th>
                                            <th>เวลา</th>
                                            <th>ผู้ขาย</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sumTotal = 0;
                                        $date = date('Y-m-d');
                                        $sql = "SELECT * ,`shop_orders`.total as sumtotal
                                                FROM `shop_orders` , `shop_order_details`
                                                WHERE `shop_orders`.`id` = `shop_order_details`.`order_id`
                                                AND shop_orders.date LIKE '%$date%' GROUP BY `shop_orders`.`id` DESC";
                                        $stmt = $conndb->query($sql);
                                        $stmt->execute();
                                        $count = 1;
                                        foreach ($stmt as $row) : ?>
                                            <tr style="font-size: 14px;">
                                                <td><?= $count++ ?></td>
                                                <td hidden><?= $row['ref_order_id'] ?></td>
                                                <td><?= $row['num_bill'] ?></td>
                                                <td class="text-left">
                                                    <?php
                                                    $idd = $row['id'];
                                                    $checkRow = "SELECT product_name , quantity , price as ppp  
                                                    FROM `shop_order_details` 
                                                    WHERE order_id = '$idd'";
                                                    $stmtCheckRow = $conndb->prepare($checkRow);
                                                    $stmtCheckRow->execute();
                                                    $rowCount = $stmtCheckRow->rowCount();
                                                    foreach ($stmtCheckRow as $A) : ?>
                                                        <?php echo $A['product_name'] . ' : ' . ' ' . ' | ' . ' x ' . ' | ' . $A['quantity'] . '<br>'; ?>
                                                    <?php endforeach; ?>
                                                </td>
                                                <td><?= $row['sub_discount'] ?></td>
                                                <td style="width: 150px;"><?= $row['pay'] ?></td>
                                                <td><?= $row['vat7'] ?></td>
                                                <td><?= number_format($row['sub_vat'], 2) ?></td>
                                                <td style="width: 170px;"><?= number_format($row['sumtotal'], 2) ?></td>
                                                <td><?= date('H:i', strtotime($row['date'])) ?></td>
                                                <td><?= $row['emp'] ?></td>

                                                <td class="text-center">
                                                    <?php if ($_SESSION['role'] == 'admin') { ?>
                                                        <a href="?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"><i class="fas fa-ban"></i> | ยกเลิกบิล </a>
                                                    <?php } ?>
                                                    <a href="./shop_editbill.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="far fa-edit"></i> | แก้ไขบิล </a>
                                                    <a href="./shop/print/rePrintBil.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-print"></i> | ปริ้นบิล </a>
                                                </td>

                                            </tr>

                                            <?php $sumTotal += $row['sumtotal'] ?>
                                        <?php endforeach ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card p-2">
                            <div class="card-header">
                                สรุปยอดรวม
                            </div>
                            <div class="card-body">
                                <table>
                                    <tr>
                                        <td style="width: 150px;">ยอดรวม</td>
                                        <td style="width: 10px;">:</td>
                                        <td style="width: 100px;"><?= number_format($sumTotal, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>จำนวนบิล</td>
                                        <td>:</td>
                                        <td><?= $count - 1 ?></td>
                                    </tr>
                                    <tr>
                                        <td>วันที่</td>
                                        <td>:</td>
                                        <td><?= date('d/m/Y') ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './layout/footer.php'; ?>


<?php if (isset($_SESSION['canotFind'])) : ?>
    <script>
        Swal.fire({
            title: "This number was not found.",
            text: "You clicked the button!",
            icon: "warning"
        });
    </script>
<?php endif;
unset($_SESSION['canotFind'])  ?>

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["excel"],
            "stateSave": true
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
</body>

</html>
<?php $conndb = null; ?>