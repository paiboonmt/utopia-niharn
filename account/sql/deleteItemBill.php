<?php
    session_start();
    require_once("../../../includes/connection.php");
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $pro_id = $_GET['pro_id'];
        $sql = "DELETE FROM `order_details` WHERE `order_id` = ? AND `product_id` = ? ";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(1,$id);
        $stmt->bindParam(2,$pro_id);
        if ( $stmt->execute()) {
            header('location:../recordticketEdit.php?id='.$id);
        }

        $conndb = null;
    }
?>

