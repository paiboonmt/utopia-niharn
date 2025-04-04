<?php 
    include('../includes/connection.php');

    if (isset($_GET['action']) && $_GET['action'] == 'voice') {
        viewPost();
        $id = $_GET['id'];
        uodateData($id);
    }

    function uodateData($id){
        global $conndb;
        $stmt = $conndb->prepare("UPDATE `member` SET `total`= 0 ,`status_code`= 1  WHERE id = :id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        header('location:recordTicket.php');

    }

    function viewPost(){
        echo '<pre>';
        print_r($_GET);
        echo '</pre>';
    }

?> 