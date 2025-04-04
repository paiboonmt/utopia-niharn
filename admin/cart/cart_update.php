<?php
    session_start();
    // echo "<pre>";
    // print_r($_GET);
    // print_r($_SESSION['cart']);
    // var_dump($_SESSION['cart']);
    // echo "</pre>";
    // $id = $_GET['id'];

    // ฟังก์ชันสำหรับอัปเดตจำนวนสินค้าในตะกร้า
    // if(isset($_SESSION['cart'][$id])) {
    //     // อัปเดตจำนวนสินค้า
    //     print_r($_SESSION['cart'][$id]);
    //     $_SESSION['cart'][$id]['quantity'] = $quantity;
    // }

   if (isset($_GET['id']) && $_GET['action'] == 'updatecart')  {
   
      if (!empty($_GET['cart'][$_GET['id']])) {

         $_SESSION['cart'][$_GET['id']] = 1;

      } else {

         $_SESSION['cart'][$_GET['id']] += 1;

      }

      $_SESSION['addCart'] = true;
      
      header("location:../cart.php");
   } 

   if (isset($_GET['id']) && $_GET['action'] == 'delete' ) {

      if (!empty($_GET['cart'][$_GET['id']])) {

         $_SESSION['cart'][$_GET['id']] = 1;

      } else {

         $_SESSION['cart'][$_GET['id']] -= 1;

      }

      $_SESSION['addCart'] = true;
      
      header("location:../cart.php");
   }
   


