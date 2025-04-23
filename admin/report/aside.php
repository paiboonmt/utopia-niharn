<?php
    require_once '../../includes/connection.php';
    $UserID = $_SESSION['UserID'];
    $pro = $conndb->query("SELECT * FROM `tb_user` WHERE id = $UserID");
    $pro->execute();
    $rows = $pro->fetchAll();

    function countTicket($conndb){
        $data = null;
        $stmt = $conndb->query("SELECT * FROM `member` WHERE `status` = 1 AND date(date)=curdate()");
        $stmt->execute();
        $data = $stmt->rowCount();
        return $data;
    }

    function countNew($conndb){
        $data = null;
        $stmt = $conndb->query("SELECT `id`,`m_card`,`sex`,`fname`,`birthday`,`age`,`invoice`,`nationalty`,`package`,`accom`,sta_date,exp_date,email,phone,AddBy,`image`,`date`,`status`,`comment`
        FROM `member`
        WHERE `group` = 'customer' AND `status` != '1' AND date(date)=curdate() ORDER BY date DESC");
        $stmt->execute();
        $data = $stmt->rowCount();
        return $data;
    }
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4" style="text-transform: uppercase;">
    <a href="index.php" class="brand-link">
        <img src="../../dist/img/logo.png" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">UTOPIA</span>
    </a>
    <div class="sidebar">
        <div class="user-panel py-2 d-flex">
            <div class="info">
                <a href="user.php" class="d-block" style="text-transform: uppercase;"><?= $rows[0]['username'] ?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" >


                <li class="nav-item">
                    <a href="../index.php" class="nav-link <?= $active ?>">
                    <i class="nav-icon fas fa-backward"></i>
                        <p>
                            ย้อนกลับ
                        </p>
                    </a>
                </li>

                <?php
                    if ($page == 'reportTicket') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                ?>

                <li class="nav-item">
                    <a href="reportTicket.php" class="nav-link <?= $active ?>">
                        <i class="far fa-circle nav-icon"></i>
                            <p>
                                รายงานการขายต
                            </p>
                    </a>
                </li>

                <?php
                    if ($page == 'searchreport') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                ?>

                <li class="nav-item">
                    <a href="searchreport.php" class="nav-link <?= $active ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            รายงานยอดขาย
                        </p>
                    </a>
                </li>

                <?php
                    if ($page == 'reportDay') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                ?>

                <li class="nav-item">
                    <a href="reportDay.php" class="nav-link <?= $active ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p> report check in </p>
                    </a>
                </li>

                <?php
                    if ($page == 'reportMonthly') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                ?>

                <li class="nav-item">
                    <a href="reportMonthly.php" class="nav-link <?= $active ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p> report monthly </p>
                    </a>
                </li>

                <?php
                    if ($page == 'reportBetway') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                ?>

                <li class="nav-item ">
                    <a href="reportBetway.php" class="nav-link <?= $active ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>report Betway </p>
                    </a>
                </li>

                <?php
                    if ($page == 'reportTotal') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                ?>

                <li class="nav-item ">
                    <a href="reportTotal.php" class="nav-link <?= $active ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Report Total </p>
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
                window.location.href = '../logout.php';
            }
        })
    }
</script>