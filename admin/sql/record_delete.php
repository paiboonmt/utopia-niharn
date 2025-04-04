<?php
    require_once '../../includes/connection.php';
    $del_id = $_POST['id'];
    $sql = $conndb->prepare("DELETE FROM `tb_time` WHERE `time_id`= :id ");
    $sql->bindParam(":id",$del_id);
    $sql->execute();
    $conndb = null;
?>