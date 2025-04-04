<?php
    session_start();
    require_once '../../../includes/connection.php';

    if (isset($_POST['update'])) {

        echo '<pre>';
        print_r($_POST);
        print_r($_SESSION);
        echo '</pre>';

        // exit ;

        $AddBy = $_SESSION['username'];

        $m_card = $_POST['m_card'];
        $invoice =$_POST['invoice'];
        $p_visa = $_POST['p_visa'];
        $sex = $_POST['sex'];
        $fname = $_POST['fname'];
        $height = '0' ;
        $weigh = '0' ;
        $nationalty = $_POST['nationalty'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $birthday = $_POST['birthday'];
        $accom = $_POST['accom'];
        $sta_date = $_POST['sta_date'];
        $exp_date = $_POST['exp_date'];
        $expired = $_POST['expired'];

        $package = $_POST['package'];

        $dropin = $_POST['dropin'];
        $new_package = $_POST['new_package'];
        $age = $_POST['age'];
        $payment = $_POST['payment'];
        $vaccine = '0';
        $comment = $_POST['comment'];
        $emergency = $_POST['emergency'];
        $status_code = 4;

        $id = $_POST['id'];

        $image2 = $_POST['image2'];

        $image = $_FILES['image']['name']; 

        $tmp = explode('.',$_FILES['image']['name']);

        $newName = round(microtime(true)).'.'.end($tmp);



        if ($image!='') {

            move_uploaded_file($_FILES['image']['tmp_name'],'../../../memberimg/img/'.$newName);

            $SQL_qdel = $conndb->prepare("SELECT image FROM member WHERE id = :id");
            $SQL_qdel->bindParam(":id",$id);
            $SQL_qdel->execute();
            $pro_image = $SQL_qdel->fetchAll();
            $filename = $pro_image[0][0];

            @unlink('../../../memberimg/img/'.$filename);

        }else {
            $newName = $image2;
        }
        
        try {
            $sql_query = $conndb->prepare("UPDATE `member` SET 
            `m_card`='$m_card',`p_visa`='$p_visa',
            `sex`='$sex',`fname`='$fname',
            `height`='$height',`weigh`='$weigh',
            `nationalty`='$nationalty',`email`='$email',
            `phone`='$phone',`birthday`='$birthday',`age`='$age',
            `accom`='$accom',`sta_date`='$sta_date',
            `exp_date`='$exp_date',`expired`='$expired',
            `package`='$package',`dropin`='$dropin',`new_package`='$new_package',
            `payment`='$payment',`vaccine`='$vaccine',
            `comment`='$comment',`emergency`='$emergency',`status_code`= '$status_code',
            `invoice`='$invoice',`image`='$newName',`AddBy`='$AddBy'
            WHERE id = :ff ");
            $sql_query->bindParam(":ff",$id);
            $sql_query->execute();

            $_SESSION['update_success'] = true;
           
            header('location:../../member_profile.php?id='.$id);

        } catch(PDOException $e ){
            // echo "Connection failed: " . $e->getMessage(); 
        }
        
        $conndb = null;
    }
?>