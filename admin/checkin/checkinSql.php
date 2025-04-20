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

    if (checkNumberCard($conndb, $m_card) == 0) {
        $_SESSION['number_error'] = true;
        back_to_checkin();
    }

    echo 'หมายเลขบัตร => : ' . $m_card; // แสดงหมายเลขบัตรที่กรอก
    echo '<br>';
    echo 'มีหมายเลขอยู่คือ 1 ไม่มีคือ 0 => : ' . checkNumberCard($conndb, $m_card); // เช็คหมายเลขบัตรว่าอยู่ในฐานข้อมูลหรือไม่
    echo '<br>';
    echo 'ประเภทบัตร 1 คือ customer เลข 2 คือ pos => : ' . checkType($conndb, $m_card); // เช็คประเภทบัตร
    echo '<br>';
    // echo 'วันหมดอายุ => : '. exp_date($conndb, $m_card); // เช็ควันหมดอายุ
    // echo '<br>';
    // echo 'ประเภทไม่นับจำนวนครั้ง => : '. checkProductType($conndb, $m_card); // เช็คประเภทไม่นับจำนวนครั้ง
    // echo '<br>';
    // echo 'จำนวนครั้ง => : '. checkProductValue($conndb, $m_card); // เช็คจำนวนครั้ง
    // echo '<hr>';


    if (checkType($conndb, $m_card) == 1) { // เช็คประเภทบัตร

        if (exp_date($conndb, $m_card) >= 0) { // เช็ควันหมดอายุ
            echo 'บัตรยังไม่หมดอายุ';
        } else {
            echo 'บัตรหมดอายุ';
        }
    } else {

        echo 'ไม่ใช่ประเภทบัตรลูกค้า';
        echo '<hr>';
        $result = getDataOrder($conndb, $m_card); // ดึงข้อมูลจากฐานข้อมูลCustomer
        echo 'หมายเลขบัตร => : ' . $result['ref_order_id']; // แสดงหมายเลขบัตรที่กรอก
        echo '<br>';
        echo 'วันเริ่มต้น => : ' . $result['sta_date']; // แสดงชื่อ
        echo '<br>';
        echo 'วันสิ้นสุด => : ' . $result['exp_date']; // แสดงชื่อ
        echo '<br>';
        echo datediff($result['sta_date'], $result['exp_date']); // เช็คจำนวนวันคงเหลือ
        echo '<br>';

        if (datediff($result['sta_date'], $result['exp_date']) <= 0) { // เช็คจำนวนวันคงเหลือ

            echo 'บัตรหมดอายุ';
        } else {

            echo 'บัตรยังไม่หมดอายุ';
            echo '<hr>';
            echo '' . checkTotel($conndb);
            echo '<br>';


            if (checkTotel($conndb) == 0) {
                echo 'ยังไม่มีการบันทึกข้อมูลการใช้บริการ';
                echo '<br>';
                echo checkInToday($conndb, $m_card); // เช็คการเข้าใช้บริการวันนี้
                echo '<br>';

                $group_type = $result['group_type'];
                $customer_name = $result['customer_name'];
                $product = $result['product'];
                $exp_date = $result['exp_date'];


                insertTime($conndb, $m_card, $group_type, $customer_name, $product, $exp_date); // บันทึกเวลา checkin
                echo '<br>';
                echo 'บันทึกเวลา checkin เรียบร้อยแล้ว';
                echo '<br>';
                echo 'บันทึกข้อมูลการใช้บริการเรียบร้อยแล้ว';
                echo '<br>';
            } else {
                echo 'บัตรหมดอายุ';
            }
        }
        echo '<hr>';
    }
    echo '<br>';


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
