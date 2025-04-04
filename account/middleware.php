<?php
    if ( $_SESSION['role'] != 'account' && $_SESSION['id'] == '') {
        header('location:../');
    }
?> 