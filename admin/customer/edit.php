<?php

// view data
function getData($conndb, $m_card)
{
    $stmt = $conndb->prepare("SELECT * FROM customer WHERE m_card = :m_card");
    $stmt->bindParam(':m_card', $m_card);   
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getNationality($conndb)
{
    $stmt = $conndb->prepare("SELECT * FROM `tb_nationality`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProduct($conndb)
{
    $stmt = $conndb->prepare("SELECT * FROM `products`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPayment($conndb)
{
    $stmt = $conndb->prepare("SELECT * FROM `payment`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getHistory($conndb, $id)
{
    $stmt = $conndb->prepare("SELECT * FROM `product_history` WHERE m_card = :m_card ORDER BY id DESC");
    $stmt->bindParam(':m_card', $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function datediff($str_start, $str_end)
{
    $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
    $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
    $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
    $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที
    return $ndays;
}

function birthDay($birthday)
{

    // $today = date("Y-m-d");
    // $diff = strtotime($today) - strtotime($birthday);
    // $age = floor($diff / (365 * 60 * 60 * 24));
    // return $age;

    $birthday = $birthday;
    $today = date('Y-m-d');
    list($byear, $bmonth, $bday) = explode("-", $birthday);
    list($tyear, $tmonth, $tday) = explode("-", $today);

    $mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear);
    $mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear);
    $mage = ($mnow - $mbirthday);

    $age = date("Y", $mage) - 1970;
    return $age;
}
