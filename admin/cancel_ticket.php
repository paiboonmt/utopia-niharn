<?php
$title = 'Cancel Ticket';
include 'middleware.php';
$page = 'cancel_ticket';

if (isset($_GET['id'])) {
    include '../includes/connection.php';
    include './ticket/cancel_ticket_function.php';
    $result = getData($conndb, $_GET['id']);
}



include 'layout/header.php';
?>

<div class="wrapper">
    <?php include 'aside.php' ?>
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row p-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-danger">
                                <h3 class="card-title">ยกเลิกบิล <?php echo $result['num_bill']; ?></h3>
                            </div>
                            <form action="ticket/cancel_ticket.php" method="post" id="cancelTicketForm">
                                <div class="card-body">

                                    <div class="row">

                                        <!-- order_id -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="order_id">เลขที่ออเดอร์</label>
                                                <input type="text" class="form-control" name="order_id" value="<?= $result['id']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- ref_order_id -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="num_bill">หมายเลขบัตร</label>
                                                <input type="text" class="form-control" id="num_bill" name="num_bill" value="<?= $result['ref_order_id']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- num_bill -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="ref_order_id">เลขที่อ้างอิง</label>
                                                <input type="text" class="form-control" id="ref_order_id" name="ref_order_id" value="<?= $result['num_bill']; ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="cancel_by">ยกเลิกโดย</label>
                                                <input type="text" class="form-control" id="cancel_by" name="cancel_by" value="<?= $_SESSION['username']; ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="cancel_by">วิธีการชำระสินค้า</label>
                                                <input type="text" class="form-control" id="cancel_by" name="cancel_by" value="<?= $result['pay']; ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="cancel_by">ส่วนลดสินค้า</label>
                                                <input type="text" class="form-control" id="cancel_by" name="cancel_by" value="<?= $result['discount']; ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="cancel_by">ภาษี7%</label>
                                                <input type="text" class="form-control" id="cancel_by" name="cancel_by" value="<?= $result['vat7']; ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="cancel_by">ภาษี3%</label>
                                                <input type="text" class="form-control" id="cancel_by" name="cancel_by" value="<?= $result['vat3']; ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="cancel_by">ราคาสินค้า</label>
                                                <input type="text" class="form-control" id="cancel_by" name="cancel_by" value="<?= $result['price']; ?>" readonly>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-6 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="cancel_reason">เหตุผลการยกเลิก</label>
                                                <textarea class="form-control" id="cancel_reason" name="cancel_reason" rows="3" required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col me-auto">
                                            <a href="" class="btn btn-dark">ย้อนกลับ</a>
                                        </div>
                                        <input type="submit" name="cancel_bill" class="btn btn-danger col-6" value="ยกเลิกรายการ" onclick="return confirm('คุณแน่ใจแล้วใช่ไหม?')">
                                    </div>
                                </div>


                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'layout/footer.php'; ?>

        </body>

        </html>
        <?php $conndb = null; ?>

        <?php
        echo '<pre>';
        print_r($result);
        echo '</pre>';
        ?>