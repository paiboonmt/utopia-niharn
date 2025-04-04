
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

<div class="row">
    <div class="col"><span>Discount <?= $_SESSION['discount'] ?> %: </span></div>
    <div class="col" id="col"> <span><?= number_format($discount,2) ?> THB</span> </div>
</div>

<div class="row">
    <div class="col"><span>Total :</span></div>
    <div class="col" id="col"> <span><?= number_format( 00 ,2) ?> THB</span> </div>
</div>

<div class="row">
    <div class="col"><span>Vat 7% :</span></div>
    <div class="col" id="col"><span><?= number_format(00,2) ?> THB</span></div>
</div>

<div class="row">
    <div class="col"><span>Charge 3% :</span></div>
    <div class="col" id="col"><span><?= number_format(00 ,2)?> THB</span> </div>
</div>

<div class="row">
    <div class="col"><span>Grand Total</span></div>
    <div class="col" id="col"><span><?= number_format(00,2) ?> THB</span> </div>
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

<div class="row">
    <div class="col"><span><?= $_SESSION['comment'] ?></span></div>
</div>
<hr>

<div class="row mb-5">
    <div class="col"><span>Sale : <?= $_SESSION['username'] ?></span></div>
</div>
<hr>

<div class="foot" >
    Tiger Muay Thai & MMA Training Camp
</div>