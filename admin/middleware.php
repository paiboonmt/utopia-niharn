<?php
    if ( $_SESSION['role'] != 'admin' && $_SESSION['id'] == '') {
        header('location:../');
    }
?> 