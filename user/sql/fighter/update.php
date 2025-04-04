<?php
    session_start();
    require_once '../../../includes/connection.php';
if (isset($_POST['update'])) {

    echo '<pre>';
    print_r($_SESSION);
    print_r($_POST);
    print_r($_FILES);
    echo '</pre>';
    // exit;


    $group = $_POST['group'];
    $m_card = $_POST['m_card'];
    $status = $_POST['status'];
    $p_visa = $_POST['p_visa'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $nationalty = $_POST['nationalty'];
    $sex = $_POST['sex'];
    $fname = $_POST['fname'];
    $birthday = $_POST['birthday'];
    $height = $_POST['height'];
    $weigh = $_POST['weigh'];
    $fightname = $_POST['fightname'];
    $vaccine = $_POST['vaccine'];
    $accom = $_POST['accom'];
    $comment = $_POST['comment'];
    $emergency = $_POST['emergency'];
    $tenure = $_POST['tenure'];
    $type_training = $_POST['type_training'];
    $type_fighter = $_POST['type_fighter'];
    $sponsored = $_POST['sponsored'];
    $commission = $_POST['commission'];
    $affiliate = $_POST['affiliate'];
    $mealplan_month = $_POST['mealplan_month'];
    $sta_date = $_POST['sta_date'];
    $exp_date = $_POST['exp_date'];
    $facebook = $_POST['facebook'];
    $instagram = $_POST['instagram'];

    $id = $_POST['id'];

    $image2 = $_POST['image2'];

    $image = $_FILES['image']['name']; 

    $tmp = explode('.',$_FILES['image']['name']);

    $newName = round(microtime(true)).'.'.end($tmp);

    if ($image!=''){

        move_uploaded_file($_FILES['image']['tmp_name'],'../../../fighterimg/img/'.$newName);

        $SQL_qdel = $conndb->prepare("SELECT image FROM member WHERE id = :id");
        $SQL_qdel->bindParam(":id",$id);
        $SQL_qdel->execute();
        $pro_image = $SQL_qdel->fetchAll();
        $filename = $pro_image[0][0];

        @unlink('../../../fighterimg/img/'.$filename);

        $_SESSION['update_success'] = true;

        header('location:../../fighter_profile.php?id='.$id);

    }else {
        $newName = $image2;
    }
    try {
        $sql_query = $conndb->prepare("UPDATE `member` SET 
            `group`='$group',
            `m_card`='$m_card',
            `p_visa`='$p_visa',
            `email`='$email',
            `phone`='$phone',
            `sex`='$sex',
            `fname`='$fname',
            `fightname`='$fightname',
            `nationalty`='$nationalty',
            `birthday`='$birthday',
            `height`='$height',
            `weigh`='$weigh',
            `accom`='$accom',
            `vaccine`='$vaccine',
            `comment`='$comment',
            `emergency`='$emergency',
            `sta_date`='$sta_date',
            `exp_date`='$exp_date',
            `tenure`='$tenure',
            `type_training`='$type_training',
            `type_fighter`='$type_fighter',
            `sponsored`='$sponsored',
            `commission`='$commission',
            `mealplan_month`='$mealplan_month',
            `affiliate`='$affiliate',
            `facebook`='$facebook',
            `instagram`='$instagram',
            `status`='$status',
            `image`='$newName',
            `AddBy`='$AddBy'
        WHERE id = :ff ");

        $sql_query->bindParam(":ff",$id);

        $sql_query->execute();

        $_SESSION['update_success'] = true;

        header('location:../../fighter_profile.php?id='.$id);

    } catch(PDOException $e ){

        echo "Connection failed: " . $e->getMessage(); 

    }
    
    $conndb = null;
}

?>