<?php
$title = 'ยกเลิกบิลขายสินค้า | ร้านค้า';
include './middleware.php';
$page = 'recordshop';
require_once '../includes/connection.php';
include './layout/header.php';

if (isset($_POST['voice_bill'])) {

    // เรียกใช้ฟังก์ชัน getData
    include './shop/funtion.php'; // เรียกใช้ฟังก์ชัน
    getData();
    // exit;

    $id = $_POST['id'];
    if (cancelBill($conndb, $id)) {
        header("Location: recordshop.php");
        exit;
    } 
}

?>

<div class="wrapper">
    <?php include 'aside.php' ?>
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-8 mx-auto">
                        <div class="card mt-2 p-2">
                            
                            <div class="card-header bg-warning">
                                <span style="float: left;">
                                    <h3>
                                        <i class="fas fa-shopping-cart"></i> ยกเลิกบิลขายสินค้า
                                    </h3>
                                </span>
                            </div>

                            <div class="card-body">

                                <form action="" method="post">

                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>สินค้า</th>
                                                <th>ราคา</th>
                                                <th class="text-center">จำนวน</th>
                                                <th></th>
                                                <th></th>
                                                <th class="text-right">รวม</th>
                                                <!-- <th class="text-right">จัดการ</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $grantotal = 0;

                                            $total = 0;
                                            $id = $_GET['id'];
                                            $sql1 = "SELECT * 
                                                FROM `shop_orders`
                                                INNER JOIN `shop_order_details` ON shop_orders.id = shop_order_details.order_id
                                                WHERE id = ? ";

                                            $stmt = $conndb->prepare($sql1);
                                            $stmt->bindParam(1, $id, PDO::PARAM_INT);
                                            $stmt->execute();
                                            $check = $stmt->fetchAll();
                                            $checkCount = $stmt->rowCount();

                                            $idd = $check[0]['order_id'];
                                            $checkRow = "SELECT * FROM `shop_order_details` WHERE order_id = '$idd'";
                                            $stmtCheckRow = $conndb->prepare($checkRow);
                                            $stmtCheckRow->execute();
                                            $rowCount = $stmtCheckRow->rowCount();
                                            $i = 1;

                                            // print_r($check);
                                            foreach ($check as $rows) : ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $rows['product_name'] ?></td>
                                                    <td><?= number_format($rows['price'], 2) ?></td>
                                                    <td class="text-center">
                                                        <?= $rows['quantity']  ?>
                                                    </td>

                                                    <td class="text-right" colspan="3">
                                                        <?= number_format($rows['quantity'] * $rows['price'], 2) ?>
                                                    </td>
                                                </tr>
                                                <?php $grantotal += $rows['quantity'] * $rows['price'] ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-left">ยอดรวม : </th>
                                                <th class="text-right"><?= number_format($grantotal, 2) ?></th>
                                                <th class="text-center">บาท</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <!-- หมายเลขบิล -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">หมายเลขบิล | Tax Number |</label>
                                        </div>
                                        <input type="text" name="num_bill" class="form-control" value="<?= $rows['num_bill']  ?>" readonly>
                                    </div>

                                    <!-- หมายเลข -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">หมายเลขบัตร | Qrcode |</label>
                                        </div>
                                        <input type="text" name="m_card" readonly class="form-control" value="<?= $rows['ref_order_id'] ?>">
                                    </div>

                                    <!-- ส่วนลด -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">Discoount</label>
                                        </div>                                         
                                         <input type="text" name="discount" class="form-control" value="<?= $rows['discount'] ?>" readonly>
                                         
                                    </div>

                                    <!-- ประเภทการจ่าย -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">ประเภทการจ่าย |</label>
                                        </div>
                                       <input type="text" name="pay" readonly class="form-control" value="<?= $rows['pay'] ?>">
                                    </div>

                                    <!-- ยอดรวม -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">ยอดรวม</label>
                                        </div>
                                        <input type="text" name="grantotal" readonly class="form-control" value="<?= number_format($grantotal, 2) ?>">
                                    </div>

                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">หมายเหตุ</label>
                                        </div>
                                        <input type="text" name="comment" class="form-control" required >
                                    </div>

                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">ผู้ขาย</label>
                                        </div>
                                        <input type="text" name="emp" readonly class="form-control" value="<?= $rows['emp'] ?>">
                                    </div>

                                    <input type="hidden" name="id" value="<?= $rows['id'] ?>">
                                    <input type="hidden" name="order_id" value="<?= $rows['order_id'] ?>">
                                    <input type="submit" name="voice_bill" value="ยกเลิกบิล" onclick="return confirm('คุณต้องการอัปเดทข้อมูลใช่หรือไม่')" class="btn btn-danger btn-block">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './layout/footer.php' ?>

<script>
    $(function() {
        $("#table").DataTable({
            "pageLength": 13,
        });
    });
</script>

</body>

</html>
<?php $conndb = null; ?>