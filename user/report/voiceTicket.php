<?php
    session_start();
    include('../middleware.php');
    include('../../includes/connection.php');
    
    if (isset($_GET['action']) == 'voice') {
        $id = $_GET['id'];
        try {
            $sql = "UPDATE `member` SET `status_code` = 5
            WHERE id = ? ";
            $stmt = $conndb->prepare($sql);
            $stmt->bindParam(1,$id);
            $stmt->execute();
            header('location:reportTicket.php');
        } catch (PDOException $e) {
            echo 'เกิดข้อผิดผลาดในการเรียกดูข้อมูล'. $e ;
        }
    }

    $conndb = null;
?> 