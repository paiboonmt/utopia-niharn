<?php
    session_start();
    require_once '../../../includes/connection.php';
    // INSERT

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
   
?>
