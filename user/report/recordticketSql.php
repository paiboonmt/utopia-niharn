<?php
    session_start();
    include('../middleware.php');
    require_once("../../includes/connection.php");

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

        if ($stmt->execute()){
            header("location:recordticketEdit.php?id=".$order_id);
        } else {

        }


        $conndb = null;
    }

    //แก้ไขข้อมูลสินค้าภายในบิล
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

    // แก้ไขบ้อมูล
    if (isset($_POST['updateTicket'])) {

       

        $package = $_POST['package'];
        $m_card = $_POST['m_card'];
        $date_start = $_POST['date_start'];
        $date_expri = $_POST['date_expri'];
        $price = $_POST['price'];
        $discount = $_POST['discount'];
        $vat7 = $_POST['vat7'];
        $vat3 = $_POST['vat3'];
        $pay = $_POST['pay'];
        $fname = $_POST['fname'];
        $comment = $_POST['comment'];

        if ($discount == '0' ) {

            if ($vat7 != '0' ) {
                $vat700 = ($price * $vat7 ) / 100 ;
                $price00 = $price + $vat700;
                if ( $vat3 != '0') {
                    $vat300 = ($price00 * $vat3)/100; 
                    $price00 = $price00 + $vat300;
                    $total = $price00;
                } else {
                    $total = $price00;
                }
            } else {
                if ( $vat3 != '0') {
                    $vat300 = ($price * $vat3)/100; 
                    $price00 = $price + $vat300;
                    $total = $price00;
                } else {
                    $total = $price;
                }
            }
            echo $total;
            // exit;
        } else {

            $discoun00 = ($price * $discount)/100;

            $price00 = $price - $discoun00;
            
            if ($vat7 != '0' ) {

                $vat700 = ($price00 * $vat7 ) / 100 ;

                $price00 = $price00 + $vat700;

                if ( $vat3 != '0') {

                    $vat300 = ($price00 * $vat3)/100; 

                    $price00 = $price00 + $vat300;

                    $total = $price00;

                } else {

                    $total = $price00;

                }

            } else {

                if ( $vat3 != '0') {

                    $vat300 = ($price00 * $vat3)/100; 

                    $price00 = $price00 + $vat300;

                    $total = $price00;

                } else {

                    $total = $price00;

                }
            }
        }

        update($package,$m_card,$date_start,$date_expri,$price,$discount,$vat7,$vat3,$pay,$fname,$comment,$total);
    }

    // ลบข้อมูล
    if ( isset($_GET['act']) == 'delete' && $_GET['id'] != '' ) {
        echo '<pre>';
        print_r($_GET);
        echo '</pre>';

        // [id] => 4
        // [pro_id] => 13
        // [act] => deleteItemBill
        // exit;
  
        $id = $_GET['id'];
        $pro_id = $_GET['pro_id'];

       try {
           
            $sqlOrders = $conndb->prepare("DELETE FROM `orders` WHERE id = '$id' ");
            if ($sqlOrders->execute()){
                $sqlOrderDetails = $conndb->prepare("DELETE FROM `order_details` WHERE `order_id` = '$id' ");
                $sqlOrderDetails->execute();
                header('location:recordticketEdit.php?id='.$id);
                $conndb = null;
            }
            
       } catch (PDOException $e) {
            echo 'error'. $e->getMessage();
       }
    }

    if (isset($_POST['saveUpdateOrder'])){
        // view();

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

        // อัปเดท ตาราง order
        $sqlOrder = $conndb->prepare("UPDATE `orders` SET `fname`= '$fname',`discount`= '$discount',`vat7`= '$vat7',
        `vat3`= '$vat3',`pay`='$pay',`sta_date`='$sta_date',`exp_date`='$exp_date',`comment`='$comment',`total`='$grandTotal' WHERE id = '$order_id'");
        if ($sqlOrder->execute()){
            header('location:print/rePrintBil.php?id='.$order_id);
        }

        $conndb = null;
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
        $order_id = $_POST['order_id'];
        $grandTotal = $_POST['grandTotal'];
        $befortotal = $_POST['befortotal'];

        $grandTotal = round($grandTotal, 2);
    
        $sql = "UPDATE member SET discount = '$discount', pay = '$pay' , vat7 = '$vat7' , 
        vat3 = '$vat3' , sta_date = '$sta_date' , exp_date = '$exp_date' , 
        fname = '$fname' , comment = '$comment' , total = '$grandTotal'  
        WHERE package = '$order_id' ";
        $stmt = $conndb->prepare($sql);
        if ( $stmt->execute()) {

            // อัปเดท ตาราง order
            $sqlOrder = $conndb->prepare("UPDATE `orders` 
            SET `fname`= '$fname',`discount`= '$discount',`price`= '$befortotal',`vat7`= '$vat7',`vat3`= '$vat3',`pay`='$pay',`sta_date`='$sta_date',`exp_date`='$exp_date',`comment`='$comment',`total`='$grandTotal' 
            WHERE id = '$order_id'");
            if ($sqlOrder->execute()){
                $_SESSION['updateBil'] = true;
                header("location:recordticketEdit.php?id=".$order_id);
            }
        }
        $conndb = null;
    }


    function dis( $discount , $vat7 , $vat3 , $grandTotal ){
        if ($discount != 0) {
            $discount = ( $grandTotal * $discount ) / 100 ; 
            if ($vat7 != 0) {
                $vat7 = ( ( $grandTotal - $discount ) * $vat7 ) / 100 ;
                if ($vat3 != 0) {
                    $vat3 = ( ( $grandTotal - $discount + $vat7 ) * $vat3 ) / 100 ;
                }
            } else {
                if ($vat3 != 0) {
                    $vat3 = ( ( $grandTotal - $discount + $vat7 ) * $vat3 ) / 100 ;
                }
            }
        
            $grandTotal = $grandTotal - $discount +  $vat7  + $vat3;

            return $grandTotal;
        } else {
            if ($vat7 != 0) {
                $vat7 = ( $grandTotal * $vat7 ) / 100 ;
                if ($vat3 != 0) {
                    $vat3 = ( ( $grandTotal  + $vat7 ) * $vat3 ) / 100 ;
                }
            } else {
                if ($vat3 != 0) {
                    $vat3 = ( ( $grandTotal  + $vat7 ) * $vat3 ) / 100 ;
                }
            }
            
            $grandTotal = $grandTotal  +  $vat7  + $vat3;
            return $grandTotal;
        }
    }

    function update( $conndb, $package , $m_card , $date_start , $date_expri , $price , $discount , $vat7 , $vat3 , $pay , $fname , $comment ,$total) {
       
        try {
            $stmt = $conndb->prepare("UPDATE `member` SET `package`='$package',`sta_date`='$date_start',`exp_date`='$date_expri',`price`='$price',`discount`='$discount',`vat7`='$vat7',`vat3`='$vat3',`pay`='$pay',`fname`='$fname',`comment`='$comment',`total`='$total' WHERE `m_card` = '$m_card'");
            $stmt->execute();
            $_SESSION['code'] = $m_card;
            header('location:recordticket.php');
            $conndb = null;
        } catch (PDOException $e) {
           echo 'Process error' . $e->getMessage();
        }

    }

    function view(){
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        exit;
    }

    $conndb = null;
?>