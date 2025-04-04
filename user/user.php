<?php

    session_start();

    $UserID = $_SESSION['UserID'];

    require_once '../includes/connection.php';

    $stmt = $conndb->prepare("SELECT * FROM `tb_user` WHERE id = :s ");
    $stmt -> bindParam(":s",$UserID);
    $stmt -> execute();
    $rows = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VACCINE</title>
    <!-- icon -->
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css"integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw=="crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../dist/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.6/dist/sweetalert2.all.min.js"></script>

    <style>
        .content-wrapper {
            background: linear-gradient(#8360c3, #2ebf91);
        }

        .content-wrapper .row h1 {
            margin-left: 25px;
            letter-spacing: 3px;
        }

        .content-wrapper .btnb {
            background: transparent;
            width: 150px;
            height: 35px;
            margin-top: 10px;
            color: white;
            margin-left: 50px;
            border-radius: 35px;
            border: 1 solid transparent;
            text-transform: uppercase;
            transition: 0.3s;
        }

        .content-wrapper .btnb:hover {
            box-shadow: 0 0 10px red;
        }

        th {
            text-transform: uppercase;
        }

        .content-wrapper h1 {
            color: white;
        }

        .content-wrapper table {
            cursor: pointer;
        }

        .content-wrapper thead {
            color: white;
            text-transform: uppercase;
        }

        .content-wrapper th {
            color: black;
            font-size: 20px;
        }

        .content-wrapper td {
            color: white;
            font-size: 18px;
            text-transform: uppercase;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Modal -->
        <div class="modal fade" id="vaccin_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> CREATE NEW VACCINE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="sql/vaccine/insert.php" method="POST">
                            <div class="form-group col">
                                <input type="text" name="vaccine" class="form-control mb-1" placeholder=" ชื่อ ">
                                <input type="text" name="country" class="form-control mb-1" placeholder="ประเทศที่ผลิต">
                                <input type="text" name="percentage" class="form-control"
                                    placeholder="เปอร์เซน การรักษา">
                            </div>
                            <div class="form-group col">
                                <input type="submit" name="add_vaccine" value="SAVE" class="btn btn-success"
                                    style="width: 100%;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <?php
                require_once '../includes/connection.php';
                $UserID = $_SESSION['UserID'];
                $pro = $conndb->query("SELECT * FROM `tb_user` WHERE id = $UserID");
                $pro->execute();
                $rows = $pro->fetchAll();
            ?>
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <img src="../dist/img/logo.png" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">member system</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= '../user/img/'.$rows[0]['img'] ?>" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="user.php" class="d-block" style="text-transform: uppercase;"><?=  $rows[0]['username'] ?></a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item ">
                            <a href="index.php" class="nav-link ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="checkin.php" class="nav-link ">
                                <i class="nav-icon fa-solid fa-check-to-slot"></i>
                                <p>
                                    Check in
                                    <!-- <span class="right badge badge-info">New</span> -->
                                </p>
                            </a>
                        </li>

                        <?php 
                $stmt = $conndb->query("SELECT * FROM `member` WHERE `group` = 'customer' AND date(date)=curdate() ORDER BY date DESC");
                $stmt->execute();
                $rowww = $stmt->rowCount();
                if ($rowww >= 0) : ?>

                        <li class="nav-item">
                            <a href="newmember.php" class="nav-link ">
                                <i class="nav-icon fa-solid fa-person-circle-plus"></i>
                                <p>
                                    New Member
                                    <span class="right badge badge-info"><?= $rowww ?></span>
                                </p>
                            </a>
                        </li>

                        <?php endif; ?>

                        <li class="nav-item">
                            <a href="allmember.php" class="nav-link ">
                                <i class="nav-icon fa-solid fa-users-line"></i>
                                <p>
                                    all Member
                                    <!-- <span class="right badge badge-info">New</span> -->
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="sponsor.php" class="nav-link ">
                                <i class="nav-icon fa-solid fa-person-rays"></i>
                                <p>
                                    sponsor fighter
                                    <!-- <span class="right badge badge-info">New</span> -->
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="nationnality.php" class="nav-link ">
                                <i class="nav-icon fa-solid fa-globe"></i>
                                <p>
                                    nationnality
                                    <!-- <span class="right badge badge-info">New</span> -->
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="package.php" class="nav-link ">
                                <i class="nav-icon fa-solid fa-box-open"></i>
                                <p>
                                    package product
                                    <!-- <span class="right badge badge-info">New</span> -->
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="vaccine.php" class="nav-link">
                                <i class="nav-icon fa-solid fa-virus-covid-slash"></i>
                                <p>
                                    vaccine
                                    <!-- <span class="right badge badge-info">New</span> -->
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="telephone.php" class="nav-link">
                                <i class="nav-icon fa-solid fa-phone"></i>
                                <p>
                                    telephone
                                    <!-- <span class="right badge badge-info">New</span> -->
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="trainercode.php" class="nav-link">
                                <i class="nav-icon fa-solid fa-people-group"></i>
                                <p>
                                    trainer code
                                    <!-- <span class="right badge badge-info">New</span> -->
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="card.php" class="nav-link">
                                <i class="nav-icon fa-solid fa-id-card"></i>
                                <p>
                                    card member
                                    <!-- <span class="right badge badge-info">New</span> -->
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="setting.php" class="nav-link">
                                <i class="nav-icon fa-solid fa-sliders"></i>
                                <p>
                                    setting
                                    <!-- <span class="right badge badge-info">New</span> -->
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="report.php" class="nav-link">
                                <i class="nav-icon fa-solid fa-file-archive"></i>
                                <p>
                                    report
                                    <!-- <span class="right badge badge-info">New</span> -->
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">
                                <i class="nav-icon fa-solid fa-sign-out-alt"></i>
                                <p>
                                    logout
                                    <!-- <span class="right badge badge-info">New</span> -->
                                </p>
                            </a>
                        </li>

                        <!-- <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Check in </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Inactive Page</p>
                    </a>
                </li>
                </ul>
            </li> -->


                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php foreach ($rows as $row) :?>
                        <div class="col-md-6 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <h2>ข้อมูลส่วนตัว</h2>
                                        <button class="ml-auto btn btn-info " data-toggle="modal" data-target="#exampleModal"> แก้ไขข้อมูลส่วนตัว </button>
                                    </div>
                                </div>
                                <!-- รายละเอียด -->
                                <div class="card-body">
                                    <!-- Username -->
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">ชื่อ ผู้ใช้งาน</span>
                                        <input type="text" name="username" class="form-control"value="<?= $row['username'] ?>">
                                    </div>
                                    <!-- Email -->
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"> อีเมล </span>
                                        <input type="text" name="email" class="form-control"value="<?= $row['email'] ?>">
                                    </div>
                                    <!-- Paswword -->
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"> พาสเวิดส์ </span>
                                        <input type="password" name="password" class="form-control"value="<?= $row['password1'] ?>">
                                    </div>
                                    <!-- Level -->
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"> ระดับ </span>
                                        <input type="text" name="level" class="form-control"value="<?= $row['level'] ?> / Group Administrator">
                                    </div>
                                    <!-- Dept -->
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"> แผนก / ฝ่าย</span>
                                        <input type="text" class="form-control" value="<?= $row['dept'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ภาพโปรไฟส์ -->
                        <div class="col-md-6 mt-3">
                            <div class="card">
                                <div class="card-header mb-2">
                                    <h2> รูปภาพโปรไฟส์ </h2>
                                </div>
                                <div class="col d-flex justify-content-center">
                                    <img src="<?php echo '../user/img/'.$row['img'] ?>" class=" mb-2" width="50%">
                                </div>
                                <input type="text" class="form-control" value="ชื่อ : <?= $row['img'] ?>">
                            </div>
                        </div>
                        <!-- Modal Edit -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลส่วนตัว</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="sql/user/sql.php" method="post"
                                            enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-6">
                                                    <!-- ID Hidden-->
                                                    <input type="hidden" name="id" value="<?= $row['id']?>">
                                                    <input type="hidden" name="level" value="<?= $row['level'] ?>">
                                                    <!-- Username -->
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">ชื่อ ผู้ใช้งาน </span>
                                                        <input type="text" name="username" class="form-control"value="<?= $row['username'] ?>">
                                                    </div>
                                                    <!-- Email -->
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">อีเมล </span>
                                                        <input type="text" name="email" class="form-control"value="<?= $row['email'] ?>">
                                                    </div>
                                                    <!-- Paswword -->
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">พาสเวิดส์ </span>
                                                        <input type="text" name="password" class="form-control"value="<?= $row['password1'] ?>">
                                                    </div>
                                                    <!-- Dept -->
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">แผนก / ฝ่าย </span>
                                                        <input type="text" name="dept" class="form-control"value="<?= $row['dept'] ?>" readonly>
                                                    </div>

                                                    <button type="submit" name="update" class="btn btn-primary btn-block"> บันทึก </button>
                                                </div>

                                                <div class="col-6">
                                                    <!-- Image -->
                                                    <div class="input-group mb-3">
                                                        <div class="col d-flex justify-content-center">
                                                            <img src="<?php echo '../user/img/'.$row['img'] ?>"id="prev" class=" mb-2" width="100%">
                                                            <!-- <img width="100%" id="prev"> -->
                                                        </div>
                                                    </div>
                                                    <input type="file" name="img" class="form-control mb-3"id="imgInput" value="<?= $row['img'] ?>">
                                                    <input type="hidden" name="img2" value="<?= $row['img'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Wrapper. Contains page content -->
    </div>
  
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    
    <!-- Show image -->
    <script>
    let imgInput = document.getElementById('imgInput');
    let preview = document.getElementById('prev');
    
    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    }
    </script>

    <?php if (isset($_SESSION['update'])) { ?>

    <script>
    Swal.fire(
        'เยี่ยม มาก!',
        ' คุณแก้ไขข้อมูล ได้สำเร็จ!',
        'success'
    )
    </script>

    <?php } unset($_SESSION['update']) ?>

<?php $conndb = null; ?>
</body>
</html>