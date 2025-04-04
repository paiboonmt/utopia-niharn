<?php
    session_start();
    $servername = "localhost";
    $username = "admin";
    $password = "9itonly";
    $dbn = "member";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbn", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Connected successfully";

    } catch(PDOException $e) {

    echo "Connection failed: " . $e->getMessage();

    }

// อัปเดทรูปภาพโปรไฟส์ใหม่
    if (isset($_POST['update'])) {

        // รับมาจาก ฟอร์ม แก้ไข
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $dept = $_POST['dept'];
        $level = 'Admin';
        $status = '1';

        // ขั้นตอนอัปโหลดภาพเข้า server
        
        $img = $_FILES['img']['name'];
        $img2 = $_POST['img2'];

        $allow = array('jpg','jpeg','png');  

        $tmp = explode('.',$_FILES['img']['name']);

        $newName = round(microtime(true)).'.'.end($tmp);

        if (!empty($img)) {

            if (in_array($tmp[1],$allow)) {

                move_uploaded_file($_FILES['img']['tmp_name'],'../../../user/img/'.$newName);

                $stmt = $conn->prepare("SELECT img FROM tb_user WHERE id = :id");

                $stmt->bindParam(":id",$id);

                $stmt->execute();
                
                $numRow = $stmt->rowCount();
                
                echo $numRow;

                if ($numRow > 0) {

                    $result = $stmt->fetchAll();

                    $filename = $result[0];

                    $path = '../../../user/img/'.$filename[0];

                    @unlink($path);
                
                }

                try {
                    $sql = $conn->prepare("UPDATE `tb_user` SET `username`=:username,`password1`= :pass,`email`=:email,`dept`=:dept,`level`= :level,`status`= :status ,`img`= :img ,`update`= CURRENT_TIMESTAMP WHERE id = :id");
                    $sql->bindParam(":username",$username);
                    $sql->bindParam(":pass",$password);
                    $sql->bindParam(":email",$email);
                    $sql->bindParam(":dept",$dept);
                    $sql->bindParam(":level",$level);
                    $sql->bindParam(":status",$status);
                    $sql->bindParam(":img",$newName);
                    $sql->bindParam(":id",$id);
                    $sql->execute();

                    $_SESSION['update'] = true;
                    header("location:../../user.php");
                }catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }

            } else {
                $_SESSION['error'] = true;
                header("location:../../user.php");
            }

        } else {

            $newName = $img2;
            
            try {
                $sql = $conn->prepare("UPDATE `tb_user` SET `username`=:username,`password1`= :pass,`email`=:email,`dept`=:dept,`level`= :level,
                `status`= :status ,`img`= :img ,`update`= CURRENT_TIMESTAMP WHERE id = :id");
                $sql->bindParam(":username",$username);
                $sql->bindParam(":pass",$password);
                $sql->bindParam(":email",$email);
                $sql->bindParam(":dept",$dept);
                $sql->bindParam(":level",$level);
                $sql->bindParam(":status",$status);
                $sql->bindParam(":img",$newName);
                $sql->bindParam(":id",$id);
                $sql->execute();
                
                $_SESSION['update'] = true;
                
                header("location:../../user.php");

            }catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
    }

    $conn = null;
?>