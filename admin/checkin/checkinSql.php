<?php
include("../middleware.php");
date_default_timezone_set('Asia/Bangkok');
include './functions.php';
$date = date('Y-m-d');

if (isset($_POST['ref_m_card'])) {
    require_once("../../includes/connection.php");
    $m_card = $_POST['ref_m_card'];

    // เช็คหมายเลขบัตร
    if (checkNumberCard($conndb, $m_card) == 0) {
        $_SESSION['number_error'] = true;
        $conndb = null;
        back_to_checkin();
        exit;
    }

    // echo 'หมายเลขบัตร : ' . $m_card . '<br>';
    // echo 'ประเภทบัตร : ' . checkType($conndb, $m_card) . '<br>'; 
    // print_r(getDataOrder($conndb, $m_card));
    // $result = getDataOrder($conndb, $m_card);
    // echo '<br>';
    // echo $result['sta_date'] . '<br>';
    // echo $result['exp_date'] . '<br>';
    // echo 'จำนวนวันคงเหลือ : ' . datediff($date, $result['exp_date']) . '<br>';
    // exit;

    if (checkType($conndb, $m_card) == 1) { // เช็คประเภทบัตร
        if (exp_date($conndb, $m_card) >= 0) { // เช็ควันหมดอายุ

            $group_type = 1; // ประเภทบัตร
            $customer_name = getDataCustomer($conndb, $m_card)['fname']; // ดึงข้อมูลจากฐานข้อมูลCustomer
            $product = getDataCustomer($conndb, $m_card)['product_name']; // ดึงข้อมูลจากฐานข้อมูลCustomer
            $exp_date = getDataCustomer($conndb, $m_card)['exp_date']; // ดึงข้อมูลจากฐานข้อมูลCustomer

            if (checkProductValue($conndb, $m_card) <= 0) { // เช็คจำนวนครั้ง
                $_SESSION['product_expired'] = true; // หมดอายุ
                insertTime($conndb, $m_card, $group_type, $customer_name, $product, $exp_date); // บันทึกเวลา checkin
                $conndb = null;
                back_to_checkin();
                exit;
            } else {
                $new_value = checkProductValue($conndb, $m_card) - 1; // ลดจำนวนครั้ง
                updateProductValue($conndb, $m_card, $new_value); // อัปเดทจำนวนครั้ง
                insertTime($conndb, $m_card, $group_type, $customer_name, $product, $exp_date); // บันทึกเวลา checkin
                $conndb = null;
                back_to_checkin();
                exit;
            }
        } else {
            $_SESSION['date_expiry'] = true; // หมดอายุ
            $conndb = null;
            back_to_checkin();
            exit;
        }
    } else {
        $result = getDataOrder($conndb, $m_card);                           // ดึงข้อมูลจากฐานข้อมูลOrder
        if (datediff($date, $result['exp_date']) <= 0) {      // เช็คจำนวนวันคงเหลือ
            $_SESSION['date_expiry'] = true;                                // หมดอายุ
            $group_type = 2;
            $customer_name = $result['fname'];
            $product = getDataOrderDetail($conndb, $m_card)['product_name']; // ดึงข้อมูลจากฐานข้อมูลOrder
            $exp_date = $result['exp_date'];
            insertTime($conndb, $m_card, $group_type, $customer_name, $product, $exp_date); // บันทึกเวลา checkin
            $conndb = null;
            back_to_checkin();
            exit;
        } else {
            if (checkInToday($conndb) == 0) {
                $group_type = 2;
                $customer_name = $result['fname'];
                $product = getDataOrderDetail($conndb, $m_card)['product_name']; // ดึงข้อมูลจากฐานข้อมูลOrder
                $exp_date = $result['exp_date'];
                insertTime($conndb, $m_card, $group_type, $customer_name, $product, $exp_date); // บันทึกเวลา checkin
                $conndb = null;
                back_to_checkin();
                exit;
            } else {
                $group_type = 2;
                $customer_name = $result['fname'];
                $product = getDataOrderDetail($conndb, $m_card)['product_name']; // ดึงข้อมูลจากฐานข้อมูลOrder
                $exp_date = $result['exp_date'];
                insertTime($conndb, $m_card, $group_type, $customer_name, $product, $exp_date); // บันทึกเวลา checkin
                $conndb = null;
                back_to_checkin();
                exit;
            }
        }
        echo '<hr>';
    }
    $conndb = null;
} else {
    $_SESSION['number_error'] = true;
    $conndb = null;
    back_to_checkin();
    exit;
}
