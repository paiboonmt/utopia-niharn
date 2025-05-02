<?php 
    
    include '../middleware.php';

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
                echo "Voice ticket and status updated successfully.";
                if (updateOrders($conndb, $order_id, $ref_order_id, $num_bill, $fname, $discount, $price, $vat7, $vat3, $pay, $sta_date, $exp_date, $comment, $setTotal, $date, $hostname, $user)) {
                    echo "Orders updated successfully.";
                    header('location:../recordticket.php');
                   
                } else {
                    echo "Failed to update orders.";
                }
            } else {
                echo "Voice ticket inserted, but failed to update status.";
            }
        } else {
            echo "Failed to insert voice ticket.";
        }

    }

    function deleteOder($conndb, $order_id) {
        $sql = "DELETE FROM `orders` WHERE id = :id";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':id', $order_id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    

    function updateOrders($conndb, $order_id, $ref_order_id, $num_bill, $fname, $discount, $price, $vat7, $vat3, $pay, $sta_date, $exp_date, $comment, $setTotal, $date, $hostname, $emp) {
        $sql = "UPDATE `orders` 
                SET `ref_order_id` = :ref_order_id, 
                    `num_bill` = :num_bill, 
                    `fname` = :fname, 
                    `discount` = :discount, 
                    `price` = :price, 
                    `vat7` = :vat7, 
                    `vat3` = :vat3, 
                    `pay` = :pay, 
                    `sta_date` = :sta_date, 
                    `exp_date` = :exp_date, 
                    `comment` = :comment, 
                    `total` = :total, 
                    `date` = :date, 
                    `hostname` = :hostname, 
                    `emp` = :emp 
                WHERE `id` = :id";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':id', $order_id);
        $stmt->bindParam(':ref_order_id', $ref_order_id);
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
        $stmt->bindParam(':total', $setTotal );
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':hostname', $hostname);
        $stmt->bindParam(':emp', $emp);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function updateStatus( $conndb , $ref_order_id ) {
        $sql = "UPDATE `member` SET `status_code` = 5
        WHERE m_card = :ref_order_id ";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam( ':ref_order_id' , $ref_order_id );
        $stmt->execute();
        if ( $stmt->execute() ) {
            return true;
        } else {
            return false;
        }
    }

    function insertVoice($conndb,$ref_order_id,$num_bill,$fname,$discount,$price,$vat7,$vat3,$pay,$sta_date,$exp_date,$comment,$total,$date,$hostname,$user){
        $sql = "INSERT INTO `voice`(`ref_order_id`, `num_bill`, `fname`, `discount`, `price`, `vat7`, `vat3`, `pay`, `sta_date`, `exp_date`, `comment`, `total`, `date`, `hostname`, `emp`) 
        VALUES (:ref_order_id, :num_bill, :fname, :discount, :price, :vat7, :vat3, :pay, :sta_date, :exp_date, :comment, :total, :date, :hostname, :user)";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':ref_order_id', $ref_order_id);
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
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':hostname', $hostname);
        $stmt->bindParam(':user', $user);

        if ( $stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    function viewPost(){
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
    }

?> 