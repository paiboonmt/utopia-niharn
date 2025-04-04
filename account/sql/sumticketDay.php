<?php 
    // session_start();
    // include("../middleware.php");
    // require_once("../../includes/connection.php");

    // สรุปยอดขายประจำวัน
    function sumTicketDay( $date ,$conndb ) {
        try {
            $data = null;
            $sql = "SELECT `date` , SUM(total) AS sum FROM `orders` WHERE date LIKE '$date'";
            $stmt = $conndb->prepare($sql);
            $stmt->execute();
            $date = $stmt->fetchAll();
            return $data;
        } catch (PDOException $e ) {
            echo $e;
        }
    }

    //


?> 