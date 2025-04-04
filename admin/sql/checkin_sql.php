<?php
    session_start();
    
    require_once '../../includes/connection.php';
    $dateNow = date("Y/m/d");

    if (isset($_POST['ref_m_card'])) {

      //รับค่าเข้ามา เก็บใว้ในตัวแปร
        $ref_m_card = $_POST['ref_m_card'];
        $count = $_POST['count'];
        $date = $_POST['date'];

        $sql_data = $conndb->prepare(" SELECT * FROM `member` WHERE `m_card` = :ref ");
        $sql_data->bindParam(":ref",$ref_m_card);
        $sql_data->execute();
        $result_data = $sql_data->fetchAll();
        $id = $result_data[0]['id'];
        $exp_date = $result_data[0]['exp_date'];
        $package = $result_data[0]['package'];
 
        if ($rows = $sql_data->rowCount() > 0) {

            // start query table totel          
            $sql_total = $conndb->query("SELECT * FROM `totel` WHERE date(date) = curdate()");
            $sql_total->execute();
            $result_total = $sql_total->fetchAll();
            $total_row = $sql_total->rowCount();
            $id_totel = $result_total[0]['id'];
            $quantity = $count + 1 ;

          if ( $total_row < 1   ) { 
      
              $cc = 1;
            
              $sql_total_insert = $conndb->prepare("INSERT INTO `totel`(`quantity`, `date`) VALUES (:cc,'$date')");
              $sql_total_insert->bindParam(":cc",$cc);
              $sql_total_insert->execute();
      
      
            } else {

                $sql_total_update = $conndb->prepare("UPDATE `totel` SET `quantity`= '$quantity' WHERE id = $id_totel ");
                $sql_total_update->execute();
              
            }

          // end query table totel
          
          // เช็ค package dropin 
          if($result_data[0]['dropin'] > 0 ){

            $dropin = $result_data[0]['dropin'] - 1 ;
            $update_dropin = $conndb->prepare("UPDATE `member` SET `dropin` = '$dropin' WHERE `member`.`id` = $id ");
            $update_dropin->execute();

            } else {

              echo  $package;
              echo '<br>';

              $_SESSION['dropin_ex'] = true;
              $_SESSION['package'] = $package;
              
              echo "บัตรหมดอายุ";
              // exit();

            }
          
          function datediff($str_start,$str_end){
            $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
            $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
            $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
            $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที
            return $ndays;
          }
            
          $today = date('Y-m-d');
          $df = datediff($today, $exp_date);

          echo $df;
  
          if ($df >= 1 ) {

            $sql_insert_time = $conndb->prepare("INSERT INTO `tb_time` (`ref_m_card`,`date`) VALUES (:ref,'$date')");
            $sql_insert_time->bindParam(":ref",$ref_m_card);
            $sql_insert_time->execute();

            header('location:../checkin.php');

          } elseif ( $df == 0 ){

            $sql_insert_time = $conndb->prepare("INSERT INTO `tb_time` (`ref_m_card`,`date`) VALUES (:ref,'$date')");
            $sql_insert_time->bindParam(":ref",$ref_m_card);
            $sql_insert_time->execute();

            // $_SESSION['less'] = true;
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
