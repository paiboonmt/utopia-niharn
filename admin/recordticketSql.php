<?php
    include('./middleware.php');
    require_once("../includes/connection.php");

    //แก้ไขบิล เพื่ม item เข้าไปในบิล
    if (isset($_POST['addItem'])){

        $befortotal = $_POST['befortotal'];
        $new_product_id = $_POST['new_product_id']; // new_item
        $order_id = $_POST['order_id'];
        $quantity = $_POST['quantity'];
        $date = date("Y-m-d");
        
        $sqlProduct = $conndb->query("SELECT * FROM `products` WHERE id = '$new_product_id'");
        $sqlProduct->execute();
        foreach ( $sqlProduct AS $rowP ) {
            $product_name = $rowP['product_name'];
            $price =  $rowP['price'];
        }

        $total = $quantity * $price;

        $sql = "INSERT INTO `order_details`(`order_id`, `product_id`, `product_name`, `price`, `quantity`, `total`, `date`) 
        VALUES ('$order_id','$new_product_id','$product_name','$price','$quantity','$total','$date' )";
        $stmt = $conndb->prepare($sql);
        $stmt->execute();
        header("location:recordticketEdit.php?id=".$order_id);

        $conndb = null;
    }

    //แก้ไขข้อมูลสินค้าภายในบิล
    if (isset($_POST['editBill'])) {
        $product_name = $_POST['product_name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $order_id = $_POST['order_id'];
        $product_id = $_POST['product_id'];

        $sql = "UPDATE `order_details` SET `quantity`='$quantity',`price`='$price' 
        WHERE `order_id` = ? AND `product_id` = ?";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(1,$order_id);
        $stmt->bindParam(2,$product_id);
        if ( $stmt->execute()) {
            $_SESSION['editBill'] = true;
            header('location:recordticketEdit.php?id='.$order_id);
        }
        $conndb = null;
    }

    // ลบข้อมูล
    if ( isset($_GET['act']) == 'delete' && $_GET['id'] ) {
        // global $conndb;
        $id = $_GET['id'];
       try {
            $sqlMember = $conndb->prepare("DELETE FROM `member` WHERE `package` =  '$id'");
            if ($sqlMember->execute()) {
                $sqlOrders = $conndb->prepare("DELETE FROM `orders` WHERE id = '$id' ");
                if ($sqlOrders->execute()){
                    $sqlOrderDetails = $conndb->prepare("DELETE FROM `order_details` WHERE `order_id` = '$id' ");
                    $sqlOrderDetails->execute();
                    header('location:recordticket.php');
                    $conndb = null;
                }
            }
       } catch (PDOException $e) {
            echo 'error'. $e->getMessage();
       }
    }

    //บันทึกข้อมูลและปริ้น
    if (isset($_POST['saveUpdateOrder'])){
        $m_card = $_POST['m_card'];
        $discount = $_POST['discount'];
        $pay = $_POST['pay'];
        $vat7 = $_POST['vat7'];
        $vat3 = $_POST['vat3'];
        $sta_date = $_POST['sta_date'];
        $exp_date = $_POST['exp_date'];
        $fname = $_POST['fname'];
        $comment = $_POST['comment'];
        $order_id = $_POST['order_id'];
        $grandTotal = $_POST['grandTotal'];

        $grandTotal = round($grandTotal, 2);

        $sql = "UPDATE member SET discount = '$discount', pay = '$pay' , vat7 = '$vat7' , vat3 = '$vat3' , 
        sta_date = '$sta_date' , exp_date = '$exp_date' , fname = '$fname' , comment = '$comment' , total = '$grandTotal'  WHERE package = '$order_id' ";
        $stmt = $conndb->prepare($sql);
        if ( $stmt->execute()) {

            // อัปเดท ตาราง order
            $sqlOrder = $conndb->prepare("UPDATE `orders` SET `fname`= '$fname',`discount`= '$discount',`vat7`= '$vat7',
            `vat3`= '$vat3',`pay`='$pay',`sta_date`='$sta_date',`exp_date`='$exp_date',`comment`='$comment',`total`='$grandTotal' WHERE id = '$order_id'");
            if ($sqlOrder->execute()){
                header('location:cart/print/rePrintBil.php?id='.$order_id);
            }
        }

        // header("location:recordticket.php");
        $conndb = null;
    }

    // อัปเดทสินค้าและราคา
    if (isset($_POST['updateOrder'])) {
        $m_card = $_POST['m_card'];
        $discount = $_POST['discount'];
        $pay = $_POST['pay'];
        $dataSet = explode(',', $pay);
        $pay = $dataSet[0];
        $vat = $dataSet[1];

        if ( $vat == 3 ) {
            $vat3 = $dataSet[1];
        } elseif ( $vat == 7 ) {
            $vat7 = $dataSet[1];
        }
        
        $sta_date = $_POST['sta_date'];
        $exp_date = $_POST['exp_date'];
        $fname = $_POST['fname'];
        $comment = $_POST['comment'];
        $order_id = $_POST['order_id'];
        $grandTotal = $_POST['grandTotal'];
        $befortotal = $_POST['befortotal'];

        $grandTotal = round($grandTotal, 2);

        $sql = "UPDATE member SET discount = '$discount', pay = '$pay' , vat7 = '$vat7' , vat3 = '$vat3' , sta_date = '$sta_date' , exp_date = '$exp_date' , fname = '$fname' , comment = '$comment' , total = '$grandTotal'  
        WHERE package = '$order_id' ";
        $stmt = $conndb->prepare($sql);
        if ( $stmt->execute() == true) {
            $sqlOrder = $conndb->prepare("UPDATE `orders` 
            SET `fname`= '$fname',`discount`= '$discount',`price`= '$befortotal',`vat7`= '$vat7',`vat3`= '$vat3',`pay`='$pay',`sta_date`='$sta_date',`exp_date`='$exp_date',`comment`='$comment',`total`='$grandTotal' 
            WHERE id = '$order_id'");
            if ($sqlOrder->execute()){
                $conndb = null;
                $_SESSION['updateBil'] = true;
                header("location:recordticketEdit.php?id=".$order_id);
            }
        }
    }

    $conndb = null;
?>