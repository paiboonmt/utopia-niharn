<?php
session_start();
    require_once '../../../includes/connection.php';

    if(isset($_POST['id'])){

        $id = $_POST['id'];

        $sql = $conndb->prepare("DELETE FROM `tb_nationality` WHERE `nationality_id` = :p");
        $sql->bindParam(':p',$id);
        $sql->execute();

    }
    
    $conndb = null;
?>