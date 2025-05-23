<hr>
<div class="row">
    <h5>Rattachai Academy Gym</h5>
    <h5>TAX : 0835561020601 ( VAT Included )</h5>
    <h5>ใบเสร็จรับเงิน/ใบกำกับภาษีอย่างย่อ</h5>
</div>
<hr>

<div class="row">
    <div class="col"><span>Tax inv. No</span></div>
    <div class="col" id="col"><span><?= $_SESSION['num_bill'] ?></span></div>
</div>

<div class="row">
    <div class="col"><span>Tax inv. Date</span></div>
    <div class="col" id="col"><span><?= date('d-m-Y | H:i:s') ?></span></div>
</div>

<hr>
<?php foreach ($stmts as $rows) : ?>

    <div class="row">
        <div class="col col-12"><span><?= $rows['name'] ?> | price : <?= number_format($rows['price']) ?></span></div>
        <div class="col"><span> Qty :<?= $rows['quantity'] ?></span> </div>
        <div class="col" id="col"><span><?= number_format($rows['price'] * $rows['quantity'], 2) ?></span> </div>
    </div>

    <?php $grantotal += $_SESSION['cart'][$rows['id']] * $rows['price'] ?>

<?php endforeach; ?>

<hr>

<div class="row">
    <div class="col"><span>Total Bath : </span></div>
    <div class="col" id="col"><span><?= number_format($grantotal, 2) ?></span></div>
</div>

<!-- Discount -->
<?php if ($_SESSION['sub_discount'] != 0) : ?>
    <div class="row">
        <div class="col"><span>Discount : <?= $_SESSION['discount'] ?> %</span></div>
        <div class="col" id="col"><span><?= number_format($_SESSION['sub_discount'], 2) ?> </span></div>
    </div>
    <div class="row">
        <div class="col"><span>Discounted price : </span></div>
        <div class="col" id="col"><span><?= number_format($_SESSION['grandTotal'], 2) ?> </span></div>
    </div>
<?php endif; ?>

<hr>



<div class="row">
    <div class="col"><span>Payment :</span></div>
    <div class="col" id="col"><span><?= $_SESSION['pay'] ?></span> </div>
</div>


<!-- // VAT 3% -->
<?php if ($_SESSION['vat3'] != 0) { ?>
    <div class="row">
        <div class="col"><span>Charge Card 3%:</span></div>
        <div class="col" id="col"><span><?= number_format($_SESSION['sub_vat'], 2) ?></span> </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col"><span>Total Amount : </span></div>
    <div class="col" id="col"><span><?= number_format($_SESSION['sumTotal'], 2) ?></span></div>
</div>


<hr>

<!-- Cshier -->
<div class="row">
    <div class="col"><span>Cshier : <?= $_SESSION['AddBy']  ?></span></div>
</div>
<hr>