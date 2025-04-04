<?php 
    session_start();
    include('../middleware.php');
    unset($_SESSION['cart']);
    $_SESSION['message'] = "remove item successflluly";
    header("location:../cart.php");
?> 