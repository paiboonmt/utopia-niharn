<?php
session_start();
include("../middleware.php");
date_default_timezone_set('Asia/Bangkok');
require_once("../../includes/connection.php");
include './FunctionCheckin.php';

if (isset($_POST['ref_m_card'])) {

    $m_card = $_POST['ref_m_card'];
    
    if (checkNumberCard( $conndb, $m_card) == 0) { 
        $_SESSION['number_error'] = true;
        back_to_checkin();
    }

    if (checkNumber($conndb, $m_card) == 1) {                           // Member
        if (exp_date($conndb, $m_card) >= 0) {      
            // 1 = ประเภทไม่นับจำนวนครั้ง
            if (checkProductType($conndb, $m_card) == 1) {              // ประเภทไม่นับจำนวนครั้ง
                $new_value = checkProductValue($conndb, $m_card) - 1;   // ลดจำนวนครั้ง
                if ($new_value < 0) {                                   // เช็คจำนวนครั้ง
                    $_SESSION['product_expired'] = true;   
                    checkInMember($conndb, $m_card);                    // หมดอายุ
                    back_to_checkin();                                             // ปิดการเชื่อมต่อฐานข้อมูล
                }
                updateProductValue($conndb, $m_card, $new_value);       // อัปเดทจำนวนครั้ง
                checkInMember($conndb, $m_card); 
                back_to_checkin();                                                 // ปิดการเชื่อมต่อฐานข้อมูล

            // 2 = ประเภทนับจำนวนครั้ง   
            } else if (checkProductType($conndb, $m_card) == 2) {           // ประเภทนับจำนวนครั้ง
                if (checkProductValue($conndb, $m_card) <= 0) {             // เช็คจำนวนครั้ง
                    checkInMember($conndb, $m_card);                        // เช็คจำนวนครั้ง
                    $_SESSION['product_expired'] = true;                             
                    back_to_checkin();                                                 // ปิดการเชื่อมต่อฐานข้อมูล  
                } else {
                    $new_value = checkProductValue($conndb, $m_card) - 1;   // ลดจำนวนครั้ง
                    updateProductValue($conndb, $m_card, $new_value);       // อัปเดทจำนวนครั้ง
                    checkInMember($conndb, $m_card);
                    $_SESSION['checkin_success'] = true;
                    back_to_checkin();                                                 // ปิดการเชื่อมต่อฐานข้อมูล
                }
            } else {
                back_to_checkin();                                                     // ปิดการเชื่อมต่อฐานข้อมูล
            }
        } else {

            if (checkProductValue($conndb, $m_card) <= 0) {             
                checkInMember($conndb, $m_card);                        
                $_SESSION['date_expiry'] = true;                           
                back_to_checkin();                                                 // ปิดการเชื่อมต่อฐานข้อมูล  
            } else {
                $new_value = checkProductValue($conndb, $m_card) - 1;   // ลดจำนวนครั้ง
                updateProductValue($conndb, $m_card, $new_value);       // อัปเดทจำนวนครั้ง
                checkInMember($conndb, $m_card);                        // เช็คจำนวนครั้ง
                $_SESSION['date_expiry'] = true;                        // เช็ควันหมดอายุ
                back_to_checkin();                                      // ปิดการเชื่อมต่อฐานข้อมูล
            }
        }
    } else {
        include './functions.php';
        if ( customCheckDate( $conndb , $m_card ) <= 0) { 
            checkInMember( $conndb , $m_card );                     // เช็ควันหมดอายุ
            $_SESSION['expiry'] = true;                             // หมดอายุ
            back_to_checkin();                                        // ปิดการเชื่อมต่อฐานข้อมูล
        } else {
            checkInMember( $conndb , $m_card );                     // หมายเลขบัตรใช้งานไม่ได้
            back_to_checkin();                                       // ปิดการเชื่อมต่อฐานข้อมูล
        }
    }
}




