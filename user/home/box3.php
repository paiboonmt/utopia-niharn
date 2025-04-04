<?php
    require_once '../includes/connection.php';
    $stmt = $conndb->query("SELECT * FROM `member` WHERE `group` = 'customer' AND date(date)=curdate() AND `status` != '1' ");
    $stmt->execute();
    $rowww = $stmt->rowCount();
?>
<div class="row">
    <div class="col">
        <div class="small-box bg-success">
            <div class="inner">
                <p style="font-size: 20px; text-transform: uppercase; text-align: center;">NEW CUSTOMER</p>
                <div class="row">
                    <div class="col text-center">
                        <h5><?php echo $rowww; ?></h5>
                    </div>
                </div>
                <!-- <?php echo $rowww; ?> <a href="#" class="btn btn-success" ><i class="fas"> <img src="../dist/img/box/member/member1.png"  width="35px"></i></a> -->
            </div>
            <div class="icon">
                <i class="fas"><img src="../dist/img/box/member/member2.png" width="60px" style="opacity: 0.50;"></i>
            </div>
        </div>
    </div>
</div>
