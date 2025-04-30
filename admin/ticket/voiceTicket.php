<?php 
    
    include '../middleware.php';

    if ( isset($_POST['voice']) ) {
        viewPost();
    }

    if (isset($_GET['action']) && $_GET['action'] == 'voice') {
        include('../includes/connection.php');


        
        // $id = $_GET['id'];
        // uodateData($conndb,$id);
    }

    function uodateData($conndb,$id){
        $stmt = $conndb->prepare("UPDATE `member` SET `total`= 0 ,`status_code`= 1  WHERE id = :id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        header('location:recordticket.php');

    }

    function viewPost(){
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
    }

?> 