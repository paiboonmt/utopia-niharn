<?php
    require_once '../../includes/connection.php';
    $del_id = $_POST['id'];
    $sql = $conndb->prepare("DELETE FROM `checkin` WHERE `checkin_id` = :id");
    $sql->bindParam(":id",$del_id);
    $sql->execute();
    $conndb = null;
?>