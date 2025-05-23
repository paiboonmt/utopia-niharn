<?php
$title = 'SALE TICKET | APPLICATION';
include './middleware.php';
$page = 'shop';

$code = round(microtime(true));
date_default_timezone_set('Asia/Bangkok');
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
require_once("../includes/connection.php");
require_once("./shop/function_shop_cart.php");
// ค้นหาหมายเลขบิล
// <!-- หมายเลข บิล-->
$rowBill['num_bill'] = 0;
$billSql = $conndb->query("SELECT `num_bill` 
    FROM `shop_orders` 
    WHERE date(date) =  CURDATE()
    ORDER BY `id` 
    DESC LIMIT 1 ");
$billSql->execute();
$count = $billSql->rowCount();

if ($count == 0) {
    $num_bill = date("dmy") . +101;
} else {
    foreach ($billSql as $rowBill) {
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

include './layout/header.php';
?>

<div class="wrapper">
    <?php include 'aside.php' ?>
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
                                        <th class="text-center">จำนวนสินค้าคงเหลือ</th>
                                        <th class="text-center">เลือก</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $products = getProduct($conndb);
                                    foreach ($products as $row) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= number_format($row['price'], 2) ?></td>
                                            <th class="text-center"><?= $row['quantity'] ?> ชิ้น</th>
                                            <td class="text-center">
                                                <a href="shop/cart_add.php?id=<?= $row['id'] ?>&numBill=<?= $num_bill ?>" class="btn btn-success"><i class="fas fa-cart-plus"></i></a>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-6">
                        <?php if (isset($_SESSION['cart'])) : ?>
                            <div class="card mt-2 p-2">
                                <h4 class="text-center">รายการสินค้าในตะกร้า</h4>
                                <a onclick="return confirm('Are your sure delete it ?')" href="./shop/cart_remove.php" class="btn btn-danger">ยกเลิกสินค้าทั้งหมด</a>

                                <form action="./shop/shop_process.php" method="post">

                                    <table class="table table-sm" id="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>สินค้า</th>
                                                <th>ราคา</th>
                                                <th class="text-center">จำนวน</th>
                                                <th class="text-center">+ / -</th>
                                                <th class="text-right">รวม</th>
                                                <th class="text-center">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $productIds = [];
                                            $grantotal = 0;
                                            foreach (($_SESSION['cart'] ?? []) as $cartId => $cartQty) {
                                                $productIds[] = $cartId;
                                            }
                                            $Ids = 0;
                                            if (count($productIds) > 0) {
                                                $Ids = implode(', ', $productIds);
                                            }
                                            $i = 1;
                                            $stmts = $conndb->query("SELECT * FROM `store` WHERE id IN ($Ids)");
                                            $stmts->execute();
                                            foreach ($stmts as $rows) : ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $rows['name'] ?></td>
                                                    <input type="hidden" name="product[<?= $rows['id'] ?>][id]" value="<?= $rows['id'] ?>">
                                                    <input type="hidden" name="product[<?= $rows['id'] ?>][price]" value="<?= $rows['price'] ?>">
                                                    <input type="hidden" name="product[<?= $rows['id'] ?>][name]" value="<?= $rows['name'] ?>">
                                                    <td>
                                                        <?= number_format($rows['price'], 2) ?>
                                                    </td>
                                                    <td style="width: 20px;">
                                                        <input type="text" class="btn btn-sm" value="<?= $_SESSION['cart'][$rows['id']]  ?>" readonly>
                                                        <input type="hidden" name="quantity[<?= $rows['id'] ?>][quantity]" value="<?= $_SESSION['cart'][$rows['id']]  ?>">
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="./shop/cart_update.php?id=<?= $rows['id'] ?>&action=updatecart" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></a>
                                                        <a href="./shop/cart_update.php?id=<?= $rows['id'] ?>&action=delete" class="btn btn-sm btn-danger"><i class="fas fa-minus"></i></a>
                                                    </td>

                                                    <td class="text-right">
                                                        <?= number_format($_SESSION['cart'][$rows['id']] * $rows['price'], 2) ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="cart/cart_delete.php?id=<?= $rows['id'] ?>" class="btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                                <?php $grantotal += $_SESSION['cart'][$rows['id']] * $rows['price'] ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <input type="number" name="OriginalGrantotal" value="<?= $grantotal ?>" hidden>
                                            <tr>
                                                <th colspan="5" class="text-left">ยอดรวม : </th>
                                                <th class="text-right"><?= number_format($grantotal, 2) ?></th>
                                                <th class="text-center">บาท</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <input type="hidden" name="code" value="<?= $code ?>">

                                    <!-- หมายเลขบิลก่อนหน้านี้ -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">หมายเลขบิลก่อนหน้านี้ |</label>
                                        </div>
                                        <input type="text" readonly class="form-control" value="<?= $rowBill['num_bill'] ?>">
                                    </div>

                                    <!-- หมายเลขบิล -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">หมายเลขบิล | Tax Number |</label>
                                        </div>
                                        <input type="text" name="num_bill" class="form-control" value="<?= $num_bill ?>" readonly>
                                    </div>

                                    <!-- หมายเลข -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">หมายเลขบัตร | Qrcode |</label>
                                        </div>
                                        <input type="text" name="m_card" readonly class="form-control" value="<?= 5 * $code ?>">
                                    </div>

                                    <!-- ส่วนลด -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">ส่วนลด |</label>
                                        </div>
                                        <?php
                                        include './discount/function-discount.php';
                                        $discounts = getDiscounts($conndb);
                                        ?>
                                        <select class="form-control"  name="discount" id="discountMethodSelect">
                                            <option value="0" selected>0 %</option>
                                            <?php foreach ($discounts as $rowDiscount) : ?>
                                                <option value="<?= $rowDiscount['amount'] ?>"><?= $rowDiscount['amount'] ?> %</option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>

                                    <!-- ประเภทการจ่าย -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">ประเภทการจ่าย |</label>
                                        </div>
                                        <?php
                                        $sqlPayment = $conndb->query("SELECT * FROM `payment` ORDER BY `pay_id` ASC");
                                        $sqlPayment->execute();
                                        ?>
                                        <select class="custom-select" name="pay" id="paymentMethodSelect" required>
                                            <option value="" disabled selected>... Choose ...</option>
                                            <?php foreach ($sqlPayment as $rowPayment) : ?>
                                                <option value="<?= $rowPayment['pay_name'] . ',' . $rowPayment['value'] ?>">
                                                    <?= $rowPayment['pay_name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- ยอดรวม -->
                                    <!-- <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">จำนวนยอดรวม</label>
                                        </div>
                                        <input type="number" class="form-control" name="grandTotal" value="" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text">บาท</span>
                                        </div>
                                    </div> -->

                                    <input type="text" name="price" hidden class="form-control" value="<?= $rows['price'] ?>">
                                    <input type="text" name="grandTotal" hidden class="form-control">

                                    <input type="submit" name="saveOrder" value="ขายสินค้า" class="btn btn-success form-control">
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