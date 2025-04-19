<?php
session_start();
include("../middleware.php");
date_default_timezone_set('Asia/Bangkok');
require_once("../../includes/connection.php");

if (isset($_POST['ref_m_card'])) {
    $m_card = $_POST['ref_m_card'];
    

    if (checkNumber($conndb, $m_card) == 1) {                               // Member
        if (exp_date($conndb, $m_card) >= 0) {      
            
            // 1 = ประเภทไม่นับจำนวนครั้ง
            if (checkProductType($conndb, $m_card) == 1) {                  // ประเภทไม่นับจำนวนครั้ง
                
                $new_value = checkProductValue($conndb, $m_card) - 1;       // ลดจำนวนครั้ง
               

                if ($new_value < 0) {                                       // เช็คจำนวนครั้ง
                    $_SESSION['product_expired'] = true;   
                    checkInMember($conndb, $m_card);                  // หมดอายุ
                    header('location:../checkin.php');                      // ส่งค่ากลับไปที่หน้า checkin
                    $conndb = null;                                         // ปิดการเชื่อมต่อฐานข้อมูล
                }

                updateProductValue($conndb, $m_card, $new_value);           // อัปเดทจำนวนครั้ง
                checkInMember($conndb, $m_card); 
                header('location:../checkin.php');                          // ส่งค่ากลับไปที่หน้า checkin
                $conndb = null;                                             // ปิดการเชื่อมต่อฐานข้อมูล

            // 2 = ประเภทนับจำนวนครั้ง   
            } else if (checkProductType($conndb, $m_card) == 2) {           // ประเภทนับจำนวนครั้ง
                if (checkProductValue($conndb, $m_card) <= 0) {             // เช็คจำนวนครั้ง

                    checkInMember($conndb, $m_card);                        // เช็คจำนวนครั้ง
                    $_SESSION['product_expired'] = true;                             
                    header('location:../checkin.php');                          
                    $conndb = null;   
                 
                } else {

                    $new_value = checkProductValue($conndb, $m_card) - 1;   // ลดจำนวนครั้ง
                    updateProductValue($conndb, $m_card, $new_value);       // อัปเดทจำนวนครั้ง

                    checkInMember($conndb, $m_card);
                 
                    $_SESSION['checkin_success'] = true;
                    header('location:../checkin.php');
                    $conndb = null;
                }
            } else {
                echo 'ไม่พบข้อมูล';
            }
        } else {

            if (checkProductValue($conndb, $m_card) <= 0) {             

                checkInMember($conndb, $m_card);                        
                $_SESSION['date_expiry'] = true;                           
                header('location:../checkin.php');                          
                $conndb = null;   
             
            } else {

                $new_value = checkProductValue($conndb, $m_card) - 1;   // ลดจำนวนครั้ง
                updateProductValue($conndb, $m_card, $new_value);       // อัปเดทจำนวนครั้ง
                checkInMember($conndb, $m_card);                        // เช็คจำนวนครั้ง
                $_SESSION['date_expiry'] = true;                        // เช็ควันหมดอายุ
                header('location:../checkin.php');                      // ส่งค่ากลับไปที่หน้า checkin
                $conndb = null;                                         // ปิดการเชื่อมต่อฐานข้อมูล

            }
        }
    } else {

        include './functions.php';

        echo 'Number : ' .$m_card;
        echo '<br>';
        echo ' Group : ' . checkNumber($conndb, $m_card);
        echo '<br>';
        echo 'Date : ' . customCheckDate($conndb, $m_card);
        echo '<br>';
        // exit;

        if ( customCheckDate( $conndb , $m_card ) <= 0) { 



            checkInMember( $conndb , $m_card );                     // เช็ควันหมดอายุ
            $_SESSION['expiry'] = true;                             // หมดอายุ
            header('location:../checkin.php');                      // ส่งค่ากลับไปที่หน้า checkin
            $conndb = null;                                         // ปิดการเชื่อมต่อฐานข้อมูล
        } else {
            checkInMember( $conndb , $m_card );                     // หมายเลขบัตรใช้งานไม่ได้
            header('location:../checkin.php');                      // ส่งค่ากลับไปที่หน้า checkin
            $conndb = null;                                         // ปิดการเชื่อมต่อฐานข้อมูล
        }

    }
}

// Checkin  
function checkInMember($conndb, $m_card)
{
    
    $sql_total = $conndb->query("SELECT id FROM totel WHERE date(date) = CURDATE()");
    $sql_total->execute();
    $result_total = $sql_total->fetchAll(PDO::FETCH_ASSOC);
    $total_row = $sql_total->rowCount();


    $quantity = $total_row + 1;

    // $quantity = countCheckin($conndb); // แสดงจำนวนแถว

    echo countTotal($conndb);
    echo '<br>';

    // exit;

    if (countTotal($conndb)  == 0) {
        insertTime($conndb, $m_card);
        insetTotal($conndb);
    } else {
        $quantity + 2;
        insertTime($conndb, $m_card);
        $id_totel = $result_total[0]['id'];

        // echo $id_totel;
        // echo '<br>';
        // exit;

        updateTotal($conndb, $quantity, $id_totel);
    }

}

// ****************************************************************************************************************

// นับจำนวน checkin
function countCheckin($conndb)
{
    $data = null;
    $stmt = $conndb->query("SELECT `ref_m_card` FROM tb_time WHERE date(time)=curdate() GROUP by `ref_m_card` ");
    $stmt->execute();
    $data = $stmt->rowCount();
    return $data;
    $conndb =  null;
}

// นับจำนวน total
function countTotal($conndb)
{
    $data = null;
    $stmt = $conndb->query("SELECT id FROM totel WHERE date(date) = CURDATE()");
    $stmt->execute();
    $data = $stmt->rowCount();
    return $data;
    $conndb =  null;
}

function insertTime($conndb, $m_card)
{
    $stmt = $conndb->prepare("INSERT INTO `tb_time` (`ref_m_card`,`date`) VALUES ( :m_card , current_timestamp())");
    $stmt->bindParam(':m_card', $m_card);
    $stmt->execute();
    return $stmt;
    $conndb = null;
}

// เพื่มข้อมูล total หากค่าเท่ากับ 0 
function insetTotal($conndb)
{
    $quantity = 1;
    $stmt = $conndb->prepare("INSERT INTO `totel`(`quantity`, `date`) VALUES ($quantity, current_timestamp() )");
    $stmt->execute();
    return $stmt;
    $conndb = null;
}

// อัปเดท total หากค่าไม่เท่ากับ 0
function updateTotal($conndb, $quantity, $id_totel)
{
    // $quantity + 2 ;
    $stmt = $conndb->prepare("UPDATE `totel` SET `quantity`= :qty WHERE `id` = :id ");
    $stmt->bindParam("qty", $quantity);
    $stmt->bindParam("id", $id_totel);
    $stmt->execute();
    return $stmt;
    $conndb = null;
}
// เช็ควันหมดอายุ
function datediff($str_start, $str_end)
{
    $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
    $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
    $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
    $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที
    return $ndays;
}

// ****************************************************************************************************************

// อัปเดทproduct_value
function updateProductValue($conndb, $m_card, $new_value)
{
    $sql = "UPDATE `customer` SET `product_value` = :new_value WHERE `m_card` = :m_card";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':new_value', $new_value);
    $stmt->bindParam(':m_card', $m_card);
    return $stmt->execute(); // Return true on success, false on failure
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
