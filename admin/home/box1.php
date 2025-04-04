<?php
    include '../includes/connection.php';
    $stmt = $conndb->query("SELECT * FROM `member` WHERE `group` = 'customer' AND `exp_date` >= curdate() AND `status` != '1'");
    $stmt->execute();
    $data = $stmt->rowCount();
?>
<div class="row">
    <div class="col">
        <div class="small-box bg-secondary">
            <div class="inner">
                <p style="font-size: 20px; text-transform: uppercase; text-align: center;">customers in Today</p>
                <div class="row">
                    <div class="col text-center">
                        <h5><?php echo $data;?></h5>
                    </div>
                </div>
            </div>
            <div class="icon">
                <i class="fas" style="cursor: pointer;"><a href="customerthismonth.php"><img src="../dist/img/box/box1/box1.png" width="60px" style="opacity: 0.50;"></a></i>
            </div>
        </div>
    </div>
</div>



