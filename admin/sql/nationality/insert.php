<?php
session_start();
    require_once '../../../includes/connection.php';
    if(isset($_POST['add_nation'])){

        $package = $_POST['nation'];
        $sql = $conndb->prepare("INSERT INTO `tb_nationality`(`n_name`) VALUES (:n)");
        $sql->bindParam(':n',$package);
        $sql->execute();

        $_SESSION['in_nation_success'] = true;
        header('location:../../nationnality.php');
    }
    $conndb = null;
?>