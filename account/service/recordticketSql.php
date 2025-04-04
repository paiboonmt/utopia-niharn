<?php 
    session_start();
    include('../middleware.php');
    include('../../includes/connection.php');

    if (isset($_POST['saveUpdateOrder'])) {
        $m_card = $_POST['m_card'];
        $discount = $_POST['discount'];
        $pay = $_POST['pay'];
        $vat7 = $_POST['vat7'];
        $vat3 = $_POST['vat3'];
        $sta_date = $_POST['sta_date'];
        $exp_date = $_POST['exp_date'];
        $fname = $_POST['fname'];
        $comment = $_POST['comment'];
        $id = $_POST['id'];
        $grandTotal = $_POST['grandTotal'];

        global $conndb;
        $sql = "UPDATE member SET discount = '$discount', pay = '$pay' , vat7 = '$vat7' , vat3 = '$vat3' , 
        sta_date = '$sta_date' , exp_date = '$exp_date' , fname = '$fname' , comment = '$comment' , total = '$grandTotal'  WHERE package = '$id' ";
        $stmt = $conndb->prepare($sql);
        if ( $stmt->execute()) {

            // อัปเดท ตาราง order
            $sqlOrder = $conndb->prepare("UPDATE `orders` SET `fname`= '$fname',`discount`= '$discount',`vat7`= '$vat7',
            `vat3`= '$vat3',`pay`='$pay',`sta_date`='$sta_date',`exp_date`='$exp_date',`comment`='$comment',`total`='$grandTotal' WHERE id = '$id'");
            if ($sqlOrder->execute()){
                header('location:../print/rePrintBil.php?id=' . $id );
            }
        }

        // header("location:recordticket.php");
    }

    if (isset($_POST['updateOrder'])) {
        $m_card = $_POST['m_card'];
        $discount = $_POST['discount'];
        $pay = $_POST['pay'];
        $vat7 = $_POST['vat7'];
        $vat3 = $_POST['vat3'];
        $sta_date = $_POST['sta_date'];
        $exp_date = $_POST['exp_date'];
        $fname = $_POST['fname'];
        $comment = $_POST['comment'];
        $id = $_POST['id'];
        $grandTotal = $_POST['grandTotal'];
        $befortotal = $_POST['befortotal'];
        updateData($discount , $pay , $vat7 , $vat3 , $sta_date , $exp_date , $fname , $comment ,$befortotal, $grandTotal , $id);
    }

    if (isset($_POST['editBill'])) {
    
        $product_name = $_POST['product_name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $order_id = $_POST['order_id'];
        $product_id = $_POST['product_id'];
        global  $conndb;
        $sql = "UPDATE `order_details` SET `product_name`='$product_name',`quantity`='$quantity',`price`='$price' WHERE `order_id` = ? AND `product_id` = ?";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(1,$order_id);
        $stmt->bindParam(2,$product_id);
        if ( $stmt->execute()) {
            $sql_order = "UPDATE `orders` SET `price`='$price' WHERE id = '$order_id' ";
            $stmt_order = $conndb->prepare($sql_order);
            $stmt_order->execute();
        }
        $_SESSION['editBill'] = true;
        header('location:recordticketEdit.php?id='.$order_id);
    }

    function updateData( $discount , $pay , $vat7 , $vat3 , $sta_date , $exp_date , $fname , $comment , $befortotal , $grandTotal , $id ){
        global $conndb;
        $sql = "UPDATE member SET discount = '$discount', pay = '$pay' , vat7 = '$vat7' , vat3 = '$vat3' , sta_date = '$sta_date' , exp_date = '$exp_date' , fname = '$fname' , comment = '$comment' , total = '$grandTotal'  WHERE package = '$id' ";
        $stmt = $conndb->prepare($sql);
        if ( $stmt->execute()) {

            // อัปเดท ตาราง order
            $sqlOrder = $conndb->prepare("UPDATE `orders` SET `fname`= '$fname',`discount`= '$discount',`price`= '$befortotal',`vat7`= '$vat7',`vat3`= '$vat3',`pay`='$pay',`sta_date`='$sta_date',`exp_date`='$exp_date',`comment`='$comment',`total`='$grandTotal' WHERE id = '$id'");
            if ($sqlOrder->execute()){
                $_SESSION['updateBil'] = true;
                header("location:../recordticketEdit.php?id=".$id);
                // header("location:recordticket.php");
            }
        }
    }

    $conndb = null;
?> 


