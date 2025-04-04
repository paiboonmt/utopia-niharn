<?php
    session_start();
    include("../middleware.php");
    date_default_timezone_set('Asia/Bangkok');

    if ( isset($_GET['id']) ) 
    {
        require_once("../../includes/connection.php");
        $m_card = $_GET['id'];
        $date = date('Y/m/d H:i:s');

        $sql_data = $conndb->prepare(" SELECT * FROM `member` WHERE `m_card` = :m_card ");
        $sql_data->bindParam(":m_card",$m_card);
        $sql_data->execute();

        if ($sql_data->rowCount() == 1 ) {

            $result_data = $sql_data->fetchAll();
            $id = $result_data[0]['id'];
            $exp_date = $result_data[0]['exp_date'];
            $package = $result_data[0]['package'];

            $sql_total = $conndb->query("SELECT * FROM `totel` WHERE date(date) = curdate()");
            $sql_total->execute();
            $result_total = $sql_total->fetchAll();
            $total_row = $sql_total->rowCount();
            $id_totel = $result_total[0]['id'];
            // $quantity = $total_row + 1 ;

            // นับจำนวน total
            function countTotal($conndb) {
                $data = null;
                $stmt = $conndb->query("SELECT id FROM totel WHERE date(date) = CURDATE()");
                $stmt->execute();
                $data = $stmt->rowCount();
                return $data;
                $conndb =  null;
            }
            // นับจำนวน checkin
            function countCheckin($conndb){
                $data = null;
                $stmt = $conndb->query("SELECT `ref_m_card` FROM tb_time WHERE date(time)=curdate() GROUP by `ref_m_card` ");
                $stmt->execute();
                $data = $stmt->rowCount();
                return $data;
                $conndb =  null;
            }
            // เพื่มข้อมูล total หากค่าเท่ากับ 0 
            function insetTotal( $conndb ){
                $quantity = 1;
                $sql_total_insert = $conndb->prepare("INSERT INTO `totel`(`quantity`, `date`) VALUES ($quantity, current_timestamp() )");
                $sql_total_insert->execute();
                header('location:../checkin.php');
                $conndb = null;
            }
            // อัปเดท total หากค่าไม่เท่ากับ 0
            function updateTotal( $conndb , $quantity , $id_totel ){
                // $quantity + 2 ;
                $stmt = $conndb->prepare("UPDATE `totel` SET `quantity`= :qty WHERE `id` = :id ");
                $stmt->bindParam( "qty" , $quantity );
                $stmt->bindParam( "id" , $id_totel );
                $stmt->execute();
                header('location:../checkin.php');
                $conndb = null;
            }
            // เช็ควันหมดอายุ
            function datediff($str_start,$str_end){
                $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
                $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
                $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
                $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที
                return $ndays;
            }
            // เพื่มข้อมูล checkin
            function insertTime($conndb , $m_card) {
                $stmt = $conndb->prepare("INSERT INTO `tb_time` (`ref_m_card`,`date`) VALUES ( :m_card , current_timestamp())");
                $stmt->bindParam(':m_card',$m_card);
                $stmt->execute();
                $conndb = null;
            }
 
            $quantity = countCheckin($conndb); // แสดงจำนวนแถว

            // exit;
            $today = date('Y-m-d');
            $df = datediff($today, $exp_date);

            if ( $package == '10 Drop In') 
            {
                if( $result_data[0]['dropin'] >= 1 )
                {
                    $dropin = $result_data[0]['dropin'] - 1 ;
                    $update_dropin = $conndb->prepare("UPDATE `member` SET `dropin` = '$dropin' WHERE `member`.`id` = $id ");

                    if ( $update_dropin->execute() ) 
                    {
                        if ( countTotal( $conndb ) == 0 ) 
                        { 
                            insertTime( $conndb , $m_card );
                            insetTotal( $conndb );
                        } 
                        else 
                        {
                            $quantity + 2 ;
                            insertTime( $conndb , $m_card );
                            updateTotal( $conndb , $quantity , $id_totel );
                        }
                    }
                } 
                else 
                {
                    $_SESSION['dropin_ex'] = true;
                    $_SESSION['package'] = $package;
                    header('location:../checkin.php');
                    $conndb = null;
                }

            } 
            else 
            {
                if ($df >= 1 ) {
                    if ( countTotal( $conndb )  == 0 ) {
                        insertTime( $conndb , $m_card );
                        insetTotal( $conndb );
                    } else {
                        $quantity + 2 ;
                        insertTime( $conndb , $m_card );
                        updateTotal($conndb,$quantity,$id_totel);
                    }
                } else if ( $df == 0 ){
                    if (countTotal( $conndb )  == 0 ) {
                        insertTime( $conndb , $m_card );
                        insetTotal( $conndb );
                    } else {
                        $quantity + 2 ;
                        insertTime( $conndb , $m_card );
                        updateTotal($conndb,$quantity,$id_totel);
                    }
                } else {

                    if (countTotal( $conndb )  == 0 ) {
                        insertTime( $conndb , $m_card );
                        insetTotal( $conndb );
                    } else {
                        $quantity + 2 ;
                        insertTime( $conndb , $m_card );
                        updateTotal($conndb,$quantity,$id_totel);
                        $_SESSION['expiry'] = true;
                    }
                }
            }
    
        } else {
          $_SESSION['not'] = true;
          header('location:../checkin.php');
          $conndb = null; // สำหรับไม่เจอหมายเลขบัตร
        }
    }
?>
