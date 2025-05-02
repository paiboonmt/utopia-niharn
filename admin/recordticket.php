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
                                            <th class="text-right">ยอดรวม</th>
                                            <th>เวลา</th>
                                            <th>ผู้ขาย</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
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
                                                    <td hidden><?= $row['num_bill'] ?></td>
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
                                                    <td class="text-right" style="width: 170px;"><?= number_format($row['total'], 2) ?></td>
                                                    <td><?= date('H:i', strtotime($row['date'])) ?></td>
                                                    <td><?= $row['AddBy'] ?></td>

                                                    <td>
                                                        <?php if ($_SESSION['role'] == 'admin') { ?>
                                                            <!-- <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#id<?= $row['id'] ?>">
                                                                <i class="fas fa-ban"></i>
                                                            </button> -->
                                                            <a href="cancel_ticket.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"><i class="fas fa-ban"></i> | ยกเลิกบิล </a>
                                                        <?php } ?>
                                                        <a href="recordticketEdit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="far fa-edit"></i>  | แก้ไขบิล </a>
                                                        <a href="cart/print/rePrintBil.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-print"></i> | ปริ้นบิล </a>
                                                    </td>

                                                    <!-- Modal Voice ticket -->
                                                    <div class="modal fade" id="id<?= $row['id'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Voice item : <?= $row['ref_order_id'] ?></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <!-- <form action="./NewvoiceTicket.php" method="post"> -->
                                                                    <form action="./ticket/voiceTicket.php" method="post">

                                                                        <input type="hidden" name="comment" value="<?= $row['comment'] ?>">
                                                                        <input type="hidden" name="hostname " value="<?= $hostname ?>">

                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">OrderId</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" disabled name="order_id" value="<?= $row['id'] ?>">
                                                                            <input type="hidden" class="form-control" name="order_id" value="<?= $row['id'] ?>">
                                                                        </div>

                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Card number</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" disabled name="ref_order_id" value="<?= $row['ref_order_id'] ?>">
                                                                            <input type="hidden" class="form-control" name="ref_order_id" value="<?= $row['ref_order_id'] ?>">
                                                                        </div>

                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Text id</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" disabled name="num_bill" value="<?= $row['num_bill'] ?>">
                                                                            <input type="hidden" class="form-control" name="num_bill" value="<?= $row['num_bill'] ?>">
                                                                        </div>

                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Customer name</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" disabled name="fname" value="<?= $row['fname'] ?>">
                                                                            <input type="hidden" class="form-control" name="fname" value="<?= $row['fname'] ?>">
                                                                        </div>

                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Create at</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" disabled name="date" value="<?= $row['date'] ?>">
                                                                            <input type="hidden" class="form-control" name="date" value="<?= $row['date'] ?>">
                                                                        </div>

                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Price of ordered</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" disabled name="price" value="<?= $row['price'] ?>">
                                                                            <input type="hidden" class="form-control" name="price" value="<?= $row['price'] ?>">
                                                                        </div>

                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Payment</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" disabled name="pay" value="<?= $row['pay'] ?>">
                                                                            <input type="hidden" class="form-control" name="pay" value="<?= $row['pay'] ?>">
                                                                        </div>

                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Discount</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" disabled name="discount" value="<?= $row['discount'] ?>">
                                                                            <input type="hidden" class="form-control" name="discount" value="<?= $row['discount'] ?>">
                                                                        </div>

                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Vat7</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" disabled name="vat7" value="<?= $row['vat7'] ?>">
                                                                            <input type="hidden" class="form-control" name="vat7" value="<?= $row['vat7'] ?>">
                                                                        </div>

                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Vat3</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" disabled name="vat3" value="<?= $row['vat3'] ?>">
                                                                            <input type="hidden" class="form-control" name="vat3" value="<?= $row['vat3'] ?>">
                                                                        </div>

                                                                        <div class="input-group mb-1">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Total Amount</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" disabled name="total" value="<?= $row['total'] ?>">
                                                                            <input type="hidden" class="form-control" name="total" value="<?= $row['total'] ?>">
                                                                        </div>

                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="">Date Start || Expired date</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" disabled value="<?= $row['sta_date'] ?> || <?= $row['exp_date'] ?> ">
                                                                            <input type="hidden" class="form-control" name="sta_date" value="<?= $row['sta_date'] ?>">
                                                                            <input type="hidden" class="form-control" name="exp_date" value="<?= $row['exp_date'] ?>">
                                                                        </div>

                                                                        <input type="hidden" class="form-control" name="user" value="<?= $_SESSION['username'] ?>">

                                                                </div>

                                                                <div class="modal-footer">
                                                                    <input type="submit" name="voice" class="btn btn-danger col-7" value="ยกเลิกรายการ" onclick="return confirm('Are your sure delete it ?')">
                                                                    <button type="button" class="btn btn-secondary col-4" data-dismiss="modal">ยกเลิก</button>
                                                                </div>

                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </tr>
                                            <?php endif ?>
                                        <?php endforeach ?>
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