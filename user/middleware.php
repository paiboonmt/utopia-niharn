<?php
    if ( $_SESSION['role'] != 'user' && $_SESSION['id'] == '') {
        header('location:../');
    }
?> 