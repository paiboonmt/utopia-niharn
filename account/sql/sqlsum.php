<?php 
    // กำหนด session
    session_start();
    // เรียกใช้งาน Middleware
    include("../middleware.php");
    // เรียกใช้งานเชื่อมต่อฐานข้อมูล
    require_once("../../includes/connection.php");





    // ฟังชั่น เรียกดูข้อมูลทั่วไป
    function viewSum($date){
        $stmt = null;
        global $conndb;
        $sql = "SELECT `id`,`package`, `m_card` , `fname` ,`AddBy` , `sta_date`, 
        `exp_date`, `date` , `total` ,`pay`,`vat7`,`vat3`,`discount`,`price`, `status_code`
        FROM `member`
        WHERE date(date) LIKE '$date'
        AND `status` = 1
        ORDER BY id DESC";
        $stmt = $conndb->query($sql);
        $stmt->execute();
        
        foreach ( $stmt AS $data ) {
            $datas = [
                'total' => $data['total']
            ];
        }
        return $datas;

        $conndb = null;
    }

?> 