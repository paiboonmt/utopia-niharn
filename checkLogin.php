<?php
session_start();
if (isset($_POST['username']) && $_POST['password']) {
    include("./includes/connection.php");
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    $stmt = $conndb->prepare("SELECT * FROM `tb_user` WHERE `username` = ?");
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    print_r($user);
    // exit;

    if ($user) {
        // ตรวจสอบรหัสผ่านด้วย password_verify()
        if (password_verify($password, $user['password'])) {

                $_SESSION['UserID'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['site'] = $user['site'];
                $_SESSION['status'] = $user['status'];
            

            if ($_SESSION['status'] != '1') {
                $_SESSION['not_active'] = true;
                header('location:./');
                exit();
            }

            if ($_SESSION['site'] == '1') {
                header("location:admin/");
            } elseif ($_SESSION['site'] == '2') {
                header("location:account/recordTicket.php");
            } else {
                header('location:./');
                unset($_SESSION);
                exit();
            }
        } else {

            header('location:./');
            unset($_SESSION);
            exit();
        }
    } else {

        header('location:./');
        unset($_SESSION);
        exit();
    }
} else {
    header('location:./');
}

$conndb = null;
