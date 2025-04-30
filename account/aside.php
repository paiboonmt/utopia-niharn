<?php
    $UserID = $_SESSION['UserID'];
    $pro = $conndb->query("SELECT * FROM `tb_user` WHERE id = $UserID");
    $pro->execute();
    $rows = $pro->fetchAll();
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4" style="text-transform: uppercase;">
    <a href="recordTicket.php" class="brand-link">
        <img src="../dist/img/logo.png" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">TIGER | Utopia </span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" >

                <?php
                    if ($page == 'recordticket') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                ?>
                <li class="nav-item ">
                    <a href="recordTicket.php" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-print"></i>
                        <p> รายงานการขายประจำวัน </p>
                    </a>
                </li>

                <?php
                    if ($page == 'searchreport') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                ?>
                <li class="nav-item ">
                    <a href="./searchreport.php" class="nav-link <?= $active ?>">
                    <i class="nav-icon fas fa-print"></i>
                        <p> รายงานแบบเลือกวัน </p>
                    </a>
                </li>

              

                <li class="nav-item">
                    <a href="#" onclick="logout()" class="nav-link">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<script>
    function logout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to leave the program?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'logout.php';
            }
        })
    }
</script>