
<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th >No</th>
            <th >CardID</th>
            <th >Full Name</th>
            <th >Package</th>
            <th >Date / time</th>
            <th >view</th>
            <th >Expire Day</th>
            <th >Group</th>
            <th >Action</th>
        </tr>
    </thead>
        <tbody>
            <?php
                require_once '../includes/connection.php';
                $sql_data = $conndb->query("SELECT m.id , m.m_card , m.fname,m.image , m.package ,
                m.type_training,t.date ,t.time,t.time_id,m.vaccine,m.group,m.sponsored,m.department,
                m.exp_date,m.image,m.type_fighter
                FROM tb_time AS t   
                INNER JOIN member AS m ON t.ref_m_card = m.m_card
                WHERE date(t.time) = CURDATE() 
                ORDER BY t.time DESC LIMIT 15");
                $sql_data->execute();
                $count = 1;
            
                foreach($sql_data as $row ) : ?>

                <tr>
                    <!-- No -->
                    <td >  <?php echo $count++; ?> </td>
                    <!-- CardID -->
                    <td >  <?php echo $row['m_card']; ?> </td>
                    <!-- Full Name -->
                    <td >  <?php echo $row['fname']; ?> </td>
                   <!-- Package -->
                    <?php if($row['group']=='employee'){?>
                        <?php if ($_SESSION['username']=='admin') { ?>
                            <td  style="color: gray;"> EMPLOYEE	</td>
                        <?php } ?>
                        <?php } if($row['group']=='customer'){?>
                            <td  style="color: green;"><?php echo $row['package']; ?> </td>
                        <?php } if($row['group']=='fighter'){?>
                            <td  style="color: red;font-weight: 600;"> <?= $row['type_fighter'].' / '.$row['type_training'] ?> </td>
                    <?php } ?>
                    <!-- Date / time -->
                    <td ><?php echo date('H:i:s',strtotime($row['date'])); ?> </td>
                    <!-- view -->
                    <?php if($row['group']=='employee'){?>
                        <?php if ($_SESSION['username']=='admin') { ?>
                            <td><a href="emp_profile.php?id=<?= $row['id'] ?>" target="_blank" class="btn  btn-sm" id="emp" > view </a></td>
                        <?php } ?>
                    <?php } if($row['group']=='customer'){?>
                        <td><a href="member_profile.php?id=<?= $row['id'] ?>" target="_blank" class="btn  btn-sm" id="customer"> view </a></td>
                    <?php } if($row['group']=='fighter'){?>
                        <td><a href="fighter_profile.php?id=<?= $row['id'] ?>" target="_blank" class="btn  btn-sm" id="fighter"> view </a></td>
                    <?php } ?>
                    <!-- EXPIRE DAY -->
                    <td >
                        <?php 
                        $today = date('Y-m-d');
                        if ($row['exp_date'] > $today ) { ?>
                            <button class="btn btn-success btn-sm " id="exp" ><?php echo date('d/m/Y',strtotime($row['exp_date'])) ?></button>
                        <?php } elseif( $row['exp_date'] == $today ) {?>
                            <button class="btn btn-warning btn-sm" id="exp" onclick="exp1()" ><?php echo date('d/m/Y',strtotime($row['exp_date'])) ?></button>
                        <?php }else {?>
                            <button class="btn btn-danger btn-sm" id="exp" onclick="exp2()">Expired <i class="fab fa-expeditedssl"></i> </button>
                        <?php } ?>
                    </td> 
                    <!-- GROUP -->
                    <?php if($row['group']=='employee'){?>

                        <?php if ($row['fname']!='admin'){?>

                            <td  style="color: orange;"><?php echo strtoupper($row['group']); ?></td>

                        <?php } else {?>

                            <td  style="color: goldenrod;">Admin</td>

                        <?php }?>

                    <?php } if($row['group']=='customer'){?>

                        <td  style="color: green;">  <?php echo strtoupper($row['group']); ?> </td>

                    <?php } if($row['group']=='fighter'){?>

                        <td  style="color: red;">  <?php echo  strtoupper($row['group']); ?> </td>

                    <?php } ?>
  
                        <td> 
                            <button class="btn btn-danger btn-sm delete_btn" id="<?= $row['time_id'];?>"><i class="fas fa-trash-alt"></i></button>
                        </td>

                </tr>
            <?php endforeach;?> 
        </tbody>
</table>
