<?php
    $servername = "147.50.228.22";
    $username = "tigersof_tiger_paiboon";
    $password = "P@iBoon!@#$9itonly";
    $dbname = "tigersof_niharn";

    date_default_timezone_set('Asia/Bangkok');
    try {
        $conndb = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conndb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>