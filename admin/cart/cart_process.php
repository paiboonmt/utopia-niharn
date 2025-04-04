<?php 

    session_start();

    include("../middleware.php");

    require_once("../../includes/connection.php");
  
   
    if (isset($_POST['saveOrder'])) {

        $detail = $_POST['detail'];

        $hostname = $_POST['hostname'];

        $num_bill = $_POST['num_bill'];

        $conNum_bill = intval($num_bill);

        $converBill = $hostname .'-'. $conNum_bill ; // แปลงค่าไปบันทึกในตาราง Orders

        $code = $_POST['code'];

        $price = $_POST['price'];

        $discount = $_POST['discount'];

        $pay = $_POST['pay'];

        $vat7 = $_POST['vat7'];

        $vat3 = $_POST['vat3'];

        $sta_date = $_POST['sta_date'];

        $exp_date = $_POST['exp_date'];

        $fname = $_POST['fname'];

        $comment = $_POST['comment'];

        $m_card = $_POST['m_card'];
        $grandTotal = $_POST['grandTotal'];
        $AddBy = $_SESSION['username'];
        $sumPrice = $_POST['grandTotal'];
        $set = dis($discount,$vat7,$vat3,$grandTotal);

        $c_status_code = 1;
   
        $sqlMcard = $conndb->query("SELECT m_card FROM member WHERE m_card = '$m_card'");
        $sqlMcard->execute();

        if ( $sqlMcard->rowCount() > 0) {
            echo $sqlMcard->rowCount();
            $_SESSION['carderror'] = true;
            header('location:../cart.php');
            exit;
        }
       
        $sql1 = "INSERT INTO `orders`(`ref_order_id`, `num_bill` , `fname`, `discount`, `price`, `vat7`, `vat3`, `pay`, `sta_date`, 
        `exp_date`, `comment`, `total` , `date` , `hostname` , `emp`) 
        VALUES ('$m_card','$num_bill', '$fname','$discount','$sumPrice','$vat7','$vat3','$pay','$sta_date','$exp_date',
        '$comment','$set',current_timestamp() , '$converBill' , '$AddBy')";

        $stmt1 = $conndb->prepare($sql1);

        if ($stmt1->execute()) {

            $order_id = $conndb->lastInsertId("SELECT * FROM `orders`");

            foreach ( $_SESSION['cart'] as $productId => $productQty) {

                $product_name = $_POST['product'][$productId]['name'];
                $price = $_POST['product'][$productId]['price'];
                $total = $price * $productQty;

                $sql2 = "INSERT INTO `order_details`(`order_id`, `product_id`, `product_name`, `price`, `quantity`, `total`) 
                VALUES ('$order_id','$productId','$product_name','$price','$productQty','$total')";
                $stmt2 = $conndb->prepare($sql2);
                $stmt2->execute();

                insertVoiceItem( $conndb , $order_id, $productId , $product_name, $price, $productQty , $total);
            }

            $_SESSION['order_id'] = $order_id;
          
        }

        $package = $order_id;
        $sumPrice = $_POST['grandTotal'];
        insertData( $package , $m_card , $sta_date , $exp_date , $sumPrice , $discount , $pay , $fname , $comment , 
        $AddBy , $code , $vat7 , $vat3 , $total , $grandTotal ,$num_bill , $detail);

    }

    function insertVoiceItem( $conndb , $order_id, $productId, $product_name, $price, $productQty , $total) {
        $sql = "INSERT INTO `voice_order_details`(`order_id`, `product_id`, `product_name`, `price`, `quantity`, `total`, `date`) 
        VALUES ('$order_id','$productId', '$product_name', '$price', '$productQty', '$total' , current_timestamp() )";
        $stmt = $conndb->prepare($sql);
        $stmt->execute();
    }

    function insertData( $package , $m_card , $sta_date , $exp_date ,  $sumPrice , $discount , $pay,  
        $fname , $comment , $AddBy ,$code ,$vat7 , $vat3 , $total ,$grandTotal , $num_bill , $detail ) {
        $detail = $detail;
        $num_bill = $num_bill;
        $vat7 = $vat7;
        $vat3 = $vat3;
        $code = $code;
        $group = 'customer';
        $m_card = $m_card;
        $p_visa = '';
        $email = '';
        $phone = '';
        $sex = '';
        $fname = $fname;
        $price = $sumPrice;
        $pay = $pay;
        $fightname = '';
        $nationalty = '';
        $birthday = '';
        $age = '';
        $discount = $discount;
        $total = $total;
        $package = $package;
        $dropin = 0;
        $new_package = '';
        $height = '';
        $weigh = '';
        $accom = '';
        $payment = '';
        $invoice = '';
        $vaccine = '';
        $comment = $comment;
        $emergency = '';
        $sta_date = $sta_date;
        $exp_date = $exp_date;
        $expired ='';
        $tenure = '';
        $type_training = '';
        $type_fighter = '';
        $sponsored = '';
        $commission = '';
        $mealplan_month = '';
        $affiliate = '';
        $facebook = '';
        $instagram = '';
        $status = 1 ;
        $image = '55556666664444.png';
        $AddBy = $AddBy;
        $status_code = 1;
        $grandTotal = $grandTotal;

        if ($discount != 0)  {
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
        } else {
            if ($vat7 != 0) 
            {
                $vat7 = ( $grandTotal * $vat7 ) / 100 ;
                if ($vat3 != 0) 
                {
                    $vat3 = ( ( $grandTotal  + $vat7 ) * $vat3 ) / 100 ;
                }
            } 
            else 
            {
                if ($vat3 != 0) 
                {
                    $vat3 = ( ( $grandTotal  + $vat7 ) * $vat3 ) / 100 ;
                }
            }
            
            $grandTotal = $grandTotal  +  $vat7  + $vat3;
        }
        
        // เพื่มการ์ด day pass
        try {
            global $conndb;
            $sql = "INSERT INTO `member`(`group`, `m_card`, `p_visa`, `email`, `phone`, `sex`, `fname`, 
            `price`, `pay`, `fightname`, `nationalty`, `birthday`, `age`, `discount`, `vat7`, `vat3`, `total`, 
            `package`, `dropin`, `new_package`, `height`, `weigh`, `accom`, `payment`, `invoice`, `vaccine`, `comment`, 
            `emergency`, `sta_date`, `exp_date`, `expired`, `tenure`, `type_training`, `type_fighter`, `sponsored`, `commission`, 
            `mealplan_month`, `affiliate`, `facebook`, `instagram`, `status`, `image`, `AddBy`, `code`, `status_code` , `date`) 
            VALUES ('$group','$m_card','$p_visa','$email','$phone','$sex','$fname','$price','$pay','$fightname', 
            '$nationalty', '$birthday', '$age', '$discount', '$vat7', '$vat3', '$grandTotal', '$package', '$dropin', 
            '$new_package', '$height', '$weigh', '$accom','$payment','$invoice','$vaccine', '$comment', '$emergency', 
            '$sta_date', '$exp_date', '$expired', '$tenure', '$type_training', '$type_fighter', '$sponsored', '$commission', 
            '$mealplan_month','$affiliate','$facebook', '$instagram', '$status', '$image', '$AddBy', '$code' , '$status_code' , 
            current_timestamp())";
            $stmt = $conndb->prepare($sql);

            if ($stmt->execute()) {   
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

        } catch (PDOException $e) {
            
            echo 'Process error'. $e->getMessage();
            $conndb = null;

        }
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

    function viewData(){
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit;
    }

    function checkBill (int $num_bill) {
        global $conndb;
        $sql = "SELECT * FROM `orders`WHERE `num_bill` = '{$num_bill}'";
        $stmt = $conndb->query($sql);

        if ($stmt->execute())
        {
            if ( $stmt->rowCount() == 0 ) 
            {
                echo " stmt->rowCount() == 0";
                
            }
            elseif ( $stmt->rowCount() > 1)
            {
                echo "stmt->rowCount() > 1";
                $num_bill += 1;
                echo $num_bill;
                return $num_bill;
                exit;
            }
        } 

    }

    $conndb = null;
?> 

