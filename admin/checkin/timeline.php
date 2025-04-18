<?php
session_start();
include("../middleware.php");
date_default_timezone_set('Asia/Bangkok');
require_once("../../includes/connection.php");

function viewData($conndb, $id)
{
    $sql = "SELECT * FROM `tb_time`";
    $stmt = $conndb->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $result;
}