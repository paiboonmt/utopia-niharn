<?php 
    session_start();
    if (!empty($_GET['id'])) {
        unset($_SESSION['cart'][$_GET['id']]);
        $_SESSION['unsetItem'] = "remove item successflluly";
    }
    header("location:../shop.php");
?> 