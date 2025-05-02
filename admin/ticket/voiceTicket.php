<?php 
    
    include '../middleware.php';
    include './functionVoiceticket.php';

    if ( isset($_POST['voice']) ) {
        viewPost();
        include('../../includes/connection.php');

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
        $sta_date = $_POST['sta_date'];
        $exp_date = $_POST['exp_date'];
        $user = $_POST['user'];

        $setTotal = 0;

        if (insertVoice($conndb, $ref_order_id, $num_bill, $fname, $discount, $price, $vat7, $vat3, $pay, $sta_date, $exp_date, $comment, $total, $date, $hostname, $user)) {
            if (updateStatus($conndb, $ref_order_id)) {
                if (updateOrders($conndb, $order_id, $ref_order_id, $num_bill, $fname, $discount, $price, $vat7, $vat3, $pay, $sta_date, $exp_date, $comment, $setTotal, $date, $hostname, $user)) {
                    header('location:../recordticket.php');
                    exit();
                }
            } else {
                exit();
            }
        } else {
            exit();
        }

    }

?> 