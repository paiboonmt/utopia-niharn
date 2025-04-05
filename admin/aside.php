<?php
    require_once '../includes/connection.php';
    $UserID = $_SESSION['UserID'];
    $pro = $conndb->query("SELECT * FROM `tb_user` WHERE id = $UserID");
    $pro->execute();
    $rows = $pro->fetchAll();

    function countTicket($conndb){
        $data = null;
        $stmt = $conndb->query("SELECT * FROM `orders` WHERE `pay` != 'Canceled' AND  date(date)=curdate()");
        $stmt->execute();
        $data = $stmt->rowCount();
        return $data;
    }

    function countNew($conndb){
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
                    if ($page == 'checkin') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                ?>
                <!-- <li class="nav-item">
                    <a href="checkin.php" class="nav-link < $active ?>">
                    <i class="nav-icon  fas fa-door-open"></i>
                        <p>
                            Check in
                        </p>
                    </a>
                </li> -->

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
                            ขายสินค้า
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
                            สินค้า และ บริการ
                        </p>
                    </a>
                </li>

                <?php
                if ($page == 'payment') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>

                <li class="nav-item">
                    <a href="payment.php" class="nav-link <?= $active ?>">
                    <i class="nav-icon fab fa-cc-amazon-pay"></i>
                        <p>
                            ประวัติการชำระเงิน
                        </p>
                    </a>
                </li>


                <?php
                if ($page == 'recordticket') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>
                <li class="nav-item ">
                    <a href="recordticket.php" class="nav-link <?= $active ?>">
                    <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                           ประวัติการขายตั๋ว
                           <?php if (countTicket($conndb) == 0 ) { ?>
                                <span class="right badge badge-danger"><?= countTicket($conndb); ?></span>
                            <?php } else {?>
                                <span class="right badge badge-danger"><?= countTicket($conndb); ?></span>
                            <?php }?>
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
                    if ($page == 'record') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                ?>
                <!-- <li class="nav-item">
                    <a href="newCheckin.php" class="nav-link <?= $active ?>">
                    <i class="nav-icon far fa-clipboard"></i>
                        <p>
                            ประวัติการเช็คอิน
                        </p>
                    </a>
                </li> -->

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
                            สมาชิกใหม่
                            <?php if (countNew($conndb) == 0 ) { ?>
                                <span class="right badge badge-info"><?= countNew($conndb); ?></span>
                            <?php } else {?>
                                <span class="right badge badge-info"><?= countNew($conndb); ?></span>
                            <?php }?>
                        </p>
                    </a>
                </li>

                <?php
                    if ($page == 'allmember') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                ?>

                <li class="nav-item">
                    <a href="allmember.php" class="nav-link <?= $active ?>">
                    <i class="nav-icon fas fa-user-check"></i>
                        <p>
                            รายชื่อสมาชิก
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
                            Nationality
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="./report/reportTicket.php" class="nav-link">
                    <i class="nav-icon fas fa-print"></i>
                        <p>report</p>
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