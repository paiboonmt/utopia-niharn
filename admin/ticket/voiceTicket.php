<?php

include '../middleware.php';

if (isset($_POST['cancel_bill'])) {

    include '../../includes/connection.php';

    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    // exit;
    $order_id = $_POST['order_id'];
    $num_bill = $_POST['num_bill'];
    $fname = $_POST['fname'];
    $discount = $_POST['discount'];
    $price = $_POST['price'];
    $vat7 = $_POST['vat7'];
    $vat3 = $_POST['vat3'];
    $pay = $_POST['pay'];
    $sta_date = $_POST['sta_date'];
    $exp_date = $_POST['exp_date'];
    $comment = $_POST['comment'];
    $total = $_POST['total'];
    $date = $_POST['date'];
    $hostname = $_POST['hostname'];
    $emp = $_POST['emp'];
    $cancel_by = $_POST['cancel_by'];
    $cancel_reason = $_POST['cancel_reason'];
    $cancel_date = date('Y-m-d');
    $cancel_time = date('H:i:s');

    

    if (updateStatusOrder($conndb, $num_bill, $hostname, $emp) == true) {
        if (updateStatus($conndb, $num_bill) == true) {
            if ( deleteOrder_details($conndb, $order_id) == true ) {
                header('location:../recordticket.php');
            }
        }
        
    } else {
        echo 'updateStatusOrder' . 'ไม่ทำงาน';
    }
}


function updateStatus($conndb, $num_bill)
{
    $sql = "UPDATE `member` SET `status_code` = 5
    WHERE m_card = ? ";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(1, $num_bill);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $conndb = null;
}

function updateStatusOrder($conndb, $num_bill, $hostname, $emp)
{
    $sql = "UPDATE `orders` SET 
    `discount`= '0' , 
    `vat7` = '0' , 
    `vat3` = '0' , 
    `pay` = 'Canceled' , 
    `total` = '0' , 
    `hostname` = :hostname ,
    `emp`= :emp 
    WHERE ref_order_id = :ref_order_id ";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':hostname', $hostname);
    $stmt->bindParam(':emp', $emp);
    $stmt->bindParam(':ref_order_id', $num_bill);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $conndb = null;
}

function saveVoiceTicket($conndb, $order_id, $num_bill, $fname, $discount, $price, $vat7, $vat3, $pay, $sta_date, $exp_date, $comment, $total, $emp, $cancel_by, $cancel_reason, $cancel_date, $cancel_time)
{
    $stmt = $conndb->prepare("INSERT INTO voice (ref_order_id, num_bill, fname, discount, price, vat7, vat3, pay, sta_date, exp_date, comment, total, emp, cancel_by, cancel_reason, cancel_date, cancel_time) 
    VALUES (:order_id, :num_bill, :fname, :discount, :price, :vat7, :vat3, :pay, :sta_date, :exp_date, :comment, :total, :emp, :cancel_by, :cancel_reason, :cancel_date, :cancel_time)");
    $stmt->bindParam(':order_id', $order_id);
    $stmt->bindParam(':num_bill', $num_bill);
    $stmt->bindParam(':fname', $fname);
    $stmt->bindParam(':discount', $discount);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':vat7', $vat7);
    $stmt->bindParam(':vat3', $vat3);
    $stmt->bindParam(':pay', $pay);
    $stmt->bindParam(':sta_date', $sta_date);
    $stmt->bindParam(':exp_date', $exp_date);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':total', $total);
    $stmt->bindParam(':emp', $emp);
    $stmt->bindParam(':cancel_by', $cancel_by);
    $stmt->bindParam(':cancel_reason', $cancel_reason);
    $stmt->bindParam(':cancel_date', $cancel_date);
    $stmt->bindParam(':cancel_time', $cancel_time);
    if ($stmt->execute()) {
        header('Location:../recordticket.php');
        exit();
    } else {
        return false;
    }
    $conndb = null;
}

function deleteOrder_details($conndb, $order_id)
{
    $sql = "DELETE FROM `order_details` WHERE order_id = ? ";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(1, $order_id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $conndb = null;
}

