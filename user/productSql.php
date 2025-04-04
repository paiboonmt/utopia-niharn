<?php
    session_start();
    include('./middleware.php');
    include('../includes/connection.php');
    
    if ( isset($_POST['saveProduct'])) {

        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
        // exit;

        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $detail = $_POST['detail'];
        $code = $_POST['code'];

        try {
            $stmt = $conndb->prepare("INSERT INTO `products`(`product_name`, `price`, `detail`, `code` ) VALUES (?,?,?,?)");
            $stmt->bindParam(1,$product_name);
            $stmt->bindParam(2,$price);
            $stmt->bindParam(3,$detail);
            $stmt->bindParam(4,$code);
            $stmt->execute();
            $_SESSION['add'] =  true ;
            header('location:product.php');
        } catch (PDOException $e) {
            echo 'Process error' . $e->getMessage();
        }

    }

    if (isset($_GET['id'])){
        $id = $_GET['id'];
        try {
            $stmt = $conndb->prepare("DELETE FROM `products` WHERE id = ?");
            $stmt->bindParam(1,$id);
            $stmt->execute();
            $_SESSION['remove'] =  true ;
            header('location:product.php');
        } catch (PDOException $e) {
            echo 'Process error' . $e->getMessage();
        }
    }

    if (isset($_POST['updateProduct'])){
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
            header('location:product.php');
        } catch (PDOException $e) {
            echo 'Error in process'. $e->getMessage();
        }

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

    $conndb = null; // ปิดการเชื่อมต่อ

?>