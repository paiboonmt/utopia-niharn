<?php
session_start();

if (isset($_GET['id'])) {

    if (!empty($_GET['cart'][$_GET['id']])) {

        $_SESSION['cart'][$_GET['id']] = 1;
    } else {

        $_SESSION['cart'][$_GET['id']] += 1;
    }

    $_SESSION['addCart'] = true;
}

header("location:../shop.php");
