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

    // Retrieve the image name to delete the file from the server
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
    // print_r($_SESSION);
    // exit;


    $targetDir = "../../memberimg/file/";
    $allowedTypes = ["jpg", "jpeg", "png", "gif"];
    $fileCount = count($_FILES["documents"]["name"]);
    $user = $_SESSION['username']; // กำหนด user จาก session หรือกำหนดตรงนี้ก็ได้
    $m_card = $_POST['m_card']; // ใส่ค่าที่ต้องการ
    $dateNow = date("Y-m-d H:i:s");

    for ($i = 0; $i < $fileCount; $i++) {
        $fileName = basename($_FILES["documents"]["name"][$i]);
        $targetFile = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $tmpName = $_FILES["documents"]["tmp_name"][$i];
        $error = $_FILES["documents"]["error"][$i];
    
        if ($error === UPLOAD_ERR_OK && in_array($fileType, $allowedTypes)) {
            // บันทึกไฟล์ลงโฟลเดอร์
            if (move_uploaded_file($tmpName, $targetFile)) {
                // 🔹 3. บันทึกข้อมูลลงฐานข้อมูล
                $stmt = $conndb->prepare("INSERT INTO tb_files (image_name, m_card, created_at, user) VALUES (?, ?, ?, ?)");
                $stmt->bindParam("ssss", $fileName, $m_card, $dateNow, $user);
    
                if ($stmt->execute()) {
                    echo "✅ อัปโหลดและบันทึกแล้ว: $fileName<br>";
                } else {
                    echo "❌ บันทึกลงฐานข้อมูลล้มเหลว: $fileName<br>";
                }

            } else {
                echo "❌ ไม่สามารถอัปโหลดไฟล์: $fileName<br>";
            }
        } else {
            echo "⚠️ ไฟล์ไม่อนุญาตหรือเกิดข้อผิดพลาด: $fileName<br>";
        }
    }
    $conndb = null;
    header("Location: ../newmember.php?m_card=$m_card");
}
