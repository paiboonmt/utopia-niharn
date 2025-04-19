<?php

    function customCheckDate( $conndb, $m_card ) {
        $sql = "SELECT `exp_date` FROM `member` WHERE `m_card` = :m_card";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':m_card', $m_card);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $exp_date = $result['exp_date'];
            $today = date('Y-m-d');
            $diff = (strtotime($exp_date) - strtotime($today)) / 86400; // Calculate difference in days
            return $diff >= 0 ? $diff : -1; // Return days remaining or -1 if expired
        } else {
            return -1; // Card not found
        }
    }


    // 3490097436