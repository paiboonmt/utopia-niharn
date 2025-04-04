<?php

    require '../includes/connection.php';
    $sql_data = $conndb->query("SELECT m.id , m.m_card , m.fname , m.package ,m.nick_name, t.date ,m.image,t.time,m.sta_date,m.exp_date,t.time_id,
        m.group,m.expired,m.department,m.type_training,m.type_fighter,m.sponsored,m.status
        FROM tb_time AS t
        INNER JOIN member AS m ON t.ref_m_card = m.m_card
        WHERE date(t.time) = CURDATE() ORDER BY t.time_id DESC LIMIT 1");
    $sql_data->execute();
    $result = $sql_data->fetchAll();

    $sql_date = $conndb->query("SELECT m.sta_date,m.exp_date,t.time_id
        FROM member  AS m
        INNER JOIN tb_time AS t ON  m.m_card = t.ref_m_card
        ORDER BY t.time_id DESC LIMIT 1");
    $sql_date->execute();
    $date_row = $sql_date->fetchAll();
    
    $exp_date = $date_row[0]['exp_date'];
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
    <h4 style="font-weight: 700; margin-top: 15px; text-align: center;"> <?php  echo strtoupper($result[0]['fname']); ?> </h4>
    
<?php if ($result[0]['group']=='customer') { ?>

        <img src=" <?php echo '../memberimg/img/'.$result[0]['image'] ?>" width="100%" height="550px" >
    
        <div class="input-group mb-1 mt-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Package name</span>
            <input type="text" class="form-control" value="<?php echo $result[0]['package'] ?>" >
        </div>
       
        <div class="input-group mb-1">
            <span class="input-group-text" id="inputGroup-sizing-default">Amount</span>
            <?php 
            if($df < 3){ ?>
                <input type="text" class="form-control bg-danger "  value="<?php echo $df . ' ' . ' Day ' ?>"  >
            <?php $_SESSION['danger_day']= 'error';?>
            <?php } else{ ?>
                <input type="text" class="form-control bg-success "  value="<?php echo $df . ' ' . ' Day ' ?>"  >
            <?php }?>
        </div>  
            
<?php } elseif ($result[0]['group']=='fighter') { ?>
        
            <img src=" <?php echo '../fighterimg/img/'.$result[0]['image'] ?>" width="100%" height="550px">
            <hr>
            <div class="input-group mb-1">
                <span class="input-group-text" id="inputGroup-sizing-default">TYPE TRAINING</span>
                <input type="text" class="form-control " value="<?php echo $result[0]['type_training'] ?>" >
            </div>
            <div class="input-group mb-1">
                <span class="input-group-text" id="inputGroup-sizing-default">TYPE FIGHTER</span>
                <input type="text" class="form-control " value="<?php echo $result[0]['type_fighter'] ?>" >
            </div>

            <div class="input-group mb-1">
                <span class="input-group-text" id="inputGroup-sizing-default">Will Expire</span>
                <?php 
                    if($df < 3) { ?>
                        <input type="text" class="form-control bg-danger "  value="<?php echo $df . ' ' . ' Day ' ?>"  >
                 <?php }  else { ?>
                        <input type="text" class="form-control bg-success"  value="<?php echo $df . ' ' . ' Day ' ?>"  >
                     <?php } ?>
            </div>  

<?php } $conndb = null; ?>

  