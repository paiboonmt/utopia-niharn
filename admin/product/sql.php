<?php
    session_start();
    include('../middleware.php');
    include('../../includes/connection.php');
    
    // add product
    if ( isset($_POST['saveProduct'])) {

        $product_name = $_POST['product_name']; // ชื่อสินค้า
        $price = $_POST['price']; // ราคา
        $value = $_POST['value']; // จำนวนครั้ง

        $stmt = $conndb->prepare("INSERT INTO `products`(`product_name`, `price`,`value`) VALUES (?,?,?)"); // สร้างคำสั่ง SQL
        // bindParam() ใช้ในการผูกค่าตัวแปรกับคำสั่ง SQL
        $stmt->bindParam(1,$product_name, PDO::PARAM_STR); // ชื่อสินค้า
        $stmt->bindParam(2, $price, PDO::PARAM_STR); // ราคา
        $stmt->bindParam(3, $value, PDO::PARAM_STR); // จำนวนครั้ง

        $stmt->execute(); // ประมวลผลคำสั่ง SQL
        $_SESSION['add'] =  true ; // สร้าง session เพื่อใช้ในการแสดงผล
        header('location:../product.php'); // เปลี่ยนหน้าไปยัง product.php
        $conndb = null; // ปิดการเชื่อมต่อ  
    }

        // update product
        if (isset($_POST['updateProduct'])){
            $id = $_POST['id'];
            $product_name = $_POST['product_name'];
            $price = $_POST['price'];
            $stmt = $conndb->prepare("UPDATE `products` SET `product_name`= ? ,`price`= ?  WHERE id = ?");
            $stmt->bindParam(1,$product_name, PDO::PARAM_STR);
            $stmt->bindParam(2,$price, PDO::PARAM_STR);
            $stmt->bindParam(3,$id, PDO::PARAM_INT);
            $stmt->execute();
            $_SESSION['update'] =  true ;
            header('location:../product.php');
            $conndb = null; // ปิดการเชื่อมต่อ
        }
        
    // delete product
    if (isset($_POST['action']) == 'delete'){
        $id = $_POST['id'];
        $stmt = $conndb->prepare("DELETE FROM `products` WHERE id = ?");
        $stmt->bindParam(1,$id, PDO::PARAM_INT);
        $stmt->execute();
        $conndb = null; // ปิดการเชื่อมต่อ
    }

    if (isset($_POST['updateCartproduct'])){
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $detail = $_POST['detail'];
        $id = $_POST['id'];
        try {
            $stmt = $conndb->prepare("UPDATE `products` SET `product_name`= ? ,`price`= ? ,`detail`= ? WHERE id = ?");
            $stmt->bindParam(1,$product_name);
            $stmt->bindParam(2,$price);
            $stmt->bindParam(3,$detail);
            $stmt->bindParam(4,$id);
            $stmt->execute();
            $_SESSION['update'] =  true ;
            header('location:cart.php');
        } catch (PDOException $e) {
            echo 'Error in process'. $e->getMessage();
        }
    }

    if ( isset($_POST['UpdatePrice'])) {

        $id = $_POST['id'];
        $price = $_POST['price'];

        try {
            $stmt = $conndb->prepare("UPDATE `products` SET `price`= ?  WHERE id = ? ");
            $stmt->bindParam(1,$price);
            $stmt->bindParam(2,$id);
            $stmt->execute();
            $_SESSION['updatePrice'] =  true ;
            header('location:cart.php');
        } catch (PDOException $e) {
            echo 'Error in process'. $e->getMessage();
        }


    }

    function view(){
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        exit;
    }

    $conndb = null; // ปิดการเชื่อมต่อ

?>

