<?php
$title = 'REPORT | APPLICATION';
include '../middleware.php';
$page = 'reportShopMonth';
$date = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">

<?php include('./header.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'aside.php' ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row p-2">
                        <div class="col-8 p-2 mx-auto">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Choose</span>
                                            </div>
                                            <input type="month" name="date" class="form-control" required value="<?= $month ?>">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <input type="submit" name="search" class="btn btn-primary form-control" value="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php if (isset($_POST['search'])) { ?>
                            <h3><?= date('M-Y', strtotime($_POST['date'])) ?></h3>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card p-2">
                                <table id="example1" class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ.</th>
                                            <th hidden>หมายเลขบัตร</th>
                                            <th>หมายเลขบิล</th>
                                            <th>รายการ</th>
                                            <th>ราคารวม</th>
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
                                        <?php if (isset($_POST['search'])) { ?>
                                            <?php
                                            $sumTotal = 0;
                                            $month = $_POST['date'];
                                            $sql = "SELECT * ,`shop_orders`.total as sumtotal , shop_orders.price as sprice
                                                FROM `shop_orders` , `shop_order_details`
                                                WHERE `shop_orders`.`id` = `shop_order_details`.`order_id`
                                                AND DATE_FORMAT(shop_orders.date, '%Y-%m') = '$month'
                                                GROUP BY `shop_orders`.`id` DESC";
                                            $stmt = $conndb->query($sql);
                                            $stmt->execute();
                                            $count = 1;
                                            foreach ($stmt as $row) : ?>
                                                <?php if ($row['status'] == 1) : ?>
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
                                                        <td><?= number_format($row['sprice'], 2) ?></td>
                                                        <td><?= $row['discount'] . ' %' . ' | ' . $row['sub_discount'] ?></td>
                                                        <td style="width: 150px;"><?= $row['pay'] ?></td>
                                                        <td><?= $row['vat7'] ?></td>
                                                        <td><?= $row['vat3'] . ' %' . ' | ' . number_format($row['sub_vat'], 2) ?></td>
                                                        <td style="width: 170px;"><?= number_format($row['sumtotal'], 2) ?></td>
                                                        <td><?= date('d-m-Y H:i:s', strtotime($row['date'])) ?></td>
                                                        <td><?= $row['emp'] ?></td>

                                                        <td class="text-center">
                                                            <!-- <?php if ($_SESSION['role'] == 'admin') { ?>
                                                                <a href="./shop_voice.php?id=<?= $row['id'] ?>&action=voice" class="btn btn-sm btn-danger"><i class="fas fa-ban"></i> | ยกเลิกบิล </a>
                                                            <?php } ?> -->
                                                            <!-- <a href="?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="far fa-edit"></i> | แก้ไขบิล </a> -->
                                                            <!-- <a href="./shop_editbill.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="far fa-edit"></i> | แก้ไขบิล </a> -->
                                                            <a href="../shop/print/rePrintBil.php?id=<?= $row['id'] ?>" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-print"></i> | ปริ้นบิล </a>
                                                        </td>
                                                    </tr>

                                                    <?php $sumTotal += $row['sumtotal'] ?>

                                                <?php else : ?>
                                                    <tr style="font-size: 14px; background-color: #f8d7da;">
                                                        <td><?= $count++ ?></td>
                                                        <td hidden><?= $row['ref_order_id'] ?></td>
                                                        <td><?= $row['num_bill'] ?></td>
                                                        <td class="text-left">
                                                            Canceled
                                                        </td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td style="width: 150px;">0</td>
                                                        <td><?= '0' ?></td>
                                                        <td><?= '0' ?></td>
                                                        <td style="width: 170px;"><?= number_format('0', 2) ?></td>
                                                        <td><?= date('H:i', strtotime($row['date'])) ?></td>
                                                        <td><?= $row['emp'] ?></td>
                                                        <td colspan="2" class="text-center">
                                                            <a href="../shop/print/shop_voice_print.php?id=<?= $row['id'] ?>" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-print"></i> | ปริ้นบิล </a>
                                                        </td>
                                                    </tr>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if (isset($sumTotal)) : ?>
                            <div class="col-4 mx-auto">
                                <div class="alert alert-success text-center" role="alert">
                                    <h4>ยอดรวมทั้งหมด: <?= number_format($sumTotal, 2) ?> บาท</h4>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
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
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["excel"],
                "stateSave": true
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>

<?php $conndb = null; ?>