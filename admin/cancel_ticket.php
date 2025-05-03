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
                            <form action="ticket/voiceTicket.php" method="post">
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
                                                <input type="text" class="form-control"  name="num_bill" value="<?= $result['ref_order_id']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- fname -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="fname">ชื่อ-นามสกุล</label>
                                                <input type="text" class="form-control"  name="fname" value="<?= $result['fname']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- discount -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="discount">ส่วนลด</label>
                                                <input type="text" class="form-control"  name="discount" value="<?= $result['discount']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- price -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="price">ราคาสินค้า</label>
                                                <input type="text" class="form-control"  name="price" value="<?= $result['price']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- vat7 -->   
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="vat7">ภาษี 7%</label>
                                                <input type="text" class="form-control"  name="vat7" value="<?= $result['vat7']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- vat3 -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="vat3">ภาษี 3%</label>
                                                <input type="text" class="form-control" name="vat3" value="<?= $result['vat3']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- pay -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="pay">วิธีการชำระเงิน</label>
                                                <input type="text" class="form-control"  name="pay" value="<?= $result['pay']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- sta_date -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="sta_date">วันที่เริ่มต้น</label>
                                                <input type="text" class="form-control"  name="sta_date" value="<?= $result['sta_date']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- exp_date -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="exp_date">วันที่สิ้นสุด</label>
                                                <input type="text" class="form-control"  name="exp_date" value="<?= $result['exp_date']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- comment -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="comment">หมายเหตุ</label>
                                                <input type="text" class="form-control"  name="comment" value="<?= $result['comment']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- total -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="total">ยอดรวม</label>
                                                <input type="text" class="form-control"  name="total" value="<?= $result['total']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- date -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="date">วันที่</label>
                                                <input type="text" class="form-control"  name="date" value="<?= $result['date']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- hostname -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="hostname">ชื่อเครื่อง</label>
                                                <input type="text" class="form-control"  name="hostname" value="<?= $result['hostname']; ?>" readonly>
                                            </div>
                                        </div>
                                        <!-- emp -->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="emp">พนักงาน</label>
                                                <input type="text" class="form-control"  name="emp" value="<?= $result['emp']; ?>" readonly>
                                            </div>
                                        </div>
                                      

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="cancel_by">ยกเลิกโดย</label>
                                                <input type="text" class="form-control"  name="cancel_by" value="<?= $_SESSION['username']; ?>" readonly>
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

                                    <input type="submit" name="cancel_bill" class="btn btn-danger col-4 mr-auto" value="ยกเลิกรายการ" onclick="return confirm('คุณแน่ใจแล้วใช่ไหม?')">
                                    
                                    <a href="./recordticket.php" class="btn btn-dark col-4">ย้อนกลับ</a>

                                
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
<!-- 
        <?php
        echo '<pre>';
        print_r($result);
        echo '</pre>';
        ?> -->