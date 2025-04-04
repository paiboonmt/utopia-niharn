<?php

    session_start();
    require_once '../../includes/connection.php';

    if (isset($_POST['modal_submit'])){
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        $m_card = $_POST['m_card'];

        $Check = $conndb->prepare("SELECT `m_card` FROM `member` WHERE `m_card` = :cc ");
        $Check->bindParam(':cc', $m_card);
        $Check->execute();
        $num = $Check->rowCount();

        if ($num > 0) {
            $_SESSION['valid'] = true ;
            $_SESSION['check_m_card'] = $m_card;
            header('location:../createmember.php');

        } else {
            $_SESSION['invalid'] = true ;
            $_SESSION['card'] = $m_card;
            header('location:../createmember.php');
        }
    }

    $conndb = null;

?>