<hr>
<div class="row">
    <h5>RATTACHAI MUAYTHAI GYM</h5>
    <h5 class="text-center">บริษัท ทีเอ็มที ภูเก็ด จำกัด</
</div>

<div class="row">
    <div class="col"><span>Tax inv. No</span></div>
    <div class="col" id="col"><span><?= $row[0]['num_bill'] ?></span></div>
</div>

<div class="row">
    <div class="col"><span>Tax inv. Date</span></div>
    <div class="col" id="col"><span><?= date('d-m-Y | H:i:s' ) ?></span></div>
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
    $sql1 = "SELECT * FROM `orders` as o
    LEFT JOIN `order_details` as  os
    ON o.id = os.order_id
    WHERE id = ? ";

    $stmt = $conndb->prepare($sql1);
    $stmt->bindParam(1 , $id , PDO::PARAM_INT);
    $stmt->execute();
    $check = $stmt->fetchAll();
    $checkCount = $stmt->rowCount();

    $idd = $check[0]['order_id'];
    $checkRow = "SELECT * FROM `order_details` WHERE order_id = '$idd'";
    $stmtCheckRow = $conndb->prepare($checkRow);
    $stmtCheckRow->execute();
    $rowCount = $stmtCheckRow->rowCount();
    foreach ( $check AS $rowq ) : ?>

    <div class="row">
        <div class="col col-12"><span><?= $rowq['product_name'] ?> </span></div>
        <div class="col"><span>Qty :<span><?= $rowq['quantity'] ?></span> </div>
        <div class="col" id="col"><span><?= number_format($rowq['price'] * $rowq['quantity'] ,2)?></span> </div>
    </div>

    <?php $total += $rowq['price'] * $rowq['quantity'] ?>
<?php endforeach; ?>

<hr>

<div class="row">
    <div class="col"><span>Total Bath : </span></div>
    <div class="col" id="col"><span><?= number_format($total,2) ?></span></div>
</div> 

<!-- มี discount -->
<?php if ( $row[0]['discount'] != 0 ) { ?>
    <div class="row">
        <div class="col"><span>Discount <?= $row[0]['discount'] ?> %: </span></div>
        <div class="col" id="col"> <span><?= number_format( $discount , 2 ) ?></span> </div>
    </div>
    <?php $total = $total - $discount  ?>
    <?php if ( $row[0]['vat7'] != 0 ) {?>

        <?php $vat7 = $total * 7 / 100  ?>

        <div class="row">
            <div class="col"><span>Vat 7% :</span></div>
            <div class="col" id="col"><span><?= number_format( $vat7 , 2) ?></span></div>
        </div>

        <?php $total = $total + $vat7 ?> 

        <?php if ( $row[0]['vat3'] != 0) {?>

            <?php $vat3 = $total * 3 / 100  ?>

            <div class="row">
                <div class="col"><span>Charge Card 3% :</span></div>
                <div class="col" id="col"><span><?= number_format( $vat3 ,2)?></span> </div>
            </div>

            <div class="row">
                <div class="col"><span>Grand Total : </span></div>
                <div class="col" id="col"><span><?= number_format( $total + $vat3  , 2) ?></span></div>
            </div>

        <?php } else {?>

            <div class="row">
                <div class="col"><span>Grand Total : </span></div>
                <div class="col" id="col"><span><?= number_format( $total , 2) ?></span></div>
            </div>

        <?php } ?> 
        
    <?php } else { ?>

        <?php if ( $row[0]['vat3'] != 0) {?>

            <?php $vat3 = $total * 3 / 100  ?>

            <div class="row">
                <div class="col"><span>Charge Card 3% :</span></div>
                <div class="col" id="col"><span><?= number_format( $vat3 ,2)?></span> </div>
            </div>

            <div class="row">
                <div class="col"><span>Grand Total : </span></div>
                <div class="col" id="col"><span><?= number_format( $total + $vat3 , 2) ?></span></div>
            </div>

        <?php } ?>

    <?php } ?>
<!-- ไม่มี discount  -->
<?php } else { ?>
    <?php if ( $row[0]['vat7'] != 0) {?>

        <div class="row">
            <div class="col"><span>Vat 7.00 % :</span></div>
            <div class="col" id="col"><span><?= number_format( $vat7, 2) ?></span></div>
        </div>

        <?php $total = $total + $vat7 ?>

        <?php if ( $row[0]['vat3'] != 0) {?>

            <?php $vat3 = $total * 3 /100  ?>

            <div class="row">
                <div class="col"><span>Charge Card 3%:</span></div>
                <div class="col" id="col"><span><?= number_format( $vat3 ,2)?></span> </div>
            </div>

            <?php $total = $total + $vat3 ?>

            <div class="row">
                <div class="col"><span>Total + Charge 3%:</span></div>
                <div class="col" id="col"><span><?= number_format( $total ,2)?></span> </div>
            </div>

        <?php } ?>

        <div class="row">
            <div class="col"><span>Total Amount: </span></div>
            <div class="col" id="col"><span><?= number_format( $total , 2) ?></span></div>
        </div>

    <?php } else { ?>

        <?php if ( $row[0]['vat3'] != 0) { ?>

            <div class="row">
                <div class="col"><span>Charge Card 3%:</span></div>
                <div class="col" id="col"><span><?= number_format( $vat3 ,2)?></span> </div>
            </div>
            <div class="row">
                <div class="col"><span>Total Amount  : </span></div>
                <div class="col" id="col"><span><?= number_format( $total + $vat3  , 2) ?></span></div>
            </div>

        <?php } ?>

    <?php } ?>

<?php } ?>

<div class="row">
    <div class="col"><span>Payment :</span></div>
    <div class="col" id="col"><span><?= $row[0]['pay'] ?></span></div>
</div>

<hr>

<!-- Customer Name  -->
<div class="row">
    <div class="col"><span>Customer Name :</span></div>
    <div class="col" id="col"><span><?= $row[0]['fname'] ?></span></div>
</div>

<!-- Start / End -->
<div class="row">
    <div class="col"><span>Start : <?= date('d/m/y', strtotime($row[0]['sta_date'])) ?></span></div>
    <div class="col" id="col"><span>Expiry : <?= date('d/m/Y' , strtotime($row[0]['exp_date'])) ?></span></div>
</div>
<!-- comment -->
<div class="row mt-2">
    <div class="col"><span><?= $row[0]['comment'] ?></span></div>
</div>

<!-- Sale Employee -->
<div class="row mt-2">
    <div class="col"><span>Cahier : <?= $row[0]['AddBy']  ?></span></div>
</div>

<div class="text-center mb-5">
    <img src="https://qrcode.tec-it.com/API/QRCode?data=<?= $row[0]['ref_order_id'] ?>%0a&backcolor=%23ffffff" class="imgqrcode">
</div>

<div class="foot" style="font-size: 12px; margin-bottom: 250px;" >
    <div class="row">
        <p style="font-size: 12px;"><?= $row[0]['detail'] ?></p>
     </div> 
</div>
<hr class="mt-3">