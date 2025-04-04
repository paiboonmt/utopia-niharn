<?php
    session_start();
    include('middleware.php');
    include('../includes/connection.php');
    
    if (isset($_GET['action']) == 'voice') {

        $id = $_GET['id'];

        $checkId = $conndb->prepare("SELECT * FROM `member` WHERE id = $id ");
        $checkId->execute();

        if ($checkId->rowCount() != 1 ) {
            $_SESSION['canotFind'] = true;
            header('location:recordticket.php');
            exit;
        } else {
            echo $checkId->rowCount();

            foreach ( $checkId AS $rowMember ) {
                echo $rowMember['m_card'];
                echo $rowMember['numbill'];
            }

            exit; 

            // บันทึกการ voice item
            $v = "INSERT INTO `voiceRecord`( `v_code`, `v_numbill`, `v_name`, `v_discount`, `v_price`, `v_vat7`, `v_vat3`, `v_pay`, `v_sta_date`, `v_exp_date`, `v_comment`, `total`, `v_date`, `v_hostname`, `v_emp`) 
            VALUES ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?";
            $p = $conndb->prepare($v);
            $p->bindParam(1, $v_code);
            $p->bindParam(2, $v_numbill);
            $p->bindParam(3, $v_name);
            $p->bindParam(4, $v_discount);
            $p->bindParam(5, $v_price);
            $p->bindParam(6, $v_vat7);
            $p->bindParam(7, $v_vat3);
            $p->bindParam(8, $v_pay);
            $p->bindParam(9, $v_sta_date);
            $p->bindParam(10, $v_exp_date);
            $p->bindParam(11, $v_comment);
            $p->bindParam(12, $total);
            $p->bindParam(13, $v_date);
            $p->bindParam(14, $v_hostname);
            $p->bindParam(15, $v_emp);
            $p->execute();
            
        }
        

        try {

            $sql = "UPDATE `member` SET `status_code` = 5
            WHERE id = ? ";
            $stmt = $conndb->prepare($sql);
            $stmt->bindParam(1,$id);
            $stmt->execute();
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $ref_order_id = $row["m_card"];
                $emp = $row["AddBy"];
            }
            updateOrders($conndb , $emp , $ref_order_id );
            header('location:recordticket.php');
        } catch (PDOException $e) {
            echo 'เกิดข้อผิดผลาดในการเรียกดูข้อมูล'. $e ;
        }
    }

    function Checkid ($conndb , $id ) {
        $data = null;
        $sql = 'SELECT * FROM `member` WHERE `id` = ? ';
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(1,$id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    function updateOrders( $conndb , $emp , $ref_order_id ) {
        try {
            $sql = "UPDATE `orders` SET `discount`= 0 ,`price`= 0 ,`vat7`= 0 ,`vat3`= 0 ,`pay`= 0 , 
            `total`= 0 , `emp`= ? WHERE ref_order_id = ? ";
            $stmt = $conndb->prepare($sql);
            $stmt->bindParam(2,$emp);
            $stmt->bindParam(3,$ref_order_id);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    $conndb = null;
