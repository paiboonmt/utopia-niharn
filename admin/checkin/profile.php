<?php
$sql_data = $conndb->query(" SELECT m.id , m.m_card , m.fname , m.product_name , t.date ,m.image , 
    t.time , m.sta_date , m.exp_date , m.comment , t.time_id , g.value 
    FROM tb_time AS t
    LEFT JOIN customer AS m ON t.ref_m_card = m.m_card
    LEFT JOIN group_type AS g ON m.m_card = g.number
    WHERE date(t.time) = CURDATE() 
    ORDER BY t.time_id 
    DESC 
    LIMIT 1");

$sql_data->execute();
$result = $sql_data->fetchAll();

$exp_date = $result[0]['exp_date'];
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

<?php if ($result[0]['value'] == 1) { ?>

    <div class="card mt-3">
        <img src="<?= '../memberimg/img/' . $result[0]['image'] ?>" width="70%" class="mt-3 img ">

        <div class="input-group py-2 mx-auto col-12">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">ชื่อลูกค้า</span>
            </div>
            <input type="text" class="form-control" value="<?= $result[0]['fname'] ?>">
        </div>
        <div class="input-group mx-auto col-12">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">ชื่อสินค้า</span>
            </div>
            <input type="text" class="form-control" value="<?= $result[0]['product_name'] ?>">
        </div>

        <div class="input-group py-2 mx-auto col-12">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">วันเริ่มใช้งาน</span>
            </div>
            <input type="text" class="form-control" value="<?= date('d/m/y', strtotime($result[0]['sta_date'])) ?>">
        </div>

        <div class="input-group mx-auto col-12">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">วันหมดอายุการใช้งาน</span>
            </div>
            <input type="text" class="form-control" value="<?= date('d/m/y', strtotime($result[0]['exp_date'])) ?>">
        </div>

        <div class="input-group py-2 mx-auto col-12">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">จำนวนวันใช้งาน</span>
            </div>
            <?php
            if ($df < 3) { ?>
                <input type="text" class="form-control bg-danger " value="<?= $df . ' ' . ' Day ' ?>">
            <?php } else { ?>
                <input type="text" class="form-control bg-success" value="<?= $df . ' ' . ' Day ' ?>">
            <?php } ?>
        </div>


        <div class="form-group col-12 mx-auto">
            <textarea class="form-control" name="textarea" rows="3"><?= $result[0]['comment'] ?></textarea>
        </div>

    </div>









<?php } elseif ($result[0]['value'] == 2) { ?>

    <img src="<?= '../memberimg/img/' . $result[0]['image'] ?>" width="50%" class="mt-3 img">
    <!-- package -->
    <div class="input-group mb-1 mt-3 col-9 mx-auto">
        <span class="input-group-text mr-1 bg-info" style=" text-transform: uppercase;font-weight:600;">Package name</span>
        <input type="text" class="form-control" value="<?= $result[0]['product_name'] ?>">
    </div>
    <!-- sta_date -->
    <div class="input-group mb-1 col-9 mx-auto">
        <span class="input-group-text mr-1 bg-info" style=" text-transform: uppercase;font-weight:600;">Start Train</span>
        <input type="text" class="form-control" value="<?= $result[0]['sta_date'] ?>">
    </div>
    <!-- exp_date -->
    <div class="input-group mb-1 col-9 mx-auto">
        <span class="input-group-text mr-1 bg-info" style=" text-transform: uppercase;">expiry Train</span>
        <input type="text" class="form-control" value="<?= $result[0]['exp_date'] ?>">
    </div>
    <!-- dropin -->
    <?php if ($result[0]['package'] == "10 Drop In" || $result[0]['package'] == "10 Drop in" || $result[0]['package'] == "147") { ?>
        <div class="input-group mb-1 col-9 mx-auto">
            <span class="input-group-text mr-1 bg-info" style=" text-transform: uppercase;">drop in</span>
            <?php if ($result[0]['dropin'] == 0) { ?>
                <input type="text" class="form-control bg-danger" value=" 0 ">
            <?php } else { ?>
                <input type="text" class="form-control" value="<?= $result[0]['dropin'] ?>">
            <?php } ?>
        </div>
    <?php } ?>
    <!-- Will Expire -->
    <div class="input-group mb-1 col-9 mx-auto">
        <span class="input-group-text bg-success" style=" text-transform: uppercase;">Will Expire</span>
        <?php
        if ($df < 3) { ?>
            <input type="text" class="form-control bg-danger " value="<?= $df . ' ' . ' Day ' ?>">
        <?php } else { ?>
            <input type="text" class="form-control" value="<?= $df . ' ' . ' Day ' ?>">
        <?php } ?>
    </div>
    <!-- comment -->
    <div class="form-group col-9 mx-auto">
        <textarea class="form-control" name="textarea" rows="3"><?= $result[0]['comment'] ?></textarea>
    </div>
<?php } else  ?>

<?php $conndb = null; ?>