<?php

    session_start();

    require_once '../../../includes/connection.php';
    
    if(isset($_POST['up_package'])){

        $package = $_POST['nation'];
        $nationality_id = $_POST['nationality_id'];

        $sql = $conndb->prepare("UPDATE `tb_nationality` SET `n_name`=:n WHERE nationality_id =:nid ");
        $sql->bindParam(':n',$package);
        $sql->bindParam(':nid',$nationality_id);
        $sql->execute();

        $_SESSION['update_nation_success'] = true;
        header('location:../../nationnality.php');
    }
    $conndb = null;
?>