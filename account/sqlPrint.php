<?php 

    $date = date('Y-m-d');
    $sqlCash = $conndb->query("SELECT * , SUM(total) AS sumtotal 
    FROM `orders` 
    WHERE `date` LIKE '%$date%' ");
    $sqlCash->execute();
    $fetchCash = $sqlCash->fetchAll();

?>