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
        return $stmt->execute();
        $conndb = null;
    }

    function voice_bill($conndb,$num_bill,$price,$discount,$sub_discount,$payment,$vat7,$vat3,$sub_vat,$total,$user,$comment){
         
            $date = date('Y-m-d H:i:s'); // Current date and time
     
            $sql = "INSERT INTO `shop_voice`(`num_bill`, `price`, `discount`, `sub_discount`, `payment`, `vat7`, `vat3`, `sub_vat`, `total`, `date`, `user`, `comment`) 
            VALUES ( :num_bill , :price , :discount , :sub_discount , :payment , :vat7 , :vat3 , :sub_vat , :total , :date , :user , :comment)";
            $stmt = $conndb->prepare($sql);
            $stmt->bindParam(':num_bill', $num_bill);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':discount', $discount);
            $stmt->bindParam(':sub_discount', $sub_discount);
            $stmt->bindParam(':payment', $payment);
            $stmt->bindParam(':vat7', $vat7);
            $stmt->bindParam(':vat3', $vat3);
            $stmt->bindParam(':sub_vat', $sub_vat);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':comment', $comment);
            return $stmt->execute();
            $conndb = null;
    }


    function countBill($conndb){
        $sql = "SELECT COUNT(*) FROM `shop_orders` WHERE DATE(date) = CURDATE() AND status = 1";
        $stmt = $conndb->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
        $conndb = null; 
    }
?>

