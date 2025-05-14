<?php

include("../middleware.php");

if (isset($_POST['saveOrder'])) {
    require_once("../../includes/connection.php");

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    // exit;

    $num_bill = $_POST['num_bill'];
    $conNum_bill = intval($num_bill);
    $code = $_POST['code'];
    $price = $_POST['price'];
    $grandTotal = $_POST['grandTotal'];

    $payment = $_POST['pay'];;

    $dataSet = explode(',', $payment);

    $vat = $dataSet[1];

    if ($vat == 3) {
        $vat3 = $dataSet[1];
    } elseif ($vat == 7) {
        $vat7 = $dataSet[1];
    }

    $pay = $dataSet[0];

    $ref_order_id = $_POST['m_card'];
    $grandTotal = $_POST['grandTotal'];
    $AddBy = $_SESSION['username'];
    $sumPrice = $_POST['grandTotal'];


    $SQL = "INSERT INTO `shop_orders`(`ref_order_id`, `num_bill`, `price`, `pay`, `vat7`, `vat3`, `sub_vat`, `total`, `date`, `emp`) 
    VALUES ( '$ref_order_id','$num_bill','$price','$pay','$vat7','$vat3','$sub_vat','$grandTotal',current_timestamp(),'$AddBy')";
    $stmt = $conndb->prepare($SQL);

    if ($stmt->execute() == true) {

        $order_id = $conndb->lastInsertId("SELECT * FROM `shop_orders`");

        foreach ($_SESSION['cart'] as $productId => $productQty) {

            $product_name = $_POST['product'][$productId]['name'];
            $price = $_POST['product'][$productId]['price'];
            $total = $price * $productQty;

            $SQL = "INSERT INTO `shop_order_details`(`order_id`, `product_id`, `product_name`, `price`, `quantity`, `total`) 
                VALUES ('$order_id','$productId','$product_name','$price','$productQty','$total')";
            $STMT = $conndb->prepare($SQL);
            $STMT->execute();

            updateStore($conndb, $productId, $productQty);

        }

        $_SESSION['order_id'] = $order_id;
    }

    $package = $order_id;
    $sumPrice = $_POST['grandTotal'];

    $_SESSION['package'] = $package;
    $_SESSION['m_card'] = $m_card;
    $_SESSION['sta_date'] = $sta_date;
    $_SESSION['exp_date'] = $exp_date;
    $_SESSION['fname'] = $fname;
    $_SESSION['comment'] = $comment;
    $_SESSION['price'] = $price;
    $_SESSION['discountOraginal'] = $_POST['discount'];
    $_SESSION['discount'] = $discount;
    $_SESSION['pay'] = $pay;
    $_SESSION['AddBy'] = $AddBy;
    $_SESSION['code'] = $code;
    $_SESSION['vat7'] = $vat7;
    $_SESSION['vat3'] = $vat3;
    $_SESSION['grandTotal'] = $grandTotal;
    $_SESSION['num_bill'] = $num_bill;
    $_SESSION['detail'] = $detail;

    $_SESSION['cartSuccess'] = true;
    header("location: print/print.php");
    $conndb = null;
}

function insertVoiceItem($conndb, $order_id, $productId, $product_name, $price, $productQty, $total)
{
    $sql = "INSERT INTO `voice_order_details`(`order_id`, `product_id`, `product_name`, `price`, `quantity`, `total`, `date`) 
        VALUES ('$order_id','$productId', '$product_name', '$price', '$productQty', '$total' , current_timestamp() )";
    $stmt = $conndb->prepare($sql);
    $stmt->execute();
}

function dis($discount, $vat7, $vat3, $grandTotal)
{
    if ($discount != 0) {
        $discount = ($grandTotal * $discount) / 100;
        if ($vat7 != 0) {
            $vat7 = (($grandTotal - $discount) * $vat7) / 100;
            if ($vat3 != 0) {
                $vat3 = (($grandTotal - $discount + $vat7) * $vat3) / 100;
            }
        } else {
            if ($vat3 != 0) {
                $vat3 = (($grandTotal - $discount + $vat7) * $vat3) / 100;
            }
        }

        $grandTotal = $grandTotal - $discount +  $vat7  + $vat3;

        return $grandTotal;
    } else {
        if ($vat7 != 0) {
            $vat7 = ($grandTotal * $vat7) / 100;
            if ($vat3 != 0) {
                $vat3 = (($grandTotal  + $vat7) * $vat3) / 100;
            }
        } else {
            if ($vat3 != 0) {
                $vat3 = (($grandTotal  + $vat7) * $vat3) / 100;
            }
        }

        $grandTotal = $grandTotal  +  $vat7  + $vat3;
        return $grandTotal;
    }
}

function checkBill($conndb, int $num_bill)
{
    $sql = "SELECT * FROM `orders`WHERE `num_bill` = '{$num_bill}'";
    $stmt = $conndb->query($sql);

    if ($stmt->execute()) {
        if ($stmt->rowCount() == 0) {
            echo " stmt->rowCount() == 0";
        } elseif ($stmt->rowCount() > 1) {
            echo "stmt->rowCount() > 1";
            $num_bill += 1;
            echo $num_bill;
            return $num_bill;
            exit;
        }
    }
}

function insertGroup_type($conndb, $number)
{
    $sql = "INSERT INTO `group_type`(`number`,`type`, `value`) VALUES (:number,'pos','2')";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':number', $number);
    $stmt->execute();
    $conndb = null;
    return true;
}

function updateStore($conndb, $productId, $productQty)
{
    $sql = "UPDATE `store` SET `quantity` = `quantity` - :productQty WHERE id = :productId";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':productId', $productId);
    $stmt->bindParam(':productQty', $productQty);
    $stmt->execute();
    $conndb = null;
}

$conndb = null;
