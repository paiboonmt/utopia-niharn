<?php
    $sql_data = $conndb->query(" SELECT m.id , m.m_card , m.fname , m.package ,m.nick_name, t.date ,m.image ,t.time ,m.sta_date ,m.exp_date ,
                                        t.time_id,m.group ,m.expired ,m.department ,m.type_training ,m.type_fighter ,m.sponsored ,m.status,
                                        m.emergency,m.occupation,m.dropin
                                FROM tb_time AS t
                                INNER JOIN member AS m ON t.ref_m_card = m.m_card
                                WHERE date(t.time) = CURDATE() ORDER BY t.time_id DESC LIMIT 1");

    $sql_data->execute();
    $result = $sql_data->fetchAll();
    
    $exp_date = $result[0]['exp_date'];
    function datediff($str_start,$str_end){
       $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
       $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
       $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
       $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที
       return $ndays;
    }

   $today = date('Y-m-d');
   $df = datediff($today, $exp_date);
?>
    <h2 style="font-weight: 700; margin-top: 15px; text-align: center; color:#000;"> <?php  echo strtoupper($result[0]['fname']); ?> </h2>
    
<?php if ($result[0]['group']=='customer') { ?>

    <img src=" <?php echo '../memberimg/img/'.$result[0]['image'] ?>" width="70%"  class="mt-3 img" >
    <!-- package -->
    <div class="input-group mb-1 mt-3 col-9 mx-auto">
        <span class="input-group-text mr-1 bg-info" style=" text-transform: uppercase;font-weight:600;">Package name</span>
        <input type="text" class="form-control" value="<?php echo $result[0]['package'] ?>" >
    </div>
    <!-- sta_date -->
    <div class="input-group mb-1 col-9 mx-auto">
        <span class="input-group-text mr-1 bg-info" style=" text-transform: uppercase;font-weight:600;">Start Train</span>
        <input type="text" class="form-control" value="<?php echo $result[0]['sta_date'] ?>" >
    </div>
    <!-- exp_date -->
    <div class="input-group mb-1 col-9 mx-auto">
        <span class="input-group-text mr-1 bg-info" style=" text-transform: uppercase;">expiry Train</span>
        <input type="text" class="form-control" value="<?php echo $result[0]['exp_date'] ?>" >
    </div>
    <!-- dropin -->
    <?php if ($result[0]['package'] == "10 Drop In" || $result[0]['package'] == "Drop In") { ?>
        <div class="input-group mb-1 col-9 mx-auto">
            <span class="input-group-text mr-1 bg-info" style=" text-transform: uppercase;">deopin</span>
            <?php if ($result[0]['dropin'] == 0) {?>
                <input type="text" class="form-control bg-danger" value=" 0 " > 
                    <?php } else { ?>
                <input type="text" class="form-control" value="<?php echo $result[0]['dropin'] ?>" > 
            <?php } ?>
        </div>
    <?php } ?>


    <div class="input-group mb-1 col-9 mx-auto">
        <span class="input-group-text bg-success" style=" text-transform: uppercase;">Will Expire</span>
        <?php 
            if($df < 3) { ?>
                <input type="text" class="form-control bg-danger "  value="<?php echo $df . ' ' . ' Day ' ?>"  >
        <?php } else { ?>
                <input type="text" class="form-control"  value="<?php echo $df . ' ' . ' Day ' ?>"  >
        <?php } ?>
    </div>

<?php } elseif ($result[0]['group']=='fighter') { ?>
        
    <img src=" <?php echo '../fighterimg/img/'.$result[0]['image'] ?>" width="70%" class="img">

    <div class="input-group mb-1 col-9 mx-auto mt-3">
        <span class="input-group-text mr-1 bg-primary" style=" text-transform: uppercase;font-weight:600;">TYPE TRAINING</span>
        <input type="text" class="form-control " value="<?php echo $result[0]['type_training'] ?>" >
    </div>

    <div class="input-group mb-1 col-9 mx-auto">
        <span class="input-group-text mr-1 bg-primary" style=" text-transform: uppercase;font-weight:600;">TYPE FIGHTER</span>
        <input type="text" class="form-control " value="<?php echo $result[0]['type_fighter'] ?>" >
    </div>
    <div class="input-group mb-1 col-9 mx-auto">
        <span class="input-group-text mr-1 bg-primary" style=" text-transform: uppercase;font-weight:600;">TYPE sponsored</span>
        <input type="text" class="form-control " value="<?php echo $result[0]['sponsored'] ?>" >
    </div>
    <div class="input-group mb-1 col-9 mx-auto">
        <span class="input-group-text mr-1 bg-primary" style=" text-transform: uppercase;font-weight:600;">emergency contact</span>
        <input type="text" class="form-control " value="<?php echo $result[0]['emergency'] ?>" >
    </div>

    <div class="input-group mb-1 col-9 mx-auto">
        <span class="input-group-text bg-success" style=" text-transform: uppercase;font-weight:600;">Will Expire</span>
        <?php 
            if($df < 3) { ?>
                <input type="text" class="form-control bg-danger "  value="<?php echo $df . ' ' . ' Day ' ?>"  >
        <?php } else { ?>
                <input type="text" class="form-control bg-success"  value="<?php echo $df . ' ' . ' Day ' ?>"  >
        <?php } ?>
    </div>  

<?php } elseif ($result[0]['group']=='employee') { ?>

    <img src=" <?php echo '../empimg/img/'.$result[0]['image'] ?>" width="70%"  class="mt-3 img" >
    
    <div class="input-group mb-1 mt-3 col-9 mx-auto">
        <span class="input-group-text mr-1 bg-info" style=" text-transform: uppercase;font-weight:600;">department</span>
        <input type="text" class="form-control" value="<?php echo $result[0]['department'] ?>" >
    </div>
    <div class="input-group mb-1 col-9 mx-auto">
        <span class="input-group-text mr-1 bg-info" style=" text-transform: uppercase;font-weight:600;">nick name</span>
        <input type="text" class="form-control" value="<?php echo $result[0]['nick_name'] ?>" >
    </div>
    <div class="input-group mb-1 col-9 mx-auto">
        <span class="input-group-text mr-1 bg-info" style=" text-transform: uppercase;font-weight:600;">position</span>
        <input type="text" class="form-control" value="<?php echo $result[0]['occupation'] ?>" >
    </div>

<?php } $conndb = null; ?>

  