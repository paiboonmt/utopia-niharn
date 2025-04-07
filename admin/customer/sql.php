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
    $payment = $_POST['payment'];
    $emergency = $_POST['emergency'];
    $accom = $_POST['accom'];
    $comment = $_POST['comment'];
    $sta_date = $_POST['sta_date'];
    $exp_date = $_POST['exp_date'];
    $AddBy = $_SESSION['username'];

    // Validate the input data

    header("Location: ../newmember.php");
    exit();
}

// Function to insert data into the database
function insertData($conndb, $m_card, $invoice, $p_visa, $email, $phone, $sex, $fname, $nationality, $birthday, $package, $payment, $emergency, $accom, $comment, $sta_date, $exp_date, $AddBy)
{
    $sql = "INSERT INTO `customer`(`id`, `m_card`, `invoice`, `p_visa`, `email`, `phone`, `sex`, `fname`, `nationality`, `birthday`, `package`, `payment`, `emergency`, `accom`, `comment`, `sta_date`, `exp_date`, `user`, `timestamp`) 
        VALUES (NULL, :m_card, :invoice, :p_visa, :email, :phone, :sex, :fname, :nationality, :birthday, :package, :payment, :emergency, :accom, :comment, :sta_date, :exp_date, :user, CURRENT_TIMESTAMP)";
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
    $stmt->bindParam(':package', $package);
    $stmt->bindParam(':payment', $payment);
    $stmt->bindParam(':emergency', $emergency);
    $stmt->bindParam(':accom', $accom);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':sta_date', $sta_date);
    $stmt->bindParam(':exp_date', $exp_date);
    $stmt->bindParam(':user', $AddBy);
    $stmt->execute();
    $conndb = null;
}

function imgUpload($file, $path, $name)
{
    $target_dir = $path;
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $newFileName = $name . '.' . $imageFileType;
    move_uploaded_file($file["tmp_name"], $target_dir . $newFileName);
    return $newFileName;
    // Close the database connection
    $conndb = null;
    // Redirect to the new member page
    header("Location: ../newmember.php");
    exit();
}
