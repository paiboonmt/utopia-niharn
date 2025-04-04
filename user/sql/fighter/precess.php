<?php
    session_start();

    require_once '../../../includes/connection.php';

    // INSERT
    if (isset($_POST['insert'])) {

        echo '<pre>';
        print_r($_POST);
        print_r($_FILES);
        print_r($_SESSION);
        echo '</pre>';
        // exit();

        $AddBy = $_SESSION['username'];
        $group = $_POST['group'];
        $m_card = $_POST['m_card'];
        $p_visa = $_POST['p_visa'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $sex = $_POST['sex'];
        $fname = $_POST['fname'];
        $thi_name = '';
        $nick_name = '';
        $fightname = $_POST['fightname'];
        $nationalty = $_POST['nationalty'];
        $birthday = $_POST['birthday'];
        $age = '';
        $marital = '';
        $department = '';
        $occupation = '';
        $bank = '';
        $package = '';
        $dropin = 10 ;
        $new_package = '';
        $height = $_POST['height'];
        $weigh = $_POST['weigh'];
        $accom = $_POST['accom'];
        $payment = '';
        $invoice = '';
        $vaccine = $_POST['vaccine'];
        $comment = $_POST['comment'];
        $emergency = $_POST['emergency'];
        $sta_date = $_POST['sta_date'];
        $exp_date = $_POST['exp_date'];
        $expired = '';
        $tenure = $_POST['tenure'];
        $type_training = $_POST['type_training'];
        $type_fighter = $_POST['type_fighter'];
        $sponsored = $_POST['sponsored'];
        $commission = $_POST['commission'];
        $mealplan_month = $_POST['mealplan_month'];
        $affiliate = $_POST['affiliate'];
        $facebook = $_POST['facebook'];
        $instagram = $_POST['instagram'];
        $status = 'active';

        $Check = $conndb->prepare("SELECT * FROM `member` WHERE `m_card` = :a ");
        $Check->bindParam(':a', $m_card);
        $Check->execute();
        $num = $Check->rowCount();

            if ($num > 0) {
                $_SESSION['error_card'] = true;
                header('location:../../sponsor.php');
            } else {
                // เพื่มรูปภาพ
                $image = $_FILES['image']['name']; 
                $tmp = explode('.',$_FILES['image']['name']);
                $newName = round(microtime(true)) .'.'. end($tmp);

                if (move_uploaded_file($_FILES['image']['tmp_name'],'../../../fighterimg/img/'.$newName)){
                    
                    try {
                        $sql = $conndb->prepare("INSERT INTO `member`
                        (`group`,`m_card`,`p_visa`,`email`,`phone`,`sex`,`fname`,`thi_name`,`nick_name`,`fightname`,`nationalty`,
                        `birthday`,`age`,`marital`,`department`,`occupation`,`bank`,`package`,`dropin`,`new_package`,
                        `weigh`,`height`,`accom`,`payment`,`invoice`,`vaccine`,`comment`,`emergency`,`sta_date`,
                        `exp_date`,`expired`,`tenure`,`type_training`,`type_fighter`,`sponsored`,`commission`,`mealplan_month`,
                        `affiliate`,`facebook`,`instagram`,`status`,`image`,`AddBy`,`date`)
                    VALUES 
                        ('$group',
                        '$m_card','$p_visa','$email','$phone','$sex','$fname','$thi_name','$nick_name',
                        '$fightname','$nationalty','$birthday','$age','$marital','$department','$occupation','$bank','$package','$dropin',
                        '$new_package','$weigh','$height','$accom','$payment','$invoice','$vaccine','$comment','$emergency',
                        '$sta_date','$exp_date','$expired','$tenure','$type_training','$type_fighter','$sponsored','$commission',
                        '$mealplan_month','$affiliate','$facebook','$instagram','$status','$newName','$AddBy',current_timestamp())");  
                        $sql->execute();

                        $_SESSION['success_insert'] = true;
                        header('location:../../sponsor.php');

                    } catch (PDOException $e) {
                        echo "Error: ".$e->getMessage();
                    }   
                }
            }
        
        unset($_SESSION['card']);
        $conndb = null;  
    }

?>
