<?php 
    session_start();
    include('./middleware.php');

    if (!empty($_GET['id'])) {
        unset($_SESSION['cart'][$_GET['id']]);
        $_SESSION['unsetItem'] = "remove item successflluly";
    }
    header("location:../cart.php");
?> 