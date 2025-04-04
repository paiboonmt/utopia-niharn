<?php

    session_start();
    
    require_once '../../../includes/connection.php';

    if (isset($_POST['del_id'])) {

        $id = $_POST['id'];

        $SQL_qdel = $conndb->prepare("SELECT image FROM member WHERE id = :id");
        $SQL_qdel->bindParam(":id",$id);
        $SQL_qdel->execute();
        $pro_image1 = $SQL_qdel->fetchAll();
        $filename1 = $pro_image1[0][0];

        @unlink('../../../fighterimg/img/'.$filename1);

        $sql_data = $conndb->prepare("SELECT * FROM `tb_files` WHERE `product_id` = :dd");
        $sql_data->bindParam(":dd",$id);
        $sql_data->execute();
        $pro_image2 = $sql_data->fetchAll();

        foreach ($pro_image2 as $de_file ){

            @unlink('../../../fighterimg/file/'.$de_file['image']);
        }

        $DEL_ID_MEMBER = $conndb->prepare("DELETE FROM `member` WHERE `id` = $id");
        $DEL_ID_MEMBER->execute();

        $DEL_ID_FILES = $conndb->prepare("DELETE FROM `tb_files` WHERE product_id = $id");
        $DEL_ID_FILES->execute();

    }

    $conndb = null;

?>