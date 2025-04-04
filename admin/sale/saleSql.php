<?php
    header("Access-Control-Allow-Origin:*");
    header("Content-type:application/json; chatset=utf-8");
    session_start();
    include("./middleware.php");

    function insertData( $package , $m_card , $sta_date , $exp_date ,  $price , $discount , $pay,  $fname , $comment , $AddBy ,$code ,$vat7 , $vat3 , $total) {
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
        $price = $price;
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
        $status_code = 0;
        
        // เพื่มการ์ด day pass
        try {
            require_once("../includes/connection.php");
            $sql = "INSERT INTO `member`(`group`, `m_card`, `p_visa`, `email`, `phone`, `sex`, `fname`, `price`, `pay`, `fightname`, `nationalty`, `birthday`, `age`, `discount`, `vat7`, `vat3`, `total`, `package`, `dropin`, `new_package`, `height`, `weigh`, `accom`, `payment`, `invoice`, `vaccine`, `comment`, `emergency`, `sta_date`, `exp_date`, `expired`, `tenure`, `type_training`, `type_fighter`, `sponsored`, `commission`, `mealplan_month`, `affiliate`, `facebook`, `instagram`, `status`, `image`, `AddBy`, `code`, `status_code` , `date`) 
            VALUES ('$group','$m_card','$p_visa','$email','$phone','$sex','$fname','$price','$pay','$fightname', '$nationalty', '$birthday', '$age', '$discount', '$vat7', '$vat3', '$total', '$package', '$dropin', '$new_package', '$height', '$weigh', '$accom','$payment','$invoice','$vaccine', '$comment', '$emergency', '$sta_date', '$exp_date', '$expired', '$tenure', '$type_training', '$type_fighter', '$sponsored', '$commission', '$mealplan_month','$affiliate','$facebook', '$instagram', '$status', '$image', '$AddBy', '$code' , '$status_code' , current_timestamp())";
            $stmt = $conndb->prepare($sql);

            if ($stmt->execute()){

                $_SESSION['package'] = $package; 
                $_SESSION['m_card'] = $m_card; 
                $_SESSION['sta_date'] = $sta_date; 
                $_SESSION['exp_date'] = $exp_date; 
                $_SESSION['fname'] = $fname; 
                $_SESSION['comment'] = $comment; 
                $_SESSION['price'] = $price; 
                $_SESSION['discount'] = $discount; 
                $_SESSION['pay'] = $pay; 
                $_SESSION['AddBy'] = $AddBy; 
                $_SESSION['code'] = $code;
                $_SESSION['vat7'] = $vat7;
                $_SESSION['vat3'] = $vat3;
                $_SESSION['code'] = $code;

                header('location:salePrint.php');
                // header('location:sale.php');
                $conndb = null;
            }
        } catch (PDOException $e) {
            echo 'Process error'. $e->getMessage();
            $conndb = null;
        }
    }

    if (isset($_POST['actionSale'])) {
        $package = $_POST['package'];
        $code = $_POST['code'];
        $m_card = $_POST['m_card'];
        $sta_date = $_POST['date_start'];
        $exp_date = $_POST['date_expri'];
        $price = $_POST['price'];
        $vat7 = $_POST['vat7'];
        $vat3 = $_POST['vat3'];
        $discount = $_POST['discount'];
        $pay = $_POST['pay'];
        $fname = $_POST['fname'];
        $comment = $_POST['comment'];
        $AddBy = $_SESSION['username'];

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
     
        insertData( $package, $m_card , $sta_date , $exp_date , $price , $discount , $pay , $fname , $comment ,$AddBy,$code , $vat7 , $vat3 , $total );
    }
?>
