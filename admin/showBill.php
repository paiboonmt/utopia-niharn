<?php
$title = 'TICKET | TIGER APPLICATION';
include './middleware.php';
$page = 'recordticket';

if (isset($_GET['ref_order_id'])) {
    $ref_order_id = $_GET['ref_order_id'];
    $i = 1;
    $total = 0;
    $befortotal = 0;
    require_once("../includes/connection.php");
    $sql = "SELECT * 
        FROM `orders` as o
        INNER JOIN `order_details` as  os
        ON o.id = os.order_id
        WHERE ref_order_id = :ref_order_id ";

    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':ref_order_id', $ref_order_id, PDO::PARAM_INT);
    $stmt->execute();
    $countRow = $stmt->rowCount();
} else {
    header("Location: ./recordticket.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.png">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/font.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include './aside.php' ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="card mt-2 p-2">
                                <div class="card-header bg-success text-center">
                                    <h3>บิลขาย</h3>
                                </div>
                                <div class="card-body">
                                    <form action="./recordticketSql.php" method="post">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>สินค้า</th>
                                                    <th>ราคา</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($stmt as $row) : ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $row['product_name'] ?></td>
                                                        <input type="text" name="product_name" hidden value="<?= $row['product_name'] ?>">
                                                        <input type="text" name="product_id" hidden value="<?= $row['product_id'] ?>">
                                                        <td><?= number_format($row['price'], 2) ?></td>
                                                    </tr>

                                                    <?php $befortotal += $row['price'] ?>
                                                    <?php $total += $row['price'] ?>

                                                <?php endforeach; ?>

                                            </tbody>
                                            <tfoot>

                                                <?php if (!empty($row['discount'])) { ?>
                                                    <tr>
                                                        <td colspan="2">ราคารวม</td>
                                                        <td><?= number_format($total, 2) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>ส่วนลด </td>
                                                        <td><?= $row['discount'] . '%' ?></td>
                                                        <?php $discount = $row['discount'] * $total / 100  ?>
                                                        <td><?= number_format($discount, 2) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">ราคา - ส่วนลด</td>
                                                        <td><?= number_format($total - $discount, 2) ?></td>
                                                    </tr>
                                                <?php  } else { ?>
                                                    <tr>
                                                        <td colspan="2">ราคารวม</td>
                                                        <td><?= number_format($total, 2) ?></td>
                                                    </tr>

                                                <?php } ?>

                                                <?php
                                                $vat3 = 0;
                                                $vat7 = 0;
                                                if (!empty($row['discount'])) {
                                                    $total = $total - $discount;
                                                    if (!empty($row['vat7'])) {
                                                        $vat7 = ($total * 7) / 100;
                                                        if (!empty($row['vat3'])) {
                                                            $vat3 = (($total + $vat7) * 3 / 100);
                                                        }
                                                    }
                                                } else {
                                                    if (!empty($row['vat7'])) {
                                                        $vat7 = ($total * 7) / 100;
                                                        if (!empty($row['vat3'])) {
                                                            $vat3 = (($total + $vat7) * 3 / 100);
                                                        }
                                                    }
                                                }
                                                ?>

                                                <?php if (!empty($row['vat7'])) : ?>
                                                    <tr>
                                                        <td>ภาษี :</td>
                                                        <td><?= '7' . '%'; ?></td>
                                                        <td><?= number_format($vat7, 2); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>รวม + Vat7</td>
                                                        <td></td>
                                                        <td><?= number_format($total + $vat7, 2) ?></td>
                                                    </tr>
                                                <?php endif; ?>

                                                <?php if (!empty($row['vat3'])) : ?>
                                                    <tr>
                                                        <td>ภาษี :</td>
                                                        <td><?= '3' . '%'; ?></td>
                                                        <td><?= number_format($vat3, 2); ?></td>
                                                    </tr>
                                                <?php endif; ?>

                                                <?php
                                                if (!empty($row['discount'])) {
                                                    $total = $total  + $vat7 + $vat3;
                                                } else {
                                                    $total = $total  + $vat7 + $vat3;
                                                }
                                                ?>

                                                <tr>
                                                    <td colspan="2">รวมราคาทั้งหมด : </td>
                                                    <td> <?= number_format($total, 2) ?></td>
                                                </tr>

                                            </tfoot>
                                        </table>
                                        <!-- หมายเลขบิล -->
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text">หมายเลขบิล : </label>
                                            </div>
                                            <input type="text" disabled class="form-control" value="<?= $row['num_bill'] ?>">
                                            <input type="text" name="m_card" hidden class="form-control" value="<?= $row['num_bill'] ?>">
                                        </div>
                                        <!-- หมายเลข -->
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text">หมายเลข : </label>
                                            </div>
                                            <input type="text" disabled class="form-control" value="<?= $row['ref_order_id'] ?>">
                                            <input type="text" name="m_card" hidden class="form-control" value="<?= $row['ref_order_id'] ?>">
                                        </div>
                                        <!-- ส่วนลด -->
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text">ส่วนลด : </label>
                                            </div>
                                            <select class="custom-select" name="discount">
                                                <option selected><?= $row['discount'] ?></option>
                                                <option value="0">0%</option>
                                                <option value="5">5%</option>
                                                <option value="10">10%</option>
                                                <option value="15">15%</option>
                                                <option value="20">20%</option>
                                                <option value="25">25%</option>
                                                <option value="30">30%</option>
                                                <option value="35">35%</option>
                                                <option value="40">40%</option>
                                                <option value="45">45%</option>
                                                <option value="50">50%</option>
                                            </select>
                                        </div>
                                        <!-- ประเภทการจ่าย -->
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">ประเภทการจ่าย : </span>
                                            </div>
                                            <select class="custom-select" name="pay" id="paymentMethodSelect">
                                                <option selected><?= $row['pay'] ?></option>
                                                <option value="Cash">Cash</option>
                                                <option value="CreditCard">CreditCard</option>
                                                <option value="QrCode">QrCode</option>
                                                <option value="Paypal">Paypal</option>
                                                <option value="Direct">Direct</option>
                                                <option value="MoneyCard">MoneyCard</option>
                                                <option value="TMTCard">TMTCard</option>
                                                <option value="StudentVisa">StudentVisa</option>
                                                <option value="Depositcard">DepositCard</option>
                                            </select>
                                        </div>
                                        <!-- Vat 7% -->
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">ภาษี 7% : </span>
                                            </div>
                                            <input type="text" name="vat7" class="form-control" id="paymentDetails7" value="<?= $row['vat7'] ?>" required>
                                        </div>
                                        <!-- Charge Card 3% -->
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">บัตรเครดิตชาจ 3% : </span>
                                            </div>
                                            <input type="text" name="vat3" class="form-control" id="paymentDetails3" value="<?= $row['vat3'] ?>" required>
                                        </div>
                                        <!-- เริ่ม / หมด -->
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="input-group mb-1">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">เริ่ม</span>
                                                    </div>
                                                    <input type="date" name="sta_date" class="form-control" value="<?= $row['sta_date'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-group mb-1">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">หมด</span>
                                                    </div>
                                                    <input type="date" name="exp_date" class="form-control" value="<?= $row['exp_date'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Customer name -->
                                        <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">ชื่อลูกค้า : </span>
                                            </div>
                                            <input type="text" name="fname" class="form-control" value="<?= $row['fname'] ?>" required>
                                        </div>
                                        <!-- comment -->
                                        <div class="form-group">
                                            <textarea class="form-control" name="comment" rows="3"><?= $row['comment'] ?></textarea>
                                        </div>
                                        <input type="text" name="id" hidden class="form-control" value="<?= $row['id'] ?>">
                                        <input type="text" name="grandTotal" hidden class="form-control" value="<?= $total ?>">
                                        <div class="input-group mb-3">
                                            <input type="text" name="befortotal" hidden value="<?= $befortotal ?>">
                                            <input type="text" class="form-control" hidden value="<?= $total ?> บาท">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.js"></script>
    <script src="../plugins/toastr/toastr.min.js"></script>
    <script>
        var paymentMethodSelect = document.getElementById("paymentMethodSelect");
        var paymentDetailsInput3 = document.getElementById("paymentDetails3");
        var paymentDetailsInput7 = document.getElementById("paymentDetails7");

        paymentMethodSelect.addEventListener("change", function() {

            if (paymentMethodSelect.value === "Cash" || paymentMethodSelect.value === "QrCode") {
                paymentDetailsInput7.value = "7", paymentDetailsInput3.value = "0";
            } else if (paymentMethodSelect.value === "CreditCard") {
                paymentDetailsInput3.value = "3", paymentDetailsInput7.value = "0";
            } else {
                paymentDetailsInput7.value = "0";
                paymentDetailsInput3.value = "0";
            }

        });
    </script>

    <?php if (isset($_SESSION['updateBil'])) { ?>
        <script>
            Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    icon: 'success',
                    title: 'remove successfully!'
                }),

                document.getElementById("befor").hidden = true;
            document.getElementById("after").hidden = false;
        </script>

    <?php } else { ?> <script>
            document.getElementById("after").hidden = true;
        </script> <?php }
                unset($_SESSION['updateBil']); ?>

    <?php if (isset($_SESSION['editBill'])) : ?>
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                icon: 'success',
                title: 'แก้ไขข้อมูลสำเร็จ'
            });
        </script>
    <?php endif;
    unset($_SESSION['editBill']); ?>
</body>
</html>
<?php $conndb = null; ?>