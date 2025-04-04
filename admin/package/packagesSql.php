<?php
session_start();
include('../middleware.php');
include_once('../../includes/connection.php');
//Insert
if (isset($_POST['insert'])) {
    $package = $_POST['package'];
    $sql = $conndb->prepare("INSERT INTO `tb_package`(`p_name`) VALUES ( ? )");
    $sql->bindParam(1, $package , PDO::PARAM_STR);
    $sql->execute();
    $_SESSION['insert'] = true;
    header('location:../package.php');
    $conndb = null;
}

//Update
if (isset($_POST['update'])) {
    $package = $_POST['package'];
    $package_id = $_POST['package_id'];
    $sql = $conndb->prepare("UPDATE `tb_package` SET `p_name`=  ? WHERE `package_id` =  ? ");
    $sql->bindParam(1, $package , PDO::PARAM_STR);
    $sql->bindParam(2, $package_id , PDO::PARAM_INT);
    $sql->execute();
    $_SESSION['update'] = true;
    header('location:../package.php');
    $conndb = null;
}

//Delete
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];
    $sql = $conndb->prepare("DELETE FROM `tb_package` WHERE `package_id` =  ? ");
    $sql->bindParam( 1 , $id , PDO::PARAM_INT);
    $sql->execute();
    $conndb = null;
}

$conndb = null;
