<?php
// require_once '../includes/connection.php';
$UserID = $_SESSION['UserID'];
$pro = $conndb->query("SELECT * FROM `tb_user` WHERE id = $UserID");
$pro->execute();
$rows = $pro->fetchAll();

function countTicket($conndb)
{
    $data = null;
    $stmt = $conndb->query("SELECT * FROM `orders` WHERE `pay` != 'Canceled' AND  date(date)=curdate()");
    $stmt->execute();
    $data = $stmt->rowCount();
    return $data;
}

function countNew($conndb)
{
    $data = null;
    $stmt = $conndb->query("SELECT `id`,`m_card`,`sex`,`fname`,`birthday`,`age`,`invoice`,`nationalty`,`package`,`accom`,sta_date,exp_date,email,phone,AddBy,`image`,`date`,`status`,`comment`
        FROM `member`
        WHERE `status_code` = 4 AND date(date) = CURDATE() ORDER BY date DESC");
    $stmt->execute();
    $data = $stmt->rowCount();
    return $data;
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="text-transform: uppercase;">
    <a href="index.php" class="brand-link">
        <img src="../dist/img/logo.png" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">TIGER | SOFTWARE</span>
    </a>
    <div class="sidebar">
        <div class="user-panel py-2 d-flex">
            <div class="info">
                <a href="user.php" class="d-block" style="text-transform: uppercase;">ผู้ใช้งาน : <?= $rows[0]['username'] ?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <?php
                if ($page == 'index') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>
                <li class="nav-item ">
                    <a href="index.php" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            หน้าแรก
                        </p>
                    </a>
                </li>

                <?php
                if ($page == 'usersetting') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>
                <?php
                if ($_SESSION['role'] == 'admin') : ?>
                    <li class="nav-item ">
                        <a href="usersetting.php" class="nav-link <?= $active ?>">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>
                                จัดการสมาชิก
                            </p>
                        </a>
                    </li>
                <?php endif ?>

                <?php
                if ($page == 'checkin') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>
                <li class="nav-item">
                    <a href="checkin.php" class="nav-link <?= $active ?>">
                        <i class="nav-icon  fas fa-door-open"></i>
                        <p>
                            เช็คอิน
                        </p>
                    </a>
                </li>

                <li class="nav-header" style="font-size: 20px;">ขาย | คลาสเรียนมวย</li>


                <?php
                if ($page == 'cart') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>
                <li class="nav-item">

                    <a href="cart.php" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            ขาย Ticket
                        </p>
                    </a>
                </li>

                <?php
                if ($page == 'product') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>

                <li class="nav-item">
                    <a href="product.php" class="nav-link <?= $active ?>">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            บริการ รายการสอน
                        </p>
                    </a>
                </li>

                <?php if ($_SESSION['role'] == 'admin') : ?>
                    <li class="nav-header" style="font-size: 20px;">ขาย | สินค้า | เครื่องดื่ม</li>
                    <?php
                    if ($page == 'shop') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    ?>

                    <li class="nav-item">
                        <a href="shop.php" class="nav-link <?= $active ?>">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                ขายสินค้า
                            </p>
                        </a>
                    </li>


                    <?php
                    if ($page == 'store') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    ?>

                    <li class="nav-item">
                        <a href="shop_store.php" class="nav-link <?= $active ?>">
                            <i class="nav-icon fas fa-store"></i>
                            <p>
                                คลังสินค้า
                            </p>
                        </a>
                    </li>
                <?php endif ?>



                <?php
                if ($page == 'payment') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>

                <?php if ($_SESSION['role'] == 'admin') : ?>
                    <li class="nav-item">
                        <a href="payment.php" class="nav-link <?= $active ?>">
                            <i class="nav-icon fab fa-cc-amazon-pay"></i>
                            <p>
                                การชำระเงิน
                            </p>
                        </a>
                    </li>
                <?php endif ?>

                <?php
                if ($page == 'recordticket' ||  $page == 'cancel_ticket') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>
                <li class="nav-item ">
                    <a href="recordticket.php" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                            ประวัติการขาย
                            <?php if (countTicket($conndb) == 0) { ?>
                                <span class="right badge badge-danger"><?= countTicket($conndb); ?></span>
                            <?php } else { ?>
                                <span class="right badge badge-danger"><?= countTicket($conndb); ?></span>
                            <?php } ?>
                        </p>
                    </a>
                </li>

                <?php
                if ($page == 'search') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>
                <li class="nav-item ">
                    <a href="search.php" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-search"></i>
                        <p>
                            ค้นหาสมาชิก
                        </p>
                    </a>
                </li>

                <?php
                if ($page == 'newmember') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>
                <li class="nav-item">
                    <a href="newmember.php" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-user-clock"></i>
                        <p>
                            รายชื่อสมาชิก
                            <?php if (countNew($conndb) == 0) { ?>
                                <span class="right badge badge-info"><?= countNew($conndb); ?></span>
                            <?php } else { ?>
                                <span class="right badge badge-info"><?= countNew($conndb); ?></span>
                            <?php } ?>
                        </p>
                    </a>
                </li>

                <?php
                if ($page == 'nationality') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>

                <li class="nav-item">
                    <a href="nationnality.php" class="nav-link <?= $active ?>">
                        <i class="nav-icon fas fa-language"></i>
                        <p>
                            สัญชาติ
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="./report/reportTicket.php" class="nav-link">
                        <i class="nav-icon fas fa-print"></i>
                        <p>รายงาน</p>
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
                window.location.href = 'logout.php';
            }
        })
    }
</script>