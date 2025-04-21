<?php
session_start();
include("../middleware.php");
date_default_timezone_set('Asia/Bangkok');
require_once("../../includes/connection.php");
// include './FunctionCheckin.php';
include './functions.php';

if (isset($_POST['ref_m_card'])) {

    $m_card = $_POST['ref_m_card'];

    // 3489944354

    if (checkNumberCard($conndb, $m_card) == 0) {   // เช็คหมายเลขบัตร
        $_SESSION['number_error'] = true;           // ไม่มีหมายเลขนี้ในระบบ
        back_to_checkin();                          // ย้อนกลับไปที่หน้าเช็คอิน
        exit;
    }

    echo 'หมายเลขบัตร => : ' . $m_card; // แสดงหมายเลขบัตรที่กรอก
    echo '<br>';
    echo 'มีหมายเลขอยู่คือ 1 ไม่มีคือ 0 => : ' . checkNumberCard($conndb, $m_card); // เช็คหมายเลขบัตรว่าอยู่ในฐานข้อมูลหรือไม่
    echo '<br>';
    echo 'ประเภทบัตร 1 คือ customer เลข 2 คือ pos => : ' . checkType($conndb, $m_card); // เช็คประเภทบัตร
    echo '<br>';
    echo 'วันหมดอายุ => : ' . exp_date($conndb, $m_card); // เช็ควันหมดอายุ
    echo '<br>';
    echo 'ประเภทไม่นับจำนวนครั้ง => : ' . checkProductType($conndb, $m_card); // เช็คประเภทไม่นับจำนวนครั้ง
    echo '<br>';
    echo 'จำนวนครั้ง => : ' . checkProductValue($conndb, $m_card); // เช็คจำนวนครั้ง
    echo '<hr>';


    if (checkType($conndb, $m_card) == 1) { // เช็คประเภทบัตร
        if (exp_date($conndb, $m_card) >= 0) { // เช็ควันหมดอายุ

            $group_type = 1; // ประเภทบัตร
            $customer_name = getDataCustomer($conndb, $m_card)['fname']; // ดึงข้อมูลจากฐานข้อมูลCustomer
            $product = getDataCustomer($conndb, $m_card)['product_name']; // ดึงข้อมูลจากฐานข้อมูลCustomer
            $exp_date = getDataCustomer($conndb, $m_card)['exp_date']; // ดึงข้อมูลจากฐานข้อมูลCustomer

            if ( checkProductValue($conndb, $m_card) <= 0) { // เช็คจำนวนครั้ง
                $_SESSION['product_expired'] = true; // หมดอายุ
                insertTime($conndb, $m_card, $group_type, $customer_name, $product, $exp_date); // บันทึกเวลา checkin
                back_to_checkin(); // ปิดการเชื่อมต่อฐานข้อมูล
            } else {
                $new_value = checkProductValue($conndb, $m_card) - 1; // ลดจำนวนครั้ง
                updateProductValue($conndb, $m_card, $new_value); // อัปเดทจำนวนครั้ง
                insertTime($conndb, $m_card, $group_type, $customer_name, $product, $exp_date); // บันทึกเวลา checkin
                back_to_checkin(); // ปิดการเชื่อมต่อฐานข้อมูล
            }
            
        } else {
            $_SESSION['date_expiry'] = true; // หมดอายุ
            echo 'บัตรหมดอายุ';
            back_to_checkin();
        }
    } else {
        $result = getDataOrder($conndb, $m_card);                           // ดึงข้อมูลจากฐานข้อมูลOrder
        if (datediff($result['sta_date'], $result['exp_date']) <= 0) {      // เช็คจำนวนวันคงเหลือ
            $_SESSION['date_expiry'] = true;                                // หมดอายุ
            $group_type = 2;
            $customer_name = $result['fname'];
            $product = getDataOrderDetail($conndb, $m_card)['product_name']; // ดึงข้อมูลจากฐานข้อมูลOrder
            $exp_date = $result['exp_date'];
            insertTime($conndb, $m_card, $group_type, $customer_name, $product, $exp_date); // บันทึกเวลา checkin
            echo 'บัตรหมดอายุ';
            back_to_checkin(); // ปิดการเชื่อมต่อฐานข้อมูล
        } else {
            if (checkInToday($conndb) == 0) {
                $group_type = 2;
                $customer_name = $result['fname'];
                $product = getDataOrderDetail($conndb, $m_card)['product_name']; // ดึงข้อมูลจากฐานข้อมูลOrder
                $exp_date = $result['exp_date'];
                insertTime($conndb, $m_card, $group_type, $customer_name, $product, $exp_date); // บันทึกเวลา checkin
                back_to_checkin();
                exit;
            } else {
                $group_type = 2;
                $customer_name = $result['fname'];
                $product = getDataOrderDetail($conndb, $m_card)['product_name']; // ดึงข้อมูลจากฐานข้อมูลOrder
                $exp_date = $result['exp_date'];
                insertTime($conndb, $m_card, $group_type, $customer_name, $product, $exp_date); // บันทึกเวลา checkin
                back_to_checkin();
                exit;
            }
        }
        echo '<hr>';
    }
    // echo '<br>';


    // if (checkNumberCard( $conndb, $m_card) == 0) { 
    //     $_SESSION['number_error'] = true;
    //     back_to_checkin();
    // }

    // if (checkNumber($conndb, $m_card) == 1) {                           // Member
    //     if (exp_date($conndb, $m_card) >= 0) {      
    //         // 1 = ประเภทไม่นับจำนวนครั้ง
    //         if (checkProductType($conndb, $m_card) == 1) {              // ประเภทไม่นับจำนวนครั้ง
    //             $new_value = checkProductValue($conndb, $m_card) - 1;   // ลดจำนวนครั้ง
    //             if ($new_value < 0) {                                   // เช็คจำนวนครั้ง
    //                 $_SESSION['product_expired'] = true;   
    //                 checkInMember($conndb, $m_card);                    // หมดอายุ
    //                 back_to_checkin();                                             // ปิดการเชื่อมต่อฐานข้อมูล
    //             }
    //             updateProductValue($conndb, $m_card, $new_value);       // อัปเดทจำนวนครั้ง
    //             checkInMember($conndb, $m_card); 
    //             back_to_checkin();                                                 // ปิดการเชื่อมต่อฐานข้อมูล

    //         // 2 = ประเภทนับจำนวนครั้ง   
    //         } else if (checkProductType($conndb, $m_card) == 2) {           // ประเภทนับจำนวนครั้ง
    //             if (checkProductValue($conndb, $m_card) <= 0) {             // เช็คจำนวนครั้ง
    //                 checkInMember($conndb, $m_card);                        // เช็คจำนวนครั้ง
    //                 $_SESSION['product_expired'] = true;                             
    //                 back_to_checkin();                                                 // ปิดการเชื่อมต่อฐานข้อมูล  
    //             } else {
    //                 $new_value = checkProductValue($conndb, $m_card) - 1;   // ลดจำนวนครั้ง
    //                 updateProductValue($conndb, $m_card, $new_value);       // อัปเดทจำนวนครั้ง
    //                 checkInMember($conndb, $m_card);
    //                 $_SESSION['checkin_success'] = true;
    //                 back_to_checkin();                                                 // ปิดการเชื่อมต่อฐานข้อมูล
    //             }
    //         } else {
    //             back_to_checkin();                                                     // ปิดการเชื่อมต่อฐานข้อมูล
    //         }
    //     } else {

    //         if (checkProductValue($conndb, $m_card) <= 0) {             
    //             checkInMember($conndb, $m_card);                        
    //             $_SESSION['date_expiry'] = true;                           
    //             back_to_checkin();                                                 // ปิดการเชื่อมต่อฐานข้อมูล  
    //         } else {
    //             $new_value = checkProductValue($conndb, $m_card) - 1;   // ลดจำนวนครั้ง
    //             updateProductValue($conndb, $m_card, $new_value);       // อัปเดทจำนวนครั้ง
    //             checkInMember($conndb, $m_card);                        // เช็คจำนวนครั้ง
    //             $_SESSION['date_expiry'] = true;                        // เช็ควันหมดอายุ
    //             back_to_checkin();                                      // ปิดการเชื่อมต่อฐานข้อมูล
    //         }
    //     }
    // } else {
    //     include './functions.php';
    //     if ( customCheckDate( $conndb , $m_card ) <= 0) { 
    //         checkInMember( $conndb , $m_card );                     // เช็ควันหมดอายุ
    //         $_SESSION['expiry'] = true;                             // หมดอายุ
    //         back_to_checkin();                                        // ปิดการเชื่อมต่อฐานข้อมูล
    //     } else {
    //         checkInMember( $conndb , $m_card );                     // หมายเลขบัตรใช้งานไม่ได้
    //         back_to_checkin();                                       // ปิดการเชื่อมต่อฐานข้อมูล
    //     }
    // }


}
