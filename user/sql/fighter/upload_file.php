<?php
    session_start();
    require_once '../../../includes/connection.php';

    if (isset($_POST['submit'])) {

        echo '<pre>';
        print_r($_GET);
        print_r($_FILES);
        print_r($_POST);
        print_r($_SESSION);
        echo '</pre>';
        // exit;

        $id = $_POST['img_id'];

        foreach( $_FILES['upload']['tmp_name'] as $key => $tmp_name ){
            
            $file_names = $_FILES['upload']['name'];
            
            $extension = strtolower(pathinfo($file_names[$key], PATHINFO_EXTENSION));
           
            $supported = array('jpg', 'jpeg', 'png', 'gif');
            
            if( in_array($extension, $supported) ){
                
                $new_name = rand(0,microtime(true)).'.'.$extension;
                
                if(move_uploaded_file($_FILES['upload']['tmp_name'][$key], "../../../fighterimg/file/".$new_name)){

                    $sql_file = $conndb->prepare("INSERT INTO tb_files (image, product_id, created_at) VALUES ('$new_name','$id',NOW())");
                    $sql_file->execute();

                    $_SESSION['insert_files_success']= true;
                    header('location:../../fighter_profile.php?id='.$id); 
                }
            } else {
                echo '<script> alert("ไม่รองรับนามสกุลไฟล์นี้: '.$extension.'") </script>';
                header('LOCATION:../../fighter_profile.php?id='.$id);
                exit();
            }
        }
    }
?>