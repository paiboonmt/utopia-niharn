<?php
$sql_data = $conndb->query("SELECT * FROM checkin
    WHERE DATE(checkin_date) = CURDATE()
    ORDER BY checkin_time DESC 
    LIMIT 1");

$sql_data->execute();
$result = $sql_data->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="card mt-3">

    <img src="../../dist/img/logo.png" width="70%" class="mt-3 img ">

    <div class="input-group py-2 mx-auto col-12">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">ชื่อลูกค้า</span>
        </div>
        <input type="text" class="form-control" value="<?= $result[0]['checkin_customer_name'] ?>">
    </div>

    <div class="input-group mx-auto col-12">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">ชื่อสินค้า</span>
        </div>
        <input type="text" class="form-control" value="<?= $result[0]['checkin_product'] ?>">
    </div>

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

</div>
<?php $conndb = null; ?>