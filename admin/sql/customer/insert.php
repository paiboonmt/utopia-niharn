<?php
    session_start();

    require_once '../../../includes/connection.php';

    if (isset($_POST['insert'])) {
        $AddBy = $_SESSION['username'];
        $group = $_POST['group'];
        $m_card = $_POST['m_card'];
        $p_visa = $_POST['p_visa'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $sex = $_POST['sex'];
        $fname = $_POST['fname'];
        $price = '';
        $pay = '';
        $fightname = '';
        $nationalty = $_POST['nationalty'];
        $birthday = $_POST['birthday'];
        $age = '';
        $marital = '';
        $department = '';
        $occupation = '';
        $bank = '';
        $package = $_POST['package'];
        $dropin = $_POST['dropin'];
        $new_package = '';
        $height = $_POST['height'];
        $weigh = $_POST['weigh'];
        $accom = $_POST['accom'];
        $payment = $_POST['payment'];
        $invoice = $_POST['invoice'];
        $vaccine = $_POST['vaccine'];
        $comment = $_POST['comment'];
        $emergency = $_POST['emergency'];
        $sta_date = $_POST['sta_date'];
        $exp_date = $_POST['exp_date'];
        $expired = '';
        $tenure = '';
        $type_training = '';
        $type_fighter = '';
        $sponsored = '';
        $commission = '';
        $mealplan_month = '';
        $affiliate = '';
        $facebook = '';
        $instagram = '';
        $status = '';

        $Check = $conndb->prepare("SELECT * FROM `member` WHERE `m_card` = :a ");
        $Check->bindParam(':a', $m_card);
        $Check->execute();
        $num = $Check->rowCount();

            if ($num > 0) {
                $_SESSION['error_card'] = true;
                header('location:../createmember.php');
            } else {
                // เพื่มรูปภาพ
                $image = $_FILES['image']['name']; 
                $tmp = explode('.',$_FILES['image']['name']);
                $newName = round(microtime(true)) .'.'. end($tmp);

                if (move_uploaded_file($_FILES['image']['tmp_name'],'../../../memberimg/img/'.$newName)){
                    
                    $sql = $conndb->prepare("INSERT INTO `member`
                    (`group`,`m_card`,`p_visa`,`email`,`phone`,`sex`,`fname`,`price`,`pay`,`fightname`,`nationalty`,
                    `birthday`,`age`,`marital`,`department`,`occupation`,`bank`,`package`,`dropin`,`new_package`,
                    `weigh`,`height`,`accom`,`payment`,`invoice`,`vaccine`,`comment`,`emergency`,`sta_date`,
                    `exp_date`,`expired`,`tenure`,`type_training`,`type_fighter`,`sponsored`,`commission`,`mealplan_month`,
                    `affiliate`,`facebook`,`instagram`,`status`,`image`,`AddBy`,`date`)
                    VALUES 
                    ('$group',
                    '$m_card','$p_visa','$email','$phone','$sex','$fname','$price','$pay',
                    '$fightname','$nationalty','$birthday','$age','$marital','$department','$occupation','$bank','$package','$dropin',
                    '$new_package','$height','$weigh','$accom','$payment','$invoice','$vaccine','$comment','$emergency',
                    '$sta_date','$exp_date','$expired','$tenure','$type_training','$type_fighter','$sponsored','$commission',
                    '$mealplan_month','$affiliate','$facebook','$instagram','$status','$newName','$AddBy',current_timestamp())");  

                    $sql->execute();
                    
                    $_SESSION['success_insert'] = true;
                    unset($_SESSION['card']);
                    header('location:../../newmember.php');

                }
            }

        $conndb = null; 

    }
?>