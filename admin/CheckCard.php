<?php 
    if(isset($_POST) && !empty($_POST)){
         $m_card = $_POST['data'];
         require_once '../includes/connection.php';
         $stmt = $conndb->prepare("SELECT * FROM `customer` WHERE `m_card` = :m_card ");
         $stmt->bindParam(":m_card", $m_card );
         $stmt->execute();
         if ($row = $stmt->rowCount() == 1 ) {
            echo $row;
         } else {
            echo $row;
         }
         $conndb = null;
    }
?> 