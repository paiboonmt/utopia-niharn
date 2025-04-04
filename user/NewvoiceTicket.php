<?php
global $conndb;
session_start();
    include("./middleware.php");
    require_once("../includes/connection.php");
    
    if (isset($_POST['voice'])) {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        // exit;

        $sta_date = $_POST['sta_date'];
        $exp_date = $_POST['exp_date'];
        $comment = $_POST['comment'];
        $hostname = $_POST['hostname_'];
        $order_id = $_POST['order_id'];

        $ref_order_id = $_POST['ref_order_id'];
        $num_bill = $_POST['num_bill'];
        $fname = $_POST['fname'];
        $date = $_POST['date'];
        $price = $_POST['price'];
        $pay = $_POST['pay'];
        $discount = $_POST['discount'];
        $vat7 = $_POST['vat7'];
        $vat3 = $_POST['vat3'];
        $total = $_POST['total'];
        $voice = $_POST['voice'];
        $emp = $_POST['user'];

        $sql = "INSERT INTO `voice`(`ref_order_id`, `num_bill`, `fname`, `discount`, `price`, `vat7`, `vat3`, `pay`, `sta_date`, `exp_date`, `comment`, `total`, `date`, `hostname`, `emp`) 
        VALUES ('$ref_order_id','$num_bill','$fname','$discount','$price','$vat7','$vat3','$pay','$sta_date','$exp_date','$comment','$total','$date','$hostname','$emp')";
        $stmt = $conndb->prepare($sql);

        if ( $stmt->execute()) {

            if (updateStatus( $conndb , $ref_order_id ) == true){
                if (saveOrderDetail( $conndb , $order_id ) == true ) {
                    if (updateOrders( $conndb , $emp , $ref_order_id ,$price) == true) {
                        if (deleteOder( $conndb , $order_id ) == true ){
                            header('location:recordticket.php');
                        }else{
                            echo 'deleteOder'.'ไม่ทำงาน';
                        }
                    }else{
                        echo 'updateOrders'.'ไม่ทำงาน';
                    }
                }else{
                    echo 'saveOrderDetail'.'ไม่ทำงาน';
                }
            }else{
                echo 'updateStatus'.'ไม่ทำงาน';
            }

        } else {
            $_SESSION['error'] = true;
        }
    }

    function deleteOder( $conndb , $order_id ) {
        $status = false;
        $sql = "DELETE FROM `order_details` WHERE order_id = ? ";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam( 1 , $order_id );
        $stmt->execute();
        return $status = true;
    }

    function updateOrders( $conndb , $emp , $ref_order_id ,$price) {
        $status = false;
        $sql = "UPDATE `orders` 
        SET `discount`= 0 ,`price`= ? ,`vat7`= 0 ,`vat3`= 0 ,`pay`= 'Canceled' , `total`= 0 , `emp`= ? 
        WHERE ref_order_id = ? ";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(1,$price);
        $stmt->bindParam(2,$emp);
        $stmt->bindParam(3,$ref_order_id);
        $stmt->execute();
        return $status = true;
    }

    function updateStatus( $conndb , $ref_order_id ) {
        $status = false;
        $sql = "UPDATE `member` SET `status_code` = 5
        WHERE m_card = ? ";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam( 1 , $ref_order_id );
        $stmt->execute();
        return $status = true;
    }

    function saveOrderDetail( $conndb , $order_id ){
        $status = false;
        $sql = "DELETE FROM `voice_order_details` WHERE `order_id` = ? ";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam( 1 , $order_id );
        return $status = true;
    }

    $conndb = null;

?> 