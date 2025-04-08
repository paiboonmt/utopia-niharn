<?php
session_start();
include('../middleware.php');
include('../../includes/connection.php');

if (isset($_POST['insert'])) {
    $m_card = $_POST['m_card'];
    $invoice = $_POST['invoice'];
    $p_visa = $_POST['p_visa'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sex = $_POST['sex'];
    $fname = $_POST['fname'];
    $nationality = $_POST['nationality'];
    $birthday = $_POST['birthday'];
    $package = $_POST['package'];

    $dataPackage = explode("|", $package);
    $package = $dataPackage[0];
    $packageName = $dataPackage[1];

    $payment = $_POST['payment'];



    $emergency = $_POST['emergency'];
    $accom = $_POST['accom'];
    $comment = $_POST['comment'];
    $sta_date = $_POST['sta_date'];
    $exp_date = $_POST['exp_date'];
    $AddBy = $_SESSION['username'];

    // ตั้งชื่อไฟล์รูปภาพ
    $tmp = explode('.', $_FILES['image']['name']);
    $newName = round(microtime(true)) . '.' . end($tmp);
    $partForder = '../../memberimg/img/';

    // move_uploaded_file($_FILES['image']['tmp_name'], $partForder . $newName);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $partForder . $newName)) {
        insertData($conndb, $m_card, $invoice, $p_visa, $email, $phone, $sex, $fname, $nationality, $birthday, $packageName, $payment, $emergency, $accom, $comment, $sta_date, $exp_date, $AddBy, $newName);
        insertProductHistory($conndb, $m_card, $packageName, $sta_date, $exp_date, $AddBy);
        $conndb = null;
        header("Location: ../newmember.php");
    } else {
        $_SESSION['status'] = "Insert Failed: Image upload error";
    }
}

// Function to insert data into the database
function insertData($conndb, $m_card, $invoice, $p_visa, $email, $phone, $sex, $fname, $nationality, $birthday, $packageName, $payment, $emergency, $accom, $comment, $sta_date, $exp_date, $AddBy, $img_name)
{
    $sql = "INSERT INTO `customer`(`m_card`, `invoice`, `p_visa`, `email`, `phone`, `sex`, `fname`, `nationality`, `birthday`, `package`, `payment`, `emergency`, `accom`, `comment`, `sta_date`, `exp_date`, `user`, `image`, `timestamp`) 
        VALUES (:m_card, :invoice, :p_visa, :email, :phone, :sex, :fname, :nationality, :birthday, :package, :payment, :emergency, :accom, :comment, :sta_date, :exp_date, :user, :img , CURRENT_TIMESTAMP)";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':m_card', $m_card);
    $stmt->bindParam(':invoice', $invoice);
    $stmt->bindParam(':p_visa', $p_visa);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':sex', $sex);
    $stmt->bindParam(':fname', $fname);
    $stmt->bindParam(':nationality', $nationality);
    $stmt->bindParam(':birthday', $birthday);
    $stmt->bindParam(':package', $packageName);
    $stmt->bindParam(':payment', $payment);
    $stmt->bindParam(':emergency', $emergency);
    $stmt->bindParam(':accom', $accom);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':sta_date', $sta_date);
    $stmt->bindParam(':exp_date', $exp_date);
    $stmt->bindParam(':user', $AddBy);
    $stmt->bindParam(':img', $img_name);
    $stmt->execute();
    $conndb = null;
}

// insert data to product_history
function insertProductHistory($conndb, $m_card, $product_name, $sta_date, $exp_date, $AddBy)
{
    // `m_card`, `product_name`, `sta_date`, `exp_date`, `user`, `timestamp`
    $sql = "INSERT INTO `product_history`(`m_card`, `product_name`, `sta_date`, `exp_date`, `user`, `timestamp`) 
        VALUES (:m_card, :product_name, :sta_date, :exp_date, :user , CURRENT_TIMESTAMP)";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':m_card', $m_card);
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':sta_date', $sta_date);
    $stmt->bindParam(':exp_date', $exp_date);
    $stmt->bindParam(':user', $AddBy);
    $stmt->execute();
    $conndb = null;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    deleteData($conndb, $id);
    header("Location: ../newmember.php");
}

// Function to delete data from the database
function deleteData($conndb, $id)
{

    $sql = "SELECT image FROM customer WHERE id = :id";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $image = $stmt->fetchColumn();

    if ($image) {
        $imagePath = '../../memberimg/img/' . $image;
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file
        }
    }

    $sql = "DELETE FROM customer WHERE id = :id";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $conndb = null;
}


// Funtion upload file
if (isset($_POST['uploadFiles'])) {

    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    // echo '<pre>';
    // print_r($_FILES);
    // echo '</pre>';
    // echo '<pre>';
    // print_r($_SESSION);
    // echo '</pre>';
    

    $user = $_SESSION['username'];
    $m_card = $_POST['m_card']; // รับค่าจากฟอร์ม

    foreach ($_FILES['documents']['name'] as $key => $name) {
        $tmp = explode('.', $_FILES['documents']['name'][$key]);   
        $newName = round(microtime(true)) . '.' . end($tmp);
        $partForder = '../../memberimg/file/';

        if (move_uploaded_file($_FILES['documents']['tmp_name'][$key], $partForder . $newName)) {
                $sql = "INSERT INTO `tb_files`(`image_name`, `m_card`, `created_at`, `user`) 
                VALUES (:image_name , :m_card , NOW() ,:user)";
                $stmt = $conndb->prepare($sql);
                $stmt->bindParam(':image_name', $newName );
                $stmt->bindParam(':m_card', $m_card );
                $stmt->bindParam(':user', $user );
                header("Location: ../editmember.php");
        } else {
            $_SESSION['status'] = "Insert Failed: Image upload error";
        }
    }

}
