<?php
  session_start();
  include './middleware.php';

  if (isset($_POST['insert'])){
    view();
    $m_card = $_POST['m_card'];
    $invoice = $_POST['invoice'];
    $p_visa = $_POST['p_visa'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sex = $_POST['sex'];
    $fname = $_POST['fname'];
    $nationalty = $_POST['nationalty'];
    $birthday = $_POST['birthday'];
    $package = $_POST['package'];
    $dropin = $_POST['dropin'];
    $payment = $_POST['payment'];
    $emergency = $_POST['emergency'];
    $accom = $_POST['accom'];
    $comment = $_POST['comment'];
    $sta_date = $_POST['sta_date'];
    $exp_date = $_POST['exp_date'];
    $AddBy = $_SESSION['username'];
    insertData($m_card,$invoice,$p_visa,$email,$phone,$sex,$fname,$nationalty,
    $birthday,$package,$dropin,$payment,$emergency,$accom,$comment,$sta_date,$exp_date,$AddBy);
  }

  function view() 
  {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    exit;
  }

  function insertData($m_card,$invoice,$p_visa,$email,$phone,$sex,$fname,$nationalty,$birthday,
  $package,$dropin,$payment,$emergency,$accom,$comment,$sta_date,$exp_date,$AddBy) 
  {
    $pay = '';
    $group = 'customer';
    $m_card = $m_card;
    $p_visa = $p_visa;
    $email = $email;
    $phone = $phone;
    $sex = $sex;
    $fname = $fname;
    $price = '';
    $pay = $pay;
    $fightname = '';
    $nationalty = $nationalty;
    $birthday = $birthday;
    $age = '';
    $discount = '';
    $vat7 = '';
    $vat3 = '';
    $total = '';
    $package = $package;
    $dropin = $dropin;
    $new_package = '';
    $height = '';
    $weigh = '';
    $accom = $accom;
    $payment = $payment;
    $invoice = $invoice;
    $vaccine = '';
    $comment = $comment;
    $emergency = $emergency;
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
    $status = 4 ;
    $AddBy = $AddBy;
    $code = 4 ;
    $status_code = 4;
    
    $image = $_FILES['image']['name']; 
    $tmp = explode('.',$_FILES['image']['name']);
    $newName = round(microtime(true)) .'.'. end($tmp);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'],'../memberimg/img/'.$newName)) {

      try {
          require_once("../includes/connection.php");
          $sql = "INSERT INTO `member`(`group`, `m_card`, `p_visa`, `email`, `phone`, `sex`, `fname`, `price`, `pay`, `fightname`, `nationalty`, `birthday`, `age`, `discount`, `vat7`, `vat3`, `total`, `package`, `dropin`, `new_package`, `height`, `weigh`, `accom`, `payment`, `invoice`, `vaccine`, `comment`, `emergency`, `sta_date`, `exp_date`, `expired`, `tenure`, `type_training`, `type_fighter`, `sponsored`, `commission`, `mealplan_month`, `affiliate`, `facebook`, `instagram`, `status`, `image`, `AddBy`, `code`, `status_code`,`date`) 
          VALUES ('$group','$m_card','$p_visa','$email','$phone','$sex','$fname','$price','$pay','$fightname', '$nationalty', '$birthday', '$age', '$discount', '$vat7', '$vat3', '$total', '$package', '$dropin', '$new_package', '$height', '$weigh', '$accom','$payment','$invoice','$vaccine', '$comment', '$emergency', '$sta_date', '$exp_date', '$expired', '$tenure', '$type_training', '$type_fighter', '$sponsored', '$commission', '$mealplan_month','$affiliate','$facebook', '$instagram', '$status', '$newName', '$AddBy', '$code', '$status_code' , current_timestamp())";
          $stmt = $conndb->prepare($sql);
          $stmt->execute();
          header('location:newmember.php');
          $conndb = null;
      } 
      catch (PDOException $e) {
          echo 'Process error'. $e->getMessage();
          $conndb = null;
      }
    }
  }
  $conndb = null;
?>