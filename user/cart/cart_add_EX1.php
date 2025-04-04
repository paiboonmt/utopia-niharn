<?php 
    session_start();
    include('../middleware.php');


     if (isset($_POST['add_to_cart'])) 
     {
          viewData();
          if ( isset($_SESSION['cart'])) 
          {
               $session_array_id = array_column($_SESSION['cart'], 'id');
               
               if (!in_array($_GET['id'], $session_array_id))
               {
                    $session_array = array(
                         'id' => $_GET['id'],
                         'product_name' => $_POST['product_name'],
                         'price' => $_POST['price'],
                         'detail' => $_POST['detail'],
                         'quantity' => $_POST['quantity']
                    );
                    $_SESSION['cart'][] = $session_array;
               }
          }
          else
          {
               $session_array = array(
                    'id' => $_GET['id'],
                    'product_name' => $_POST['product_name'],
                    'price' => $_POST['price'],
                    'detail' => $_POST['detail'],
                    'quantity' => $_POST['quantity']
               );
               $_SESSION['cart'][] = $session_array;
          }
          header("location:../cart.php");
     }
     else
     {
          echo 'Not have item ';
     }

//     if (isset($_GET['id'])) {

//        if (!empty($_GET['cart'][$_GET['id']])) {
//             $_SESSION['cart'][$_GET['id']] = 1;

//        } else {
//             $_SESSION['cart'][$_GET['id']] ++;
//        }

//        $_SESSION['addCart'] = true;
//     } 
//     header("location:../cart.php");

     function viewData(){
          echo "<pre>";
          print_r($_POST);
          echo "</pre>";
     }
?> 

