<?php
session_start();

// ตั้งค่าเวลาหมดอายุ session (หน่วยเป็นวินาที)
$timeout_duration = 3600; // 1 ชั่วโมง

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    // หากไม่มีการใช้งานเกินเวลาที่กำหนด ให้ออกจากระบบ
    session_unset();
    session_destroy();
    header("Location: ../index.php"); // เปลี่ยนไปหน้าล็อกอินหรืออื่นๆ
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time(); // อัปเดตเวลาการใช้งานล่าสุด

if ($_SESSION['site'] != '1' && $_SESSION['id'] == '') {
    header('location:../');
}
