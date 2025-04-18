<?php
session_start();
include("../middleware.php");
date_default_timezone_set('Asia/Bangkok');
require_once("../../includes/connection.php");

if (isset($_POST['ref_m_card'])) {
    $m_card = $_POST['ref_m_card'];

    echo $m_card;
    echo '<br>';
    echo checkNumber($conndb, $m_card);
    echo '<br>';
    echo exp_date($conndb, $m_card);
    echo '<br>';
    echo checkProductType($conndb, $m_card);
    echo '<br>';
    // exit;

    // 1 = ประเภทไม่นับจำนวนครั้ง
    // 2 = ประเภทนับจำนวนครั้ง

    if (checkNumber($conndb, $m_card) == 1) {                           // Member
        if (exp_date($conndb, $m_card) >= 0) {                          // เช็ควันหมดอายุ
            if (checkProductType($conndb , $m_card) == 1) {             // ประเภทไม่นับจำนวนครั้ง
                if (checkProductValue($conndb, $m_card) <= 0) {         // เช็คจำนวนครั้ง         
                    // checkInMember($conndb, $m_card);
                    // $_SESSION['expiry'] = true; 
                    // header('location:../checkin.php'); 
                    // $conndb = null;
                    echo 'อยู่ที่นี่';
                } else {
                    // checkInMember($conndb, $m_card);
                    // $_SESSION['checkin_success'] = true;
                    // header('location:../checkin.php'); 
                    // $conndb = null;
                    echo 'อยู่ที่นี่';
                }
            } else if (checkProductType($conndb , $m_card) == 2) {          // ประเภทนับจำนวนครั้ง
                if (checkProductValue($conndb, $m_card) <= 0) {             // เช็คจำนวนครั้ง 
                    checkInMember($conndb, $m_card);                        // เช็คจำนวนครั้ง
                    $_SESSION['expiry'] = true; 
                    header('location:../checkin.php'); 
                    $conndb = null;
                } else {
                    checkInMember($conndb, $m_card);
                    $_SESSION['checkin_success'] = true;
                    header('location:../checkin.php'); 
                    $conndb = null;
                }
            } else if (checkProductType($conndb , $m_card) == 3) {
                
            } else {
                echo 'ไม่พบข้อมูล';
            }

        } else {
            $_SESSION['expiry'] = true;
            header('location:../checkin.php');
            $conndb = null;
        }
    }
}

// เช็ค product_value เหลือกี่ครั้ง
function checkProductValue($conndb, $m_card)
{
    $sql = "SELECT `product_value` FROM `customer` WHERE `m_card` = :m_card";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':m_card', $m_card);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        return $result['product_value']; // Return the product value
    } else {
        return null; // Card not found
    }
}
// เช็คหมายเลขบัตร
function checkNumber($conndb, $m_card)
{
    $m_card = $_POST['ref_m_card'];
    $sql = "SELECT * FROM `group_type` WHERE `number` = ? ";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(1, $m_card);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result[0]['value'] == 1) {
        return $result[0]['value'];
        $conndb = null;
    } else {
        return $result[0]['value'];
        $conndb = null;
    }
}
// เช็ควันหมดอายุ
function exp_date($conndb, $m_card)
{
    $sql = "SELECT `exp_date` FROM `customer` WHERE `m_card` = :m_card";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':m_card', $m_card);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $exp_date = $result['exp_date'];
        $today = date('Y-m-d');
        $diff = (strtotime($exp_date) - strtotime($today)) / 86400; // Calculate difference in days
        return $diff >= 0 ? $diff : -1; // Return days remaining or -1 if expired
    } else {
        return -1; // Card not found
    }
}
// เช็คสินค้า  
function checkProductType($conndb, $m_card)
{
    $sql = "SELECT `product_type` FROM `customer` WHERE `m_card` = :m_card";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':m_card', $m_card);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        return $result['product_type']; // Return the package name
    } else {
        return $result['product_type']; // Card not found
    }
}

// Debug
function view()
{
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    exit;
}
// ! Member 
function checkInMember($conndb ,$m_card) {
    
    $sql_data = $conndb->prepare(" SELECT * FROM `customer` WHERE `m_card` = :m_card ");
    $sql_data->bindParam(":m_card",$m_card);
    $sql_data->execute();

    if ($sql_data->rowCount() == 1 ) {

        $result_data    = $sql_data->fetchAll();
        $id             = $result_data[0]['id'];
        $exp_date       = $result_data[0]['exp_date'];
        $package        = $result_data[0]['package'];

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
            header('location:checkin.php');
            $conndb = null;
        }
        // อัปเดท total หากค่าไม่เท่ากับ 0
        function updateTotal( $conndb , $quantity , $id_totel ){
            // $quantity + 2 ;
            $stmt = $conndb->prepare("UPDATE `totel` SET `quantity`= :qty WHERE `id` = :id ");
            $stmt->bindParam( "qty" , $quantity );
            $stmt->bindParam( "id" , $id_totel );
            $stmt->execute();
            header('location:checkin.php');
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

    } else {
        $_SESSION['not'] = true;
        header('location:checkin.php');
        $conndb = null; // สำหรับไม่เจอหมายเลขบัตร
    }
}

