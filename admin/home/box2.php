<?php
    require_once '../includes/connection.php';
    $stmt = $conndb->prepare("SELECT `ref_m_card` FROM tb_time WHERE date(time) = curdate() GROUP by `ref_m_card` ");
    $stmt->execute();
    $count = $stmt->rowCount(); 
?> 
<div class="row">
  <div class="col">
    <div class="small-box bg-primary">
      <div class="inner">
        <p style="font-size: 20px; text-transform: uppercase; text-align: center;" >CKECK IN TO DAY</p>
        <div class="row">
          <div class="col text-center">
            <h5><?php echo $count; ?></h5>
          </div>
        </div>
      </div>
      <div class="icon">
        <i class="fas"><img src="../dist/img/box/checkin/checkin1.png" width="60px" style="opacity: 0.50;"></i>
      </div>
    </div>
  </div>
</div>
