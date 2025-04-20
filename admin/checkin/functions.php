<?php

    // เช็คหมายเลขบัตรว่าอยู่ในฐานข้อมูลหรือไม่
    function checkNumberCard($conndb, $m_card)
    {
        $sql = "SELECT * FROM `group_type` WHERE `number` = ? ";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(1, $m_card);
        $stmt->execute();
        return $stmt->rowCount();
        $conndb = null;
    }

    // เช็คประเภทบัตร
    function checkType($conndb, $m_card)
    {
        $sql = "SELECT * FROM `group_type` WHERE `number` = ? ";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(1, $m_card);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result[0]['value'];
        $conndb = null;
    }

    // ดึงข้อมูลจากฐานข้อมูลCustomer
    function getDataCustomer($conndb, $m_card)
    {
        $sql = "SELECT * FROM `customer` WHERE `m_card` = :m_card";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':m_card', $m_card);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        $conndb = null;
    }

    // ดึงข้อมูลจากฐานข้อมูลOrder
    function getDataOrder($conndb, $m_card)
    {
        $sql = "SELECT * FROM `orders` WHERE `ref_order_id` = :m_card";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':m_card', $m_card);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        $conndb = null;
    }

    // เช็ควันหมดอายุ
    function exp_date($conndb, $m_card)
    {
        $sql = "SELECT `exp_date` FROM `customer` WHERE `m_card` = :m_card";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':m_card', $m_card);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result[0]['exp_date'];
        $conndb = null;
    }

    // เช็คจำนวนวันคงเหลือ
    function datediff($str_start, $str_end)
    {
        $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
        $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
        $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
        $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที
        return $ndays;
    }

    // เช็คประเภทไม่นับจำนวนครั้ง
    function checkProductType($conndb, $m_card)
    {
        $sql = "SELECT `product_type` FROM `customer` WHERE `m_card` = :m_card";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':m_card', $m_card);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['product_type'];
        $conndb = null;
    }

    // เช็คจำนวนครั้งที่เหลือ
    function checkProductValue($conndb, $m_card)
    {
        $sql = "SELECT `product_value` FROM `customer` WHERE `m_card` = :m_card";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':m_card', $m_card);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['product_value'];
        $conndb = null;
    }

    // เช็คจำนวนข้อมูลในตาราง totel ว่ามีข้อมูลหรือไม่
    function checkTotel($conndb)
    {
        $data = null;
        $stmt = $conndb->query("SELECT id FROM totel WHERE date(date) = CURDATE()");
        $stmt->execute();
        $data = $stmt->rowCount();
        return $data;
        $conndb =  null;
    }

    // นับจำนวนเช็คอินในวันนี้
    function checkInToday($conndb, $m_card)
    {
        $sql = "SELECT * FROM `tb_time` WHERE `ref_m_card` = :m_card AND date(date) = CURDATE()";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':m_card', $m_card);
        $stmt->execute();
        return $stmt->rowCount();
        $conndb = null;
    }

    // บันทึกเวลา
    function insertTime($conndb, $m_card, $group_type, $customer_name, $product, $exp_date)
    {
        $sql = "INSERT INTO `checkin`(`checkin_card_number`, `checkin_group_type`, `checkin_customer_name`, `checkin_product`, `checkin_time`, `checkin_expriy`) 
        VALUES (:m_card, :group_type, :customer_name, :product, current_timestamp(), :exp_date)";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':m_card', $m_card);
        $stmt->bindParam(':group_type', $group_type);
        $stmt->bindParam(':customer_name', $customer_name);
        $stmt->bindParam(':product', $product);
        $stmt->bindParam(':exp_date', $exp_date);
        $stmt->execute();
        return $stmt;
        $conndb = null;
    }

    // บันทึกข้อมูลการใช้บริการ
    function insetTotal($conndb)
    {
        $stmt = $conndb->prepare("INSERT INTO `totel` (`date`) VALUES (current_timestamp())");
        $stmt->execute();
        return $stmt;
        $conndb = null;
    }

    // กลับไปที่หน้าเช็คอิน
    function back_to_checkin()
    {
        header("Location: ../checkin.php");
        exit();
    }

