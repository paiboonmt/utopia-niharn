<?php
    session_start();
    $title = 'SALE TICKET | APPLICATION';
    include './middleware.php';
    $page = 'cart'; 
    $code = round(microtime(true));
    date_default_timezone_set('Asia/Bangkok');
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    require_once("../includes/connection.php");
    // ค้นหาหมายเลขบิล
    // <!-- หมายเลข บิล-->
    $rowBill['num_bill'] = 0;
    $billSql = $conndb->query("SELECT `num_bill` 
    FROM `orders` 
    WHERE date(date) =  CURDATE()
    ORDER BY `id` 
    DESC LIMIT 1 ");
    $billSql->execute();
    $count = $billSql->rowCount();

    if ( $count == 0 )  {
        $num_bill = date("dmy").+101;
    } else {
        foreach ( $billSql AS $rowBill) {
            $num_bill = $rowBill['num_bill'] + 1;
        }
    }
  
    unset($_SESSION['package']);
    unset($_SESSION['m_card']);
    unset($_SESSION['sta_date']);
    unset($_SESSION['exp_date']);
    unset($_SESSION['fname']);
    unset($_SESSION['comment']);
    unset($_SESSION['price']);
    unset($_SESSION['discount']);
    unset($_SESSION['pay']);
    unset($_SESSION['AddBy']);
    unset($_SESSION['code']);
    unset($_SESSION['vat7']);
    unset($_SESSION['vat3']);
    unset($_SESSION['code']);
    unset($_SESSION['message']);
    unset($_SESSION['date']);
    unset($_SESSION['grandTotal']);
    unset($_SESSION['productQty']);
    unset($_SESSION['discountOraginal']);
    unset($_SESSION['num_bill']);
    unset($_SESSION['detail']);
    unset($_SESSION['Last_order_details']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.png">
    <title><?=$title?></title>
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../dist/css/font.css">
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'aside.php'?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- รายการสินค้า -->
                        <div class="col-6">
                            <div class="card mt-2 p-2">
                                <table class="table table-sm " id="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อสินค้า บริการ</th>
                                            <th>ราคา</th>
                                            <th class="text-center">แก้ไขราคา</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i=1;
                                            $stmt = $conndb->query("SELECT * FROM `products` ORDER BY `product_name` ASC ");
                                            $stmt->execute();
                                            foreach ( $stmt AS $row ) :?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $row['product_name']?></td>
                                            <td><?= number_format($row['price'],2)?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-warning" data-toggle="modal"data-target="#id<?= $row['id'] ?>"><i class="fas fa-edit"></i></button>
                                            </td>
                                            <td class="text-center">
                                                <a href="cart/cart_add.php?id=<?= $row['id'] ?>&numBill=<?= $num_bill ?>"class="btn btn-success"><i class="fas fa-cart-plus"></i></a>
                                            </td>
                                            <!-- Modal แก้ราคาสินค้าที่นี้ -->
                                            <div class="modal fade" id="id<?= $row['id'] ?>" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form action="productSql.php" method="post">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span
                                                                            class="input-group-text">ชื่อสินค้าบริการ</span>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        name="product_name"
                                                                        value="<?= $row['product_name'] ?>">
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">ราคา</span>
                                                                    </div>
                                                                    <input type="number" class="form-control"
                                                                        name="price" value="<?= $row['price'] ?>">
                                                                </div>
                                                                <input type="hidden" name="id"
                                                                    value="<?= $row['id'] ?>">
                                                                <input type="submit" name="UpdatePrice"
                                                                    value="อัปเดท ราคา"
                                                                    class="form-control btn btn-success">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-6">
                            <?php if(isset($_SESSION['cart'])) :?>
                            <div class="card mt-2 p-2">
                                <a onclick="return confirm('Are your sure delete it ?')" href="cart/cart_remove.php" class="btn btn-danger">CLEAR CART</a>
                                <form action="./cart/cart_process.php" method="post">
                                    <table class="table table-sm" id="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>สินค้า</th>
                                                <th>ราคา</th>
                                                <th class="text-center">จำนวน</th>
                                                <th class="text-center">+  /  -</th>
                                                <th class="text-right">รวม</th>
                                                <th class="text-center">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                    $productIds = [];
                                                    $grantotal = 0;
                                                    foreach(($_SESSION['cart'] ?? []) as $cartId => $cartQty){
                                                        $productIds[] = $cartId; 
                                                    }
                                                    $Ids = 0;
                                                    if (count($productIds) > 0) {
                                                        $Ids = implode(', ', $productIds);
                                                    }
                                                    $i=1;
                                                    $stmts = $conndb->query("SELECT * FROM `products` WHERE id IN ($Ids)");
                                                    $stmts->execute();
                                                    foreach ( $stmts AS $rows ) : ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $rows['product_name']?></td>
                                                    <input type="hidden" name="product[<?= $rows['id'] ?>][id]" value="<?= $rows['id']?>">
                                                    <input type="hidden" name="product[<?= $rows['id'] ?>][price]" value="<?= $rows['price']?>">
                                                    <input type="hidden" name="product[<?= $rows['id'] ?>][name]" value="<?= $rows['product_name']?>">
                                                <td>
                                                    <?= number_format($rows['price'],2)?>
                                                </td>
                                                <td style="width: 20px;">
                                                    <input type="number" class="form-control text-center"  value="<?= $_SESSION['cart'][$rows['id']]  ?>">
                                                    <input type="hidden" name="quantity[<?= $rows['id'] ?>][quantity]" value="<?= $_SESSION['cart'][$rows['id']]  ?>">
                                                </td>
                                                <td class="text-center">
                                                    <a href="./cart/cart_update.php?id=<?= $rows['id'] ?>&action=updatecart" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></a>
                                                    <a href="./cart/cart_update.php?id=<?= $rows['id'] ?>&action=delete" class="btn btn-sm btn-danger"><i class="fas fa-minus"></i></a>
                                                </td>
                                                
                                                <td class="text-right">
                                                    <?=  number_format($_SESSION['cart'][$rows['id']] * $rows['price'] ,2) ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="cart/cart_delete.php?id=<?= $rows['id'] ?>" class="btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                            <?php $grantotal += $_SESSION['cart'][$rows['id']] * $rows['price'] ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-left">ยอดรวม : </th>
                                                <th class="text-right"><?= number_format($grantotal,2) ?></th>
                                                <th class="text-center">บาท</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <input type="hidden" name="code" value="<?= $code ?>">

                                    <!-- หมายเลขบิลก่อนหน้านี้ -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">หมายเลขบิลก่อนหน้านี้</label>
                                        </div>
                                        <input type="text" disabled class="form-control"
                                            value="<?= $rowBill['num_bill'] ?>">
                                    </div>

                                    <!-- หมายเลขบิล -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">หมายเลขบิล | Tax Number</label>
                                        </div>
                                        <input type="text" disabled class="form-control" value="<?=  $num_bill ?>">
                                        <input type="text" name="num_bill" hidden class="form-control" value="<?= $num_bill ?>">
                                    </div>

                                    <!-- หมายเลข -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">หมายเลขบัตร | Qrcode</label>
                                        </div>
                                        <input type="text" disabled class="form-control" value="<?= 2 * $code ?>">
                                        <input type="text" name="m_card" hidden class="form-control"
                                            value="<?= 2 * $code ?>">
                                    </div>

                                    <!-- ส่วนลด -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">ส่วนลด</label>
                                        </div>
                                        <select class="custom-select" name="discount">
                                            <option selected>0</option>
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
                                            <label class="input-group-text">ประเภทการจ่าย</label>
                                        </div>
                                        <?php 
                                            $sqlPayment = $conndb->query("SELECT * FROM `payment` ORDER BY `pay_id` ASC");
                                            $sqlPayment->execute();
                                        ?> 
                                        <select class="custom-select" name="pay" id="paymentMethodSelect" required>
                                            <option value="" disabled selected>... Choose ...</option>
                                            <?php foreach ( $sqlPayment AS $rowPayment ) :?>
                                                <option value="<?= $rowPayment['pay_name'] . ',' . $rowPayment['value'] ?>">
                                                <?= $rowPayment['pay_name'] ?>
                                            </option>
                                            <?php endforeach; ?> 
                                        </select>
                                    </div>

                                    <!-- Vat 7% -->
                                    <!-- <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Vat 7%</span>
                                        </div>
                                        <input type="text" name="vat7" class="form-control" id="paymentDetails7" value="0" required>
                                    </div> -->

                                    <!-- Charge Card 3% -->
                                    <!-- <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Charge Card 3%</span>
                                        </div>
                                        <input type="text" name="vat3" class="form-control" id="paymentDetails3"
                                            value="0" required>
                                    </div> -->

                                    <!-- เริ่ม / หมด -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text">เริ่ม</label>
                                                </div>
                                                <input type="date" name="sta_date" class="form-control"
                                                    value="<?= date('Y-m-d') ?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text">หมด</label>
                                                </div>
                                                <input type="date" name="exp_date" class="form-control"
                                                    value="<?= date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Customer name -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">Customer name</label>
                                        </div>
                                        <input type="text" name="fname" class="form-control" value="Customer" required>
                                    </div>
                                    <!-- comment -->
                                    <div class="form-group">
                                        <textarea class="form-control" name="comment" rows="3"
                                            placeholder="Enter Comment"></textarea>
                                    </div>
                                    <!-- Detail -->
                                    <div class="form-group">
                                    <textarea class="form-control" hidden name="detail" rows="3"></textarea>
                                    </div>

                                    <input type="text" hidden name="hostname" value="<?= $hostname ?>">

                                    <input type="text" name="price" hidden class="form-control"
                                        value="<?= $rows['price'] ?>">
                                    <input type="text" name="grandTotal" hidden class="form-control"
                                        value="<?= $grantotal ?>">
                                    <input type="submit" name="saveOrder" class="btn btn-success form-control">
                                </form>
                            </div>
                            <?php else : ?>
                            <div class="card mt-2 p-2">
                                <table class="table table-sm" id="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>สินค้า</th>
                                            <th>ราคา</th>
                                            <th>แก้ราคาสินค้า</th>
                                            <th>จำนวน</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>
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
    <!-- datatables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/jszip/jszip.min.js"></script>
    <script src="../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        
        var paymentMethodSelect = document.getElementById("paymentMethodSelect");
        var paymentDetailsInput3 = document.getElementById("paymentDetails3");
        var paymentDetailsInput7 = document.getElementById("paymentDetails7");

        paymentMethodSelect.addEventListener("change", function() {
            if (paymentMethodSelect.value === "Cash" ||
                paymentMethodSelect.value === "QrCode" ||
                paymentMethodSelect.value === "Paypal") {
                paymentDetailsInput7.value = "0", paymentDetailsInput3.value = "0";
            } else if (paymentMethodSelect.value === "CreditCard" ||
                paymentMethodSelect.value === "VisaCard" ||
                paymentMethodSelect.value === "MasterCard" ||
                paymentMethodSelect.value === "UnionPay" ||
                paymentMethodSelect.value === "AmericanExpress") {
                paymentDetailsInput3.value = "3", paymentDetailsInput7.value = "0";
            } else if ( paymentMethodSelect.value === "Cash and cardit card") {
                paymentDetailsInput7.value = "0";
                paymentDetailsInput3.value = "3";
            } else {
                paymentDetailsInput7.value = "0";
                paymentDetailsInput3.value = "0";
            }

        });
    </script>

    <script>
    $(function() {
        $("#table").DataTable({
            "pageLength": 13,
            // "stateSave": true,
            // "dom": 'rtip',
            // "searching": true,
            // "dom": 'rtip'
            // "info" : false
            // "stateSave" : true
        });
    });
    </script>

    <?php if (isset($_SESSION['carderror'])){ ?>
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        icon: 'error',
        title: 'หมายเลขบัตรซ้ำ กรูณากดใหม่'
    })
    </script>
    <?php } unset($_SESSION['carderror']);?>

    <?php if (isset($_SESSION['remove'])){ ?>
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        icon: 'success',
        title: 'remove successfully!'
    })
    </script>
    <?php } unset($_SESSION['remove']);?>

    <?php if (isset($_SESSION['add'])){ ?>
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        icon: 'success',
        title: 'Add item successfully!'
    })
    </script>
    <?php } unset($_SESSION['add']);?>

    <?php if (isset($_SESSION['update'])){ ?>
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        icon: 'success',
        title: 'Update item successfully!'
    })
    </script>
    <?php } unset($_SESSION['update']);?>

    <?php if (isset($_SESSION['addCart'])){ ?>
    <script>
    Swal.fire({
        toast: true,
        position: 'top-center',
        showConfirmButton: false,
        timer: 2000,
        icon: 'info',
        background: '#B6FFFA',
        title: 'Item add to cart '
    })
    </script>
    <?php } unset($_SESSION['addCart']);?>

    <?php if (isset($_SESSION['unsetItem'])){ ?>
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        icon: 'success',
        title: 'Remove item Succeflully'
    })
    </script>
    <?php } unset($_SESSION['unsetItem']);?>

    <?php if (isset($_SESSION['cartSuccess'])){ ?>
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        icon: 'success',
        title: 'ขายเรียบร้อยแล้ว'
    })
    </script>
    <?php } unset($_SESSION['cartSuccess']);?>

    <?php if (isset($_SESSION['updatePrice'])){ ?>
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        icon: 'success',
        title: 'อัปเดทราคาเรียบร้อย'
    })
    </script>
    <?php } unset($_SESSION['updatePrice']);?>

</body>

</html>

<?php $conndb = null; ?>