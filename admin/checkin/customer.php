<?php
$sql_data = $conndb->query("SELECT * 
FROM checkin
INNER JOIN customer ON checkin.checkin_card_number = customer.m_card
WHERE DATE(checkin_date) = CURDATE()
ORDER BY checkin_time DESC 
LIMIT 1");

$sql_data->execute();
$result = $sql_data->fetchAll(PDO::FETCH_ASSOC);

$exp_date = $result[0]['checkin_expriy'];

function datediff($str_start, $str_end)
{
    $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
    $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
    $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
    $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที
    return $ndays;
}

$today = date('Y-m-d');
$df = datediff($today, $exp_date);
?>


<div class="card mt-3">
    <!-- ภาพ -->
    <img src="<?= '../memberimg/img/' . $result[0]['image'] ?>" width="70%" class="mt-3 img">

    <!-- ชื่อลูกค้า -->
    <div class="input-group py-2 mx-auto col-12">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">ชื่อลูกค้า</span>
        </div>
        <input type="text" class="form-control" value="<?= $result[0]['checkin_customer_name'] ?>">
    </div>

    <!-- ชื่อสินค้า -->
    <div class="input-group mx-auto col-12">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">ชื่อสินค้า</span>
        </div>
        <input type="text" class="form-control" value="<?= $result[0]['checkin_product'] ?>">
    </div>

    <!-- วันหมดอายุการใช้งาน -->
    <div class="input-group py-2 mx-auto col-12">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">วันหมดอายุการใช้งาน</span>
        </div>

        <?php
        if ($result[0]['checkin_expriy'] < date('Y-m-d')) {
        ?>
            <input type="text" class="form-control bg-danger" value="<?= date('d/m/y', strtotime($result[0]['checkin_expriy'])) ?>">
        <?php
        } else {
        ?>
            <input type="text" class="form-control bg-success" value="<?= date('d/m/y', strtotime($result[0]['checkin_expriy'])) ?>">
        <?php
        }
        ?>
    </div>

    <!-- จำนวนครั้ง -->
    <div class="input-group mx-auto col-12">

        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">จำนวนครั้ง</span>
        </div>

        <?php
        if ( $result[0]['product_value'] <= 0 ) {
        ?>
            <input type="text" class="form-control bg-danger" value="<?= $result[0]['product_value'] ?>">
        <?php
        } else {
        ?>
            <input type="text" class="form-control bg-success" value="<?= $result[0]['product_value'] ?>">
        <?php
        }
        ?>
    </div>

    <!-- comment -->
    <div class="input-group py-2  col-12 mx-auto">
        <textarea class="form-control" rows="3" ><?= $result[0]['comment'] ?></textarea>
    </div>
    
    <!-- Will Expire -->
    <div class="input-group col-12 mx-auto">
    <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">จำนวนครั้ง</span>
        </div>
        <?php
        if ($df < 3) { ?>
            <input type="text" class="form-control bg-danger " value="<?= $df . ' ' . ' Day ' ?>">
        <?php } else { ?>
            <input type="text" class="form-control bg-success" value="<?= $df . ' ' . ' Day ' ?>">
        <?php } ?>
    </div>
    <!-- comment -->
</div>


<?php $conndb = null; ?>