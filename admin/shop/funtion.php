<?php

    function getData(){
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
    }
    
    function cancelBill($conndb,$id){
        $sql = "UPDATE `shop_orders` SET `status` = 2 WHERE id = ?";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }



    function countBill($conndb){
        $sql = "SELECT COUNT(*) FROM `shop_orders` WHERE DATE(date) = CURDATE() AND status = 1";
        $stmt = $conndb->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
?>

