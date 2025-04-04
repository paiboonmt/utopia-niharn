<hr>
<div class="row">
    <h5>RATTACHAI MUAYTHAI GYM</h5>
    <h5 class="text-center">บริษัท ทีเอ็มที ภูเก็ด จำกัด</h5>
</div>
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
    <div class="col"><span>QR CODE :</span></div>
    <div class="col" id="col"><span><?= $_SESSION['m_card'] ?></span></div>
</div>

<hr>
    <?php foreach ( $stmts AS $rows ) : ?>
       
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
                <div class="col"><span>Charge Card 3%:</span></div>
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

<!-- Start / End -->
<div class="row">
    <div class="col"><span>Start : <?= date('d-m-y', strtotime($_SESSION['sta_date'])) ?></span></div>
    <div class="col" id="col"><span>Expiry : <?= date('d-m-Y' , strtotime($_SESSION['exp_date'])) ?></span></div>
</div>

<!-- comment -->
<div class="row mt-2">
    <div class="col"><span><?= $_SESSION['comment'] ?></span></div>
</div>

<!-- Cshier -->
<div class="row">
    <div class="col"><span>Cshier : <?= $_SESSION['AddBy']  ?></span></div>
</div>

<!-- qrcode -->
<?php
    // นำเข้าไลบรารี PHP QR Code
    include '../../../public/phpqrcode/qrlib.php';

    // ข้อความที่ต้องการแปลงเป็น QR Code
    $text = $_SESSION['m_card'] ;

    // ชื่อไฟล์ที่ต้องการบันทึก
    $file = 'qrcode.png';
 
    // สร้าง QR Code และบันทึกเป็นไฟล์ภาพ
    QRcode::png($text, $file);

    // แสดง QR Code บนหน้าเว็บ
    // echo '<img src="'.$file.'" />';
?>

<!-- qrcode -->
<div class="text-center mt-1 mb-2">
    <img src="<?= $file ?>" class="imgqrcode">
    <p style="font-size: 12px;">Thank you very much for choosing our service. <br> We hope you enjoy our classes.</p>
</div>

<div class="foot" style="font-size: 12px; margin-bottom: 250px;" >
</div>

<hr class="mt-3">