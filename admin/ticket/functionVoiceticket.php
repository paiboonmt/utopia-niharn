<?php

function viewdata()
{
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}
function deleteOder($conndb, $order_id)
{
    $sql = "DELETE FROM `orders` WHERE id = :id";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':id', $order_id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function updateOrders($conndb, $order_id, $ref_order_id, $num_bill, $fname, $discount, $price, $vat7, $vat3, $pay, $sta_date, $exp_date, $comment, $setTotal, $date, $hostname, $emp)
{
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
    $stmt->bindParam(':total', $setTotal);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':hostname', $hostname);
    $stmt->bindParam(':emp', $emp);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function updateStatus($conndb, $ref_order_id)
{
    $sql = "UPDATE `member` SET `status_code` = 5
        WHERE m_card = :ref_order_id ";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':ref_order_id', $ref_order_id);
    $stmt->execute();
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function insertVoice($conndb, $ref_order_id, $num_bill, $fname, $discount, $price, $vat7, $vat3, $pay, $sta_date, $exp_date, $comment, $total, $date, $hostname, $user)
{
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

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function viewPost()
{
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}
