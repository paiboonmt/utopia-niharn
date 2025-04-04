
<div class="row">
    <div class="col"><span>ID :</span></div>
    <div class="col" id="col"><span><?= $_SESSION['m_card'] ?></span></div>
</div>

<div class="row">
     <?php include './salePrintShowsubmenu.php' ?> 
</div>

<div class="row">
    <div class="col"><span>Package Price :</span></div>
    <div class="col" id="col"><span><?= number_format($_SESSION['price'],2) ?> THB</span></div>
</div>

<?php if ($_SESSION['discount'] != 0 ) { ?>
    <div class="row">
        <div class="col"><span>Discount <?= $_SESSION['discount'] ?> %: </span></div>
        <div class="col" id="col"> <span><?= number_format($discount,2) ?> THB</span> </div>
    </div>

    <div class="row">
        <div class="col"><span>Price - Discount :</span></div>
        <div class="col" id="col"> <span><?= number_format($_SESSION['price'] - $discount,2) ?> THB</span> </div>
    </div>
<?php } ?> 

<?php if ($vat7 != 0) {?> 
    <div class="row">
        <div class="col"><span>Vat 7% :</span></div>
        <div class="col" id="col"><span><?= number_format($vat7,2) ?> THB</span></div>
    </div>
<?php  } ?>

<?php if ($vat3 != 0) {?> 
    <div class="row">
        <div class="col"><span>Charge Card 3% :</span></div>
        <div class="col" id="col"><span><?= number_format($vat3 ,2)?> THB</span> </div>
    </div>   
<?php  } ?>

<div class="row">
    <div class="col"><span>Grand Total</span></div>
    <div class="col" id="col"><span><?= number_format($total,2) ?> THB</span> </div>
</div>

<div class="row">
    <div class="col"><span>Customer Name :</span></div>
    <div class="col" id="col"><span><?= $_SESSION['fname'] ?></span></div>
</div>

<div class="row">
    <div class="col"><span>Buy time :</span></div>
    <div class="col" id="col"><span><?= date('H:i:s , d/m/Y') ?></span></div>
</div>

<div class="row">
    <div class="col"><span>Start : <?= $_SESSION['sta_date'] ?></span></div>
    <div class="col" id="col" ><span>Expiry : <?= $_SESSION['exp_date'] ?></span></div>
</div>

<div class="row mt-2">
    <div class="col"><span><?= $_SESSION['comment'] ?></span></div>
</div>

<hr>

<div class="row mb-5">
    <div class="col"><span>Sale : <?= $_SESSION['AddBy']  ?></span></div>
</div>

<hr>

<div class="foot text-center">
    Tiger Muay Thai & MMA Training Camp
</div>