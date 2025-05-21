<hr>
<div class="row">
    <h5>Rattachai Academy Gym</h5>
    <h5>TAX : 0835561020601 ( VAT Included )</h5>
    <h5>ใบเสร็จรับเงิน/ใบกำกับภาษีอย่างย่อ</h5>
</div>
<hr>

<div class="row">
    <div class="col"><span>Tax inv. No</span></div>
    <div class="col" id="col"><span><?= $row[0]['num_bill'] ?></span></div>
</div>

<div class="row">
    <div class="col"><span>Tax inv. Date</span></div>
    <div class="col" id="col"><span><?= date('d-m-Y | H:i:s') ?></span></div>
</div>

<div class="row">
    <div class="col"><span>QR CODE :</span></div>
    <div class="col" id="col"><span><?= $row[0]['ref_order_id'] ?></span></div>
</div>

<hr>
<!--  product_name / price -->
<?php
$total = 0;
$id = $_GET['id'];
$sql1 = "SELECT * , `shop_orders`.total as sumtotal
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

foreach ($check as $rowq) : ?>

    <div class="row">
        <div class="col col-12"><span><?= $rowq['product_name'] ?></span></div>
        <div class="col"><span>Qty :<span><?= $rowq['quantity'] ?></span> </div>
        <div class="col" id="col"><span><?= number_format($rowq['price'] * $rowq['quantity'], 2) ?></span> </div>
    </div>

    <?php $total += $rowq['price'] * $rowq['quantity'] ?>

<?php endforeach; ?>

<hr>

<div class="row">
    <div class="col"><span>Total Bath : </span></div>
    <div class="col" id="col"><span><?= number_format($total, 2) ?></span></div>
</div>

<!-- Discount -->
<?php if ($row[0]['sub_discount'] != 0) : ?>
    <div class="row">
        <div class="col"><span>Discount : <?= $row[0]['discount'] ?> %</span></div>
        <div class="col" id="col"><span><?= number_format($row[0]['sub_discount'], 2) ?> </span></div>
    </div>
    <div class="row">
        <div class="col"><span>Discounted price : </span></div>
        <div class="col" id="col"><span><?= number_format($row[0]['sumtotal'], 2) ?> </span></div>
    </div>
<?php endif; ?>

<hr>

<div class="row">
    <div class="col"><span>Payment :</span></div>
    <div class="col" id="col"><span><?= $row[0]['pay'] ?></span> </div>
</div>

<?php if ( $row[0]['vat3'] != 0) { ?>
    <div class="row">
        <div class="col"><span>Charge Card 3%:</span></div>
        <div class="col" id="col"><span><?= number_format($row[0]['sub_vat'], 2) ?></span> </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col"><span>Total Amount : </span></div>
    <div class="col" id="col"><span><?= number_format($row[0]['sumtotal'], 2) ?></span></div>
</div>


<hr>

<!-- Cshier -->
<div class="row">
    <div class="col"><span>Cshier : <?= $row[0]['emp']  ?></span></div>
</div>
<hr>