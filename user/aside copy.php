<?php
    require_once '../includes/connection.php';
    $UserID = $_SESSION['UserID'];
    $pro = $conndb->query("SELECT * FROM `tb_user` WHERE id = $UserID");
    $pro->execute();
    $rows = $pro->fetchAll();

    function countTicket($conndb){
        $data = null;
        $stmt = $conndb->query("SELECT * FROM `orders` WHERE date(date)=curdate()");
        $stmt->execute();
        $data = $stmt->rowCount();
        return $data;
    }

    function countNew($conndb){
        $data = null;
        $stmt = $conndb->query("SELECT `id`,`m_card`,`sex`,`fname`,`birthday`,`age`,`invoice`,`nationalty`,`package`,`accom`,sta_date,exp_date,email,phone,AddBy,`image`,`date`,`status`,`comment`
        FROM `member`
        WHERE `status_code` = 2 AND date(date) = CURDATE() ORDER BY date DESC");
        $stmt->execute();
        $data = $stmt->rowCount();
        return $data;
    }
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="text-transform: uppercase;">
    <a href="index.php" class="brand-link">
        <img src="../dist/img/logo.png" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">member system</span>
    </a>
    <div class="sidebar">
        <div class="user-panel py-2 d-flex">
            <div class="image">
                <img src="<?= '../user/img/'.$rows[0]['img'] ?>" class="img-thumbnail img-circle elevation-2" alt="User Image">
            </div>
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
                            Dashboard
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
                <li class="nav-item">
                    <a href="checkin.php" class="nav-link <?= $active ?>">
                    <i class="nav-icon fas fa-chess-knight"></i>
                        <p>
                            Check in
                        </p>
                    </a>
                </li>

                <?php
                    if ($page == 'cart') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                ?>
                <li class="nav-item">
                    <a href="cart.php" class="nav-link <?= $active ?>">
                    <i class="nav-icon fas fa-cube"></i>
                        <p>
                        Sale Ticket
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
                    <i class="nav-icon fas fa-cube"></i>
                        <p>
                            products
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
                           Record Ticket
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
                            search
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
                <li class="nav-item">
                    <a href="newCheckin.php" class="nav-link <?= $active ?>">
                    <i class="nav-icon far fa-clipboard"></i>
                        <p>
                            Record Checkin
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
                    <i class="nav-icon fas fa-user-plus"></i>
                        <p>
                            New Member
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
                    <i class="nav-icon fas fa-users"></i>
                        <p>
                            Customer Active
                        </p>
                    </a>
                </li>
                
                <?php
                    if ($page == 'allmemberexpired') {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                ?>

                <li class="nav-item">
                    <a href="allmemberexpired.php" class="nav-link <?= $active ?>">
                    <i class="nav-icon fas fa-users"></i>
                        <p>
                            Customer Expired
                        </p>
                    </a>
                </li>

                <?php
                if ($page == 'sponsor') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>

                <li class="nav-item">
                    <a href="sponsor.php" class="nav-link <?= $active ?>">
                    <i class="nav-icon fas fa-users"></i>
                        <p>
                            Sponsor
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
 
                <?php
                if ($page == 'telephone') {
                    $active = 'active';
                } else {
                    $active = '';
                }
                ?>
                <li class="nav-item">
                    <a href="telephone.php" class="nav-link <?= $active ?>">
                    <i class="nav-icon fas fa-phone"></i>
                        <p>
                            Telephone
                        </p>
                    </a>
                </li>

                <?php
                    if ($page == 'report1') {
                        $active = 'active';
                        $active1 = 'active';
                        $menu = 'menu-open';
                    } else if ($page == 'report2') {
                        $active = 'active';
                        $active2 = 'active';
                        $menu = 'menu-open';
                    } else if ($page == 'report3') {
                        $active = 'active';
                        $active3 = 'active';
                        $menu = 'menu-open';
                    } else if ($page == 'report4') {
                        $active = 'active';
                        $active4 = 'active';
                        $menu = 'menu-open';
                    } else if ($page == 'report5') {
                        $active = 'active';
                        $active5 = 'active';
                        $menu = 'menu-open';
                    } else if ($page == 'report6') {
                        $active = 'active';
                        $active6 = 'active';
                        $menu = 'menu-open';
                    } else if ($page == 'report7') {
                        $active = 'active';
                        $active7 = 'active';
                        $menu = 'menu-open';
                    } else if ($page == 'report8') {
                        $active = 'active';
                        $active8 = 'active';
                        $menu = 'menu-open';
                    } else {
                        $active = '';
                        $menu  = '';
                    }
                ?>

                <li class="nav-item <?= $menu ?>">
                    <a href="report/reportTicket.php" class="nav-link <?= $active ?>">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>
                            Report
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./report/reportTicket.php" class="nav-link <?= $active7 ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> report ticket </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reportDay.php" class="nav-link <?= $active1 ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> report day </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reportMonthly.php" class="nav-link <?= $active2 ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p> report monthly </p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="reportBetway.php" class="nav-link <?= $active3 ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>report Betway </p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="reportDaypass.php" class="nav-link <?= $active4 ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Report Daypass </p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="./reportDropin.php" class="nav-link <?= $active5 ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Report Dropin </p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="./reportPrivate.php" class="nav-link <?= $active6 ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Report Private </p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="./report/reportTotal.php" class="nav-link <?= $active8 ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Report Total </p>
                            </a>
                        </li>
                    </ul>
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