<?php
    session_start();
    
    if (isset($_POST['username']) && $_POST['password']) {

        $user = $_POST['username'];
        $password = $_POST['password'];
        $passwordmd5 = md5($password);

            include("./includes/connection.php");
            $stmt = $conndb->prepare("SELECT * FROM `tb_user` WHERE `username` = ? AND `password` = ? ");
            $stmt->bindParam(1 , $user , PDO::PARAM_STR);
            $stmt->bindParam(2 , $passwordmd5 , PDO::PARAM_STR);
            $stmt->execute();

            // echo $stmt->rowCount();
            // exit;

            if ($stmt->rowCount() == 1 ) {
                foreach ($stmt AS $row) {
                    $_SESSION['UserID'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['role'] = $row['role'];
                }
                if ( $_SESSION['role'] == 'user' )  {
                    header("location:user/");
                } elseif ( $_SESSION['role'] == 'account' )  {
                    header("location:account/recordTicket.php");
                } elseif ( $_SESSION['role'] == 'admin' ) {
                    header("location:admin/");
                }
                

            } else {
                header('location:../');
                unset($_SESSION);
                exit();
            }
       
    }
    else {
        header('location:./');
    }

    $conndb = null;

?> 