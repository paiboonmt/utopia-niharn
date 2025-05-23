<?php
require_once '../../includes/connection.php';
$UserID = $_SESSION['UserID'];
$pro = $conndb->query("SELECT * FROM `tb_user` WHERE id = $UserID");
$pro->execute();
$rows = $pro->fetchAll();

function countTicket($conndb)
{
    $data = null;
    $stmt = $conndb->query("SELECT * FROM `member` WHERE `status` = 1 AND date(date)=curdate()");
    $stmt->execute();
    $data = $stmt->rowCount();
    return $data;
}

function countNew($conndb)
{
    $data = null;
    $stmt = $conndb->query("SELECT *
        FROM `member`
        WHERE `group` = 'customer' AND `status` != '1' AND date(date)=curdate() ORDER BY date DESC");
    $stmt->execute();
    $data = $stmt->rowCount();
    return $data;
}
?>

<style>
    .nav-link {
        font-size: 14px;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="text-transform: uppercase;">
    <a href="index.php" class="brand-link">
        <img src="../../dist/img/logo.png" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">รายงาน</span>
    </a>
    <div class="sidebar">
        <div class="user-panel py-2 d-flex">
            <div class="info">
                <a href="user.php" class="d-block" style="text-transform: uppercase;">ผู้ใช้งาน : <?= $rows[0]['username'] ?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="../index.php" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-backward"></i>
                        <p>
                            ย้อนกลับ
                        </p>
                    </a>
                </li>


                <li class="nav-header">รายงานการขาย Class Training</li>

                <li class="nav-item">
                    <?php
                    if ($page == 'searchreport') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    ?>
                    <a href="searchreport.php" class="nav-link <?= $active ?>">
                        <i class="far fa-star nav-icon"></i>
                        <p>
                            สรุปการขายแบบรวม
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <?php
                    if ($page == 'reportTicket') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    ?>
                    <a href="reportTicket.php" class="nav-link <?= $active ?>">
                        <i class="far fa-star nav-icon"></i>
                        <p>
                            สรุปการขายแบบรายการ
                        </p>
                    </a>
                </li>

                <li class="nav-header">รายงานการขาย สินค้า อุปกรณ์</li>

                <li class="nav-item">
                    <?php
                    if ($page == 'shop_total') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    ?>
                    <a href="shop_total.php" class="nav-link <?= $active ?>">
                        <i class="fas fa-store nav-icon"></i>
                        <p>
                            สรุปการขายแบบรวม ร้านค้า
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <?php
                    if ($page == 'reportShop') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    ?>
                    <a href="reportShop.php" class="nav-link <?= $active ?>">
                        <i class="fas fa-shopping-cart nav-icon"></i>
                        <p>
                            ยอดขายสินค้า
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
                        <p>
                            การเข้าใช้บริการ
                        </p>
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
                        <p>
                            การขายรายเดือน
                        </p>
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
                        <p>
                            การขายระหว่างวันที่
                        </p>
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
                        <p>
                            จำนวนการเข้าใช้บริการ
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" onclick="logout()" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            ออกจากระบบ
                        </p>
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