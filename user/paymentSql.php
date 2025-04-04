<?php 
    session_start();
    include("./middleware.php");
    include("../includes/connection.php");

    // add data
    function add($pay_name,$value){
        global $conndb;
        try {
            $sql = "INSERT INTO `payment`( `pay_name`, `value`) VALUES (?,?)";
            $stmt = $conndb->prepare($sql);
            $stmt->bindParam(1,$pay_name);
            $stmt->bindParam(2,$value);
            $stmt->execute();
            $_SESSION['add'] = true;
            header("location:payment.php");

        } catch (PDOException $e) {
           echo 'Error in sql'. $e;
        }
    }

    // update data
    function update($pay_id,$pay_name,$value){
        global $conndb;
        try {
            $sql = "UPDATE `payment` SET `pay_name`= ? ,`value`= ?  WHERE pay_id = ?";
            $stmt = $conndb->prepare($sql);
            $stmt->bindParam(1,$pay_name);
            $stmt->bindParam(2,$value);
            $stmt->bindParam(3,$pay_id);
            $stmt->execute();
            header("location:payment.php");
        } catch (PDOException $e) {
            echo 'Error in sql'. $e;
        }
    }

    // delete
    function delete($pay_id){
        global $conndb;
        try {
            $sql = "DELETE FROM `payment` WHERE pay_id = ?";
            $stmt = $conndb->prepare($sql);
            $stmt->bindParam(1,$pay_id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error in sql'. $e;
        }
    }

    if ( isset($_POST['add'])) {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        $pay_name = $_POST['pay_name'];
        $value = $_POST['value'];
        add($pay_name , $value);
    }

    // update
    if (isset($_POST['update'])) {
        $pay_name = $_POST['pay_name'];
        $value = $_POST['value'];
        $pay_id = $_POST['pay_id'];
        update($pay_id,$pay_name,$value); 
    }

    // delete
    if (isset($_POST['action']) == 'delete'){
        $pay_id = $_POST['id'];
        delete($pay_id);
    }

    $conndb = null;
?> 