<?php
$title = 'REPORT TICKET | APPLICATION';
include './middleware.php';
$page = 'recordticket';
$hostname = gethostname();
unset($_SESSION['total']);
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
                                            <th>หมายเลขบัตร</th>
                                            <th>หมายเลขบิล</th>
                                            <th hidden>ชื่อลูกค้า</th>
                                            <th>รายการ</th>
                                            <th>ประเภทการจ่าย</th>
                                            <th>ส่วนลด</th>
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
                                        $sql = "SELECT orders.id , orders.ref_order_id , orders.fname ,
                                            orders.pay ,  orders.price ,orders.discount , orders.vat7 , orders.vat3 , orders.total , 
                                            orders.num_bill, member.AddBy , member.status_code, member.package ,orders.date , member.id AS mid,
                                            member.m_card , orders.sta_date , orders.exp_date , orders.comment 
                                            FROM `member` , `orders` 
                                            WHERE member.m_card = orders.ref_order_id
                                            AND orders.date LIKE '%$date%'
                                            GROUP BY member.m_card
                                            ORDER BY member.id DESC";
                                        $stmt = $conndb->query($sql);
                                        $stmt->execute();
                                        $count = 1;
                                        foreach ($stmt as $row) : ?>
                                            <?php if ($row['status_code'] == 5) : ?>
                                                <tr class="bg-warning" style="font-size: 14px;">
                                                    <td><?= $count++ ?></td>
                                                    <td><?= $row['m_card'] ?></td>
                                                    <td><?= $row['num_bill'] ?></td>
                                                    <td hidden><?= $row['fname'] ?></td>
                                                    <td><?= 0 ?></td>
                                                    <td><?= 0 ?></td>
                                                    <td><?= 0 ?></td>
                                                    <td><?= 0 ?></td>
                                                    <td><?= 0 ?></td>
                                                    <td><?= 0 ?></td>
                                                    <td><?= date('H:i', strtotime($row['date'])) ?></td>
                                                    <td><?= $row['AddBy'] ?></td>
                                                    <td class="text-center">
                                                        <a onclick="return confirm('คุณต้องการลบบิลจริงหรือ ?')" href="./recordticketSql.php?id=<?= $row['id'] ?>&act=delete" class="btn btn-danger btn-sm disabled"><i class="fas fa-trash"></i></a>

                                                        <a href="./voidPrint.php?ref_order_id=<?= $row['ref_order_id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-print"></i></a>
                                                    </td>
                                                </tr>
                                            <?php else : ?>
                                                <tr style="font-size: 14px;">
                                                    <td><?= $count++ ?></td>
                                                    <td><?= $row['ref_order_id'] ?></td>
                                                    <td><?= $row['num_bill'] ?></td>
                                                    <td class="text-left">
                                                        <?php
                                                        $idd = $row['id'];
                                                        $checkRow = "SELECT product_name , quantity , price as ppp  FROM `order_details` WHERE order_id = '$idd'";
                                                        $stmtCheckRow = $conndb->prepare($checkRow);
                                                        $stmtCheckRow->execute();
                                                        $rowCount = $stmtCheckRow->rowCount();
                                                        foreach ($stmtCheckRow as $A) : ?>
                                                            <?php echo $A['product_name'] . ' : ' . ' ' . ' | ' . ' x ' . ' | ' . $A['quantity'] . '<br>'; ?>
                                                        <?php endforeach; ?>
                                                    </td>

                                                    <td hidden><?= $row['fname'] ?></td>
                                                    <td style="width: 150px;"><?= $row['pay'] ?></td>
                                                    <td><?= $row['discount'] ?></td>
                                                    <td><?= $row['vat7'] ?></td>
                                                    <td><?= $row['vat3'] ?></td>
                                                    <td style="width: 170px;"><?= number_format($row['total'], 2) ?></td>
                                                    <td><?= date('H:i', strtotime($row['date'])) ?></td>
                                                    <td><?= $row['AddBy'] ?></td>

                                                    <td>
                                                        <?php if ($_SESSION['role'] == 'admin') { ?>
                                                            <a href="cancel_ticket.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"><i class="fas fa-ban"></i> | ยกเลิกบิล </a>
                                                        <?php } ?>
                                                        <a href="recordticketEdit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="far fa-edit"></i> | แก้ไขบิล </a>
                                                        <a href="cart/print/rePrintBil.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-print"></i> | ปริ้นบิล </a>
                                                    </td>

                                                </tr>
                                            <?php endif ?>

                                            <?php $sumTotal = $sumTotal + $row['total'] ?>

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