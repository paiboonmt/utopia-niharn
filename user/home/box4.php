<?php
    require_once '../includes/connection.php';
    $today = date('Y-m-d');
    $stmt = $conndb->query("SELECT * FROM `member` WHERE `group` = 'fighter' AND `exp_date`> '$today' ORDER BY `id` DESC");
    $stmt->execute();
    $count = $stmt->rowCount(); 
?>
<div class="row">
    <div class="col">
        <div class="small-box bg-danger">
            <div class="inner">
                <p style="font-size: 20px; text-transform: uppercase; text-align: center;" >SPONSOR FIGHTER</p>
                <div class="row">
                    <div class="col text-center">
                        <h5><?php echo $count; ?></h5>
                    </div>
                </div>
            </div>
            <div class="icon">
                <i class="fas"><img src="../dist/img/box/fighter/fighter1.png" width="60px" style="opacity: 0.50;"></i>
            </div>
        </div>
    </div>
</div>
