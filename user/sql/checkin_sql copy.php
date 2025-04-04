<?php

    session_start();

    require_once '../../includes/connection.php';

    if (isset($_POST['ref_m_card'])) {

        $ref_m_card = $_POST['ref_m_card'];
        $date = $_POST['date'];
        $count = $_POST['count'];

        $sql_data = $conndb->prepare(" SELECT * FROM `member` WHERE `m_card` = :ref ");
        $sql_data->bindParam(":ref",$ref_m_card);
        $sql_data->execute();
        $result_data = $sql_data->fetchAll();
        $id = $result_data[0]['id'];
        $exp_date = $result_data[0]['exp_date'];

      if ($rows = $sql_data->rowCount() > 0) {

          function datediff($str_start,$str_end){
            $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
            $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
            $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
            $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที
            return $ndays;
          }
          
          $today = date('Y-m-d');
          $df = datediff($today, $exp_date);
 
          if ($df > 1 ) {

            $sql_insert_time = $conndb->prepare("INSERT INTO `tb_time` (`ref_m_card`,`date`) VALUES (:ref,'$date')");
            $sql_insert_time->bindParam(":ref",$ref_m_card);
            $sql_insert_time->execute();

            // $dropin = [];

            header('location:../checkin.php');

          } elseif ( $df == 0 ){

            $sql_insert_time = $conndb->prepare("INSERT INTO `tb_time` (`ref_m_card`,`date`) VALUES (:ref,'$date')");
            $sql_insert_time->bindParam(":ref",$ref_m_card);
            $sql_insert_time->execute();

            $_SESSION['less'] = true;
            header('location:../checkin.php'); 

          } elseif($df < 0 ) {

            $sql_insert_time = $conndb->prepare("INSERT INTO `tb_time` (`ref_m_card`,`date`) VALUES (:ref,'$date')");
            $sql_insert_time->bindParam(":ref",$ref_m_card);
            $sql_insert_time->execute();

            $_SESSION['expiry'] = true;
            header('location:../checkin.php');

          }


        

      } else {
        $_SESSION['not'] = true;
        header('location:../checkin.php'); // สำหรับไม่เจอหมายเลขบัตร
      }
    }
  $conndb = null;  
?>


<!-- if ($sql_insert_time) {
    $sql_total = $conndb->query("SELECT * FROM `totel` WHERE date(date)=curdate()"); 
    $sql_total->execute();
    $result_total = $sql_total->fetchAll();
    $total_row = $sql_total->rowCount();

  if ( $total_row < 0  ) { 
      $cc = 1;
    try {
      $sql_total_insert = $conndb->prepare("INSERT INTO `totel`(`quantity`, `date`) VALUES (:cc,current_timestamp())");
      $sql_total_insert->bindParam(":cc",$cc);
      $sql_total_insert->execute();
      header('location:../checkin.php');
    }catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  
  } else{

    $id = $result_total[0]['id']; 
    $sql_total_update = $conndb->prepare("UPDATE `totel` SET `quantity`= '$count' WHERE id = $id ");
    $sql_total_update->execute();
    header('location:../checkin.php');
  }

} -->
