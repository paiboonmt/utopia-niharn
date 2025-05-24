<?php

$UserID = $_SESSION['UserID'];
$pro = $conndb->query("SELECT * FROM `tb_user` WHERE id = $UserID");
$pro->execute();
$rows = $pro->fetchAll();

function countTicket($conndb)
{
    $data = null;
    $stmt = $conndb->query("SELECT `id` FROM `orders` WHERE `pay` != 'Canceled' AND  date(date)=curdate()");
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

function countShop($conndb)
{
    $data = null;
    $stmt = $conndb->query("SELECT `id` FROM `shop_orders` WHERE  date(date)=curdate()");
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

                <!-- จัดการสมาชิก -->
                <?php if ($_SESSION['role'] == 'admin') : ?>


                    <li class="nav-item ">
                        <?php
                        if ($page == 'usersetting') {
                            $active = 'active';
                        } else {
                            $active = '';
                        }
                        ?>
                        <a href="usersetting.php" class="nav-link <?= $active ?>">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>
                                จัดการสมาชิก
                            </p>
                        </a>
                    </li>

                <?php endif ?>



                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'user' ) : ?>
                    <li class="nav-item">
                        <?php
                        if ($page == 'checkin') {
                            $active = 'active';
                        } else {
                            $active = '';
                        }
                        ?>
                        <a href="checkin.php" class="nav-link <?= $active ?>">
                            <i class="nav-icon  fas fa-door-open"></i>
                            <p>
                                เช็คอิน
                            </p>
                        </a>
                    </li>
                <?php endif ?>


                <?php
                if ($page == 'cart' || $page == 'cart.php' || $page == 'product' || $page == 'recordticket' || $page == 'cancel_ticket' || $page == 'index') {
                    $active_cart = 'active';
                    $open_cart = 'menu-open';
                } else {
                    $active_cart = '';
                    $open_cart = '';
                }
                ?>
                <li class="nav-item <?= $active_cart ?> <?= $open_cart ?>">
                    <a href="#" class="nav-link <?= $active_cart ?>">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            ขาย | คลาสเรียนมวย
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: <?= $open_cart ? 'block' : 'none' ?>;">
                        <li class="nav-item ">
                            <?php
                            if ($page == 'index') {
                                $active = 'active';
                            } else {
                                $active = '';
                            }
                            ?>
                            <a href="index.php" class="nav-link <?= $active ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    สรุปยอดขาย Training
                                </p>
                            </a>
                        </li>

                        <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'user') : ?>
                            <li class="nav-item">
                                <?php
                                if ($page == 'cart') {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                                ?>
                                <a href="cart.php" class="nav-link <?= $active ?>">
                                    <i class="nav-icon fas fa-shopping-cart"></i>
                                    <p>ขาย Ticket</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <?php
                                if ($page == 'product') {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                                ?>
                                <a href="product.php" class="nav-link <?= $active ?>">
                                    <i class="nav-icon fab fa-product-hunt"></i>
                                    <p>
                                        บริการ
                                    </p>
                                </a>
                            </li>
                        <?php endif ?>

                        <li class="nav-item ">
                            <?php
                            if ($page == 'recordticket' ||  $page == 'cancel_ticket') {
                                $active = 'active';
                            } else {
                                $active = '';
                            }
                            ?>
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

                    </ul>
                </li>

                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'user') : ?>
                    <?php
                    if ($page == 'search' || $page == 'newmember' || $page == 'nationality') {
                        $active_cart = 'active';
                        $open_cart = 'menu-open';
                    } else {
                        $active_cart = '';
                        $open_cart = '';
                    }
                    ?>
                    <li class="nav-item <?= $active_cart ?> <?= $open_cart ?>">
                        <a href="#" class="nav-link <?= $active_cart ?>">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                สมาชิก ประวัติลูกค้า
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: <?= $open_cart ? 'block' : 'none' ?>;">
                            <li class="nav-item ">
                                <?php
                                if ($page == 'search') {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                                ?>
                                <a href="search.php" class="nav-link <?= $active ?>">
                                    <i class="nav-icon fas fa-search"></i>
                                    <p>
                                        ค้นหาสมาชิก
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <?php
                                if ($page == 'newmember') {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                                ?>
                                <a href="newmember.php" class="nav-link <?= $active ?>">
                                    <i class="nav-icon fas fa-user-clock"></i>
                                    <p>
                                        รายชื่อสมาชิก
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <?php
                                if ($page == 'nationality') {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                                ?>
                                <a href="nationnality.php" class="nav-link <?= $active ?>">
                                    <i class="nav-icon fas fa-language"></i>
                                    <p>
                                        สัญชาติ
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif ?>

                <?php
                if ($page == 'shop_total' || $page == 'shop' || $page == 'store' || $page == 'recordshop') {
                    $active_cart = 'active';
                    $open_cart = 'menu-open';
                } else {
                    $active_cart = '';
                    $open_cart = '';
                }
                ?>
                <li class="nav-item <?= $active_cart ?> <?= $open_cart ?>">
                    <a href="#" class="nav-link <?= $active_cart ?>">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            ขาย | สินค้า | เครื่องดื่ม
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: <?= $open_cart ? 'block' : 'none' ?>;">

                        <li class="nav-item ">
                            <?php
                            if ($page == 'shop_total') {
                                $active = 'active';
                            } else {
                                $active = '';
                            }
                            ?>
                            <a href="shop_total.php" class="nav-link <?= $active ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    สรุปยอดขาย สินค้า
                                </p>
                            </a>
                        </li>

                        <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'user') : ?>
                            <li class="nav-item">
                                <?php
                                if ($page == 'shop') {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                                ?>
                                <a href="shop.php" class="nav-link <?= $active ?>">
                                    <i class="nav-icon fas fa-shopping-cart"></i>
                                    <p>
                                        ขายสินค้า
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <?php
                                if ($page == 'store') {
                                    $active = 'active';
                                } else {
                                    $active = '';
                                }
                                ?>
                                <a href="shop_store.php" class="nav-link <?= $active ?>">
                                    <i class="nav-icon fas fa-store"></i>
                                    <p>
                                        คลังสินค้า
                                    </p>
                                </a>
                            </li>
                        <?php endif ?>

                        <li class="nav-item ">
                            <?php
                            if ($page == 'recordshop') {
                                $active = 'active';
                            } else {
                                $active = '';
                            }
                            ?>
                            <a href="recordshop.php" class="nav-link <?= $active ?>">
                                <i class="nav-icon fas fa-ticket-alt"></i>
                                <p>
                                    ประวัติการขายสินค้า
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php if ($_SESSION['role'] == 'admin') : ?>
                    <!-- การชำระเงิน -->
                    <li class="nav-item">
                        <?php
                        if ($page == 'payment') {
                            $active = 'active';
                        } else {
                            $active = '';
                        }
                        ?>
                        <a href="payment.php" class="nav-link <?= $active ?>">
                            <i class="nav-icon fab fa-cc-amazon-pay"></i>
                            <p>
                                ประเภท การชำระเงิน
                            </p>
                        </a>
                    </li>
                    <!-- การชำระเงิน -->

                    <!-- ส่วนลด -->
                    <li class="nav-item">
                        <?php
                        if ($page == 'discount') {
                            $active = 'active';
                        } else {
                            $active = '';
                        }
                        ?>
                        <a href="discount.php" class="nav-link <?= $active ?>">
                            <i class="nav-icon fab fa-cc-amazon-pay"></i>
                            <p>
                                ส่วนลด
                            </p>
                        </a>
                    </li>
                    <!-- ส่วนลด -->
                <?php endif ?>

                <!-- รายงาน -->
                <li class="nav-item">
                    <a href="./report/reportTicket.php" class="nav-link">
                        <i class="nav-icon fas fa-print"></i>
                        <p>รายงาน</p>
                    </a>
                </li>
                <!-- รายงาน -->

                <!-- ออกจากระบบ -->
                <li class="nav-item">
                    <a href="#" onclick="logout()" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            ออกจากระบบ
                        </p>
                    </a>
                </li>
                <!-- ออกจากระบบ -->

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