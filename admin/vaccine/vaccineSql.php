<?php
    session_start();
    include('./middleware.php');
//insert
if (isset($_POST['insert'])) {
    include_once('../includes/connection.php');
    $vaccine = $_POST['vaccine'];
    $country = $_POST['country'];
    $percentage = $_POST['percentage'];
    $sql = $conndb->prepare(" INSERT INTO `tb_vaccine`(`name`, `country`, `percentage`) VALUES (?,?,?)");
    $sql->bindParam(1, $vaccine , PDO::PARAM_STR);
    $sql->bindParam(2, $country , PDO::PARAM_STR);
    $sql->bindParam(3, $percentage , PDO::PARAM_STR);
    if ( $sql->execute() ) {
        $_SESSION['insert'] = true;
        header('location:vaccine.php');
    }
    $conndb = null;
}

if (isset($_POST['update'])) {
    include_once('../includes/connection.php');
    $id = $_POST['id'];
    $vaccine = $_POST['vaccine'];
    $country = $_POST['country'];
    $percentage = $_POST['percentage'];
    $sql = $conndb->prepare("UPDATE `tb_vaccine` SET `name`= ? ,`country`= ? ,`percentage`= ? WHERE id = ?");
    $sql->bindParam( 1 , $vaccine , PDO::PARAM_STR);
    $sql->bindParam( 2 , $country , PDO::PARAM_STR);
    $sql->bindParam( 3 , $percentage , PDO::PARAM_STR);
    $sql->bindParam( 4 , $id , PDO::PARAM_INT);
    if ( $sql->execute() ) {
        $_SESSION['update'] = true;
        header('location:vaccine.php');
    }
    $conndb = null;
}

if (isset($_POST['action']) && $_POST['action'] == 'delete'){
    include_once('../includes/connection.php');
    $id = $_POST['id'];
    $sql = $conndb->prepare(" DELETE FROM `tb_vaccine` WHERE id =  ? ");
    $sql->bindParam( 1 , $id , PDO::PARAM_INT);
    if ( $sql->execute() ) {
        $_SESSION['delete'] = true;
        header('location:vaccine.php');
    }
    $conndb = null;
}