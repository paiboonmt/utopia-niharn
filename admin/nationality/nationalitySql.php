<?php
session_start();
include('../middleware.php');
include_once('../../includes/connection.php');

//Insert
if (isset($_POST['insert']) && $_POST['nation']) {
    $package = $_POST['nation'];
    $sql = $conndb->prepare("INSERT INTO `tb_nationality`(`n_name`) VALUES ( ? )");
    $sql->bindParam(1 , $package , PDO::PARAM_STR);
    if ($sql->execute()){
        $_SESSION['insert'] = true;
        header('location:../nationnality.php');
    }
    $conndb = null;
}

//update
if (isset($_POST['update'])){
    $package = $_POST['nation'];
    $id = $_POST['id'];
    $sql = $conndb->prepare("UPDATE `tb_nationality` SET `n_name`= ? WHERE nationality_id = ? ");
    $sql->bindParam( 1 ,$package , PDO::PARAM_STR);
    $sql->bindParam( 2 ,$id , PDO::PARAM_INT);
    if ($sql->execute()){
        $_SESSION['update'] = true;
        header('location:../nationnality.php');
    }
    $conndb = null;
}

//Delete
if (isset($_POST['action']) == 'delete' && $_POST['id']){
    $id = $_POST['id'];
    $sql = $conndb->prepare("DELETE FROM `tb_nationality` WHERE `nationality_id` = ? ");
    $sql->bindParam( 1 ,$id , PDO::PARAM_INT);
    $sql->execute();
    $conndb = null;
}

$conndb = null;