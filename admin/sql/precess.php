<?php
    session_start();
    require_once '../../includes/connection.php';
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
        $fightname = '';
        $nationalty = $_POST['nationalty'];
        $birthday = $_POST['birthday'];
        $age = '';
        $marital = '';
        $department = '';
        $occupation = '';
        $bank = '';
        $package = $_POST['package'];
        $new_package = '';
        $height = $_POST['height'];
        $weigh = $_POST['weigh'];
        $accom = $_POST['accom'];
        $payment = $_POST['payment'];
        $invoice = $_POST['invoice'];
        $vaccine = $_POST['vaccine'];
        $comment = '';
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

                if (move_uploaded_file($_FILES['image']['tmp_name'],'../../memberimg/img/'.$newName)){
                    
                    $sql = $conndb->prepare("INSERT INTO `member`
                    (`group`,`m_card`,`p_visa`,`email`,`phone`,`sex`,`fname`,`thi_name`,`nick_name`,`fightname`,`nationalty`,
                    `birthday`,`age`,`marital`,`department`,`occupation`,`bank`,`package`,`new_package`,
                    `weigh`,`height`,`accom`,`payment`,`invoice`,`vaccine`,`comment`,`emergency`,`sta_date`,
                    `exp_date`,`expired`,`tenure`,`type_training`,`type_fighter`,`sponsored`,`commission`,`mealplan_month`,
                    `affiliate`,`facebook`,`instagram`,`status`,`image`,`AddBy`,`date`)
                    VALUES 
                    ('$group',
                    '$m_card','$p_visa','$email','$phone','$sex','$fname','$thi_name','$nick_name',
                    '$fightname','$nationalty','$birthday','$age','$marital','$department','$occupation','$bank','$package',
                    '$new_package','$height','$weigh','$accom','$payment','$invoice','$vaccine','$comment','$emergency',
                    '$sta_date','$exp_date','$expired','$tenure','$type_training','$type_fighter','$sponsored','$commission',
                    '$mealplan_month','$affiliate','$facebook','$instagram','$status','$newName','$AddBy',current_timestamp())");  

                    $sql->execute();
                    
                    if ($sql) {
                        $_SESSION['success_insert'] = true;
                        header('location:../newmember.php');
                    }else{
                        $_SESSION['error_insert'] = true;
                        header('location:../newmember.php');
                    }
                }
            }

        $conndb = null;  
    }
    // UPDATE
    if (isset($_POST['update'])) {
 
        $AddBy = $_SESSION['username'];//รับค่า USER_SESSION
        $m_card = $_POST['m_card'];
        $p_visa = $_POST['p_visa'];
        $sex = $_POST['sex'];
        $fname = $_POST['fname'];
        $height = $_POST['height'];
        $weigh = $_POST['weigh'];
        $nationalty = $_POST['nationalty'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $birthday = $_POST['birthday'];
        $accom = $_POST['accom'];
        $sta_date = $_POST['sta_date'];
        $exp_date = $_POST['exp_date'];
        $expired = $_POST['expired'];
        $package = $_POST['package'];
        $new_package = $_POST['new_package'];
        $payment = $_POST['payment'];
        $vaccine = $_POST['vaccine'];
        $comment = $_POST['comment'];
        $emergency = $_POST['emergency'];
        $invoice = $_POST['invoice'];

        echo '<pre>';
        print_r($_POST);
        print_r($_FILES);
        // print_r($_SESSION);
        echo '</pre>';
        // exit();


        $id = $_POST['id'];

        $image2 = $_POST['image2'];

        $image = $_FILES['image']['name']; 

        $tmp = explode('.',$_FILES['image']['name']);

        $newName = round(microtime(true)).'.'.end($tmp);

        if ($image!=''){

            move_uploaded_file($_FILES['image']['tmp_name'],'../../memberimg/img/'.$newName);

            $SQL_qdel = $conndb->prepare("SELECT image FROM member WHERE id = :id");
            $SQL_qdel->bindParam(":id",$id);
            $SQL_qdel->execute();
            $pro_image = $SQL_qdel->fetchAll();
            $filename = $pro_image[0][0];

            @unlink('../../memberimg/img/'.$filename);

            $_SESSION['update_success'] = true;

            header('location:../member_profile.php?id='.$id);

        }else {
            $newName = $image2;
        }
        
        try {
            $sql_query = $conndb->prepare("UPDATE `member` SET 
            `m_card`='$m_card',`p_visa`='$p_visa',
            `sex`='$sex',`fname`='$fname',
            `height`='$height',`weigh`='$weigh',
            `nationalty`='$nationalty',`email`='$email',
            `phone`='$phone',`birthday`='$birthday',
            `accom`='$accom',`sta_date`='$sta_date',
            `exp_date`='$exp_date',`expired`='$expired',
            `package`='$package',`new_package`='$new_package',
            `payment`='$payment',`vaccine`='$vaccine',
            `comment`='$comment',`emergency`='$emergency',
            `invoice`='$invoice',`image`='$newName',`AddBy`='$AddBy'
            WHERE id = :ff ");
            $sql_query->bindParam(":ff",$id);
            $sql_query->execute();
            $_SESSION['update_success'] = true;
            header('location:../member_profile.php?id='.$id);

        } catch(PDOException $e ){
            echo "Connection failed: " . $e->getMessage(); 
        }
        
        $conndb = null;
    }
    // DELETE FILES
    if(isset($_POST['del_file'])) {

        $id = $_POST['id'];
        $sql_data = $conndb->prepare("SELECT * FROM tb_files WHERE id = :dd");
        $sql_data->bindParam(":dd",$id);
        $sql_data->execute();
        $pro_image = $sql_data->fetchAll();

        $filename = $pro_image[0][1];

        print_r($fightname);

        @unlink('../../memberimg/file/'.$filename);

        $sql_del = $conndb->prepare("DELETE FROM `tb_files` WHERE id = $id");
        $sql_del->execute();

        $conndb = null;
        
    }
    // DELETE DATA ALL  
    if (isset($_GET['action']) == 'delete_id') {

        $id = $_GET['id'];

        $SQL_qdel = $conndb->prepare("SELECT image FROM member WHERE id = :id");
        $SQL_qdel->bindParam(":id",$id);
        $SQL_qdel->execute();
        $pro_image1 = $SQL_qdel->fetchAll();
        $filename1 = $pro_image1[0][0];

        @unlink('../../memberimg/img/'.$filename1);

        $sql_data = $conndb->prepare("SELECT `product_id` FROM `tb_files` WHERE `product_id` = :dd");
        $sql_data->bindParam(":dd",$id);
        $sql_data->execute();
        $pro_image2 = $sql_data->fetchAll();
        $filename2 = $pro_image2[0][0];

        @unlink('../../memberimg/file/'.$filename2);


        // exit;

        $DEL_ID_MEMBER = $conndb->prepare("DELETE FROM `member` WHERE `id` = $id");
        $DEL_ID_MEMBER->execute();

        $DEL_ID_FILES = $conndb->prepare("DELETE FROM `tb_files` WHERE product_id = $id");
        $DEL_ID_FILES->execute();

        $_SESSION['delete_id_success'] = true;

        header('location:../allmember.php');

   
    }
?>
