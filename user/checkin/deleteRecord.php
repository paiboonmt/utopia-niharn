<?php
    session_start();
    include('../middleware.php');
    if (isset($_GET['id'])) {
        include('../../includes/connection.php');
        try {
            $id = $_GET['id'];
            $stmt = $conndb->prepare("DELETE FROM `member` WHERE `id` = :id ");
            $stmt->bindParam(":id",$id);
            $stmt->execute();
            header('location:../recordticket.php');
            $conndb = null;
        } catch (PDOException $e) {
            echo "Process failed: " . $e->getMessage();
        }
    }

?>