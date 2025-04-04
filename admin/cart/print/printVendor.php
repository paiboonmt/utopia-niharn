<p style="text-align: center; text-transform: uppercase; margin-top: 0px;">Vendor</p>
<hr>
<div class="row">
    <div class="col"><span>Tax inv. No</span></div>
    <div class="col" id="col"><span><?= $_SESSION['num_bill'] ?></span></div>
</div>

<div class="row">
    <div class="col"><span>Tax inv. Date</span></div>
    <div class="col" id="col"><span><?= date('d-m-Y | H:i:s' ) ?></span></div>
</div>

<div class="row">
    <div class="col"><span>QR Code</span></div>
    <div class="col" id="col"><span><?= $_SESSION['m_card'] ?></span></div>
</div>

<hr>
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

        require_once("../../../includes/connection.php");

        $lastId =  $_SESSION['order_id'];

        $stmts = $conndb->query("SELECT p.product_name , o.quantity ,p.price , p.id
        FROM `products` AS p
        LEFT JOIN order_details AS o ON  p.id = o.product_id 
        WHERE id IN ($Ids)
        AND order_id = $lastId
        ");
        $stmts->execute();
    foreach ( $stmts AS $rows ) : ?>
       
       <div class="row">
            <div class="col col-12"><span><?= $rows['product_name'] ?> </span></div>
            <div class="col"><span>Qty :<span><?= $rows['quantity'] ?></span> </div>
            <div class="col" id="col"><span><?= number_format($rows['price'] * $rows['quantity'] ,2)?></span> </div>
        </div>

        <?php $grantotal += $_SESSION['cart'][$rows['id']] * $rows['price'] ?>

    <?php endforeach; ?>
    
<hr>

<div class="row">
    <div class="col"><span>Total Bath : </span></div>
    <div class="col" id="col"><span><?= number_format($grantotal,2) ?></span></div>
</div> 


<!-- ถ้ามี Discount -->
<?php if ($_SESSION['discountOraginal'] != 0 ) { ?>
    <!-- แสดงส่วนลด -->
    <div class="row">
        <div class="col"><span>Discount :<?= $_SESSION['discountOraginal'] ?> %: </span></div>
        <div class="col" id="col"> <span><?= '-' . number_format( $_SESSION['discount'],2) ?></span> </div>
    </div>
    <!-- แสดงจำนวนส่วนลด -->
    <div class="row">
        <div class="col"><span>NET BATH : </span></div>
        <div class="col" id="col"><span><?= number_format( $grantotal - $_SESSION['discount'] , 2) ?></span></div>
    </div>

    <?php if ($_SESSION['vat7'] != 0) {?>
        <div class="row">
            <div class="col"><span>VAT 7.00% :</span></div>
            <div class="col" id="col"><span><?= number_format( $_SESSION['vat7'] , 2) ?></span></div>
        </div>
        <?php if ( $_SESSION['vat3'] != 0) {?>
            <div class="row">
                <div class="col"><span>Charge Card 3.00% :</span></div>
                <div class="col" id="col"><span><?= number_format( $_SESSION['vat3'] ,2)?></span>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <?php if ( $_SESSION['vat3'] != 0) {?>
            <div class="row">
                <div class="col"><span>Charge Card 3% :</span></div>
                <div class="col" id="col"><span><?= number_format( $_SESSION['vat3'] ,2)?></span> </div>
            </div>
        <?php } ?>
    <?php } ?>
    
<!-- ถ้าไม่มี Discount -->
<?php } else { ?>
    <?php if ( $_SESSION['vat7'] != 0) {?>
        <div class="row">
            <div class="col"><span>Vat 7.00%:</span></div>
            <div class="col" id="col"><span><?= number_format( $_SESSION['vat7'] , 2) ?></span></div>
        </div>
        <?php if ( $_SESSION['vat3'] != 0) {?>
            <div class="row">
                <div class="col"><span>Charge Card 3.00%:</span></div>
                <div class="col" id="col"><span><?= number_format( $_SESSION['vat3'] ,2)?></span> </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <?php if ($_SESSION['vat3'] != 0) {?>
            <div class="row">
                <div class="col"><span>Charge Card 3.00%:</span></div>
                <div class="col" id="col"><span><?= number_format( $_SESSION['vat3'] ,2)?></span> </div>
            </div>
        <?php } ?>
    <?php } ?>

<?php } ?>

<div class="row">
    <div class="col"><span>Total Amount : </span></div>
    <div class="col" id="col"><span><?= number_format( $_SESSION['grandTotal'] , 2) ?></span></div>
</div>

<div class="row">
    <div class="col"><span>Payment :</span></div>
    <div class="col" id="col"><span><?= $_SESSION['pay'] ?></span> </div>
</div>

<hr>

<div class="row">
    <div class="col"><span>Customer Name :</span></div>
    <div class="col" id="col"><span><?= $_SESSION['fname'] ?></span></div>
</div>
<!-- Time to buy -->
<div class="row">
    <div class="col"><span>Time to buy :</span></div>
    <div class="col" id="col"><span><?= date('H:i:s , d/m/Y') ?></span></div>
</div>
<!-- Start / End -->
<div class="row">
    <div class="col"><span>Start : <?= date('d-m-y', strtotime($_SESSION['sta_date'])) ?></span></div>
    <div class="col" id="col"><span>Expiry : <?= date('d-m-Y' , strtotime($_SESSION['exp_date'])) ?></span></div>
</div>
<!-- comment -->
<div class="row mt-2">
    <div class="col"><span><?= $_SESSION['comment'] ?></span></div>
</div>

<!-- Sale Employee -->
<div class="row">
    <div class="col"><span>Employee : <?= $_SESSION['AddBy']  ?></span></div>
</div>

<div class="foot text-center" style="font-size: 10px; margin-top: 150px;">
    <div class="row">
        <p>Thank You.</p>
        <hr>
    </div>
</div>
