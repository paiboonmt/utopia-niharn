<?php 
    session_start();
    include("../middleware.php");
    include("../../includes/connection.php");

    // add data
    function add($pay_name,$value){
        global $conndb;
        $sql = "INSERT INTO `payment`( `pay_name`, `value`) VALUES (?,?)";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(1,$pay_name,PDO::PARAM_STR);
        $stmt->bindParam(2,$value,PDO::PARAM_STR);
        $stmt->execute();
        $_SESSION['add'] = true;
        header("location:../payment.php");
        $conndb = null; 
    }

    // update data
    function update($pay_id,$pay_name,$value){
        global $conndb;
        $sql = "UPDATE `payment` SET `pay_name`= ? ,`value`= ?  WHERE pay_id = ?";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(1,$pay_name,PDO::PARAM_STR);
        $stmt->bindParam(2,$value,PDO::PARAM_STR);
        $stmt->bindParam(3,$pay_id,PDO::PARAM_INT);
        $stmt->execute();
        header("location:../payment.php");
        $conndb = null;
    }

    // delete
    function delete($pay_id){
        global $conndb;
        $sql = "DELETE FROM `payment` WHERE pay_id = ?";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(1,$pay_id);
        $stmt->execute();
        $conndb = null;
    }

    if ( isset($_POST['add'])) {
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