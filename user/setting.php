<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Setting</title>
  <!-- icon -->
  <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../dist/css/style.css">
<!-- 
  <style>
    .content-wrapper {
      background: linear-gradient(to right, #67b26f, #4ca2cd);
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
 -->
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 ">
    <?php
      require_once '../includes/connection.php';
      $UserID = $_SESSION['UserID'];
      $pro = $conndb->query("SELECT * FROM `tb_user` WHERE id = $UserID");
      $pro->execute();
      $rows = $pro->fetchAll();

      ?>
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
      <img src="../dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">member system</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
          <img src="<?= '../user/img/'.$rows[0]['img'] ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
          <a href="user.php" class="d-block" style="text-transform: uppercase;"><?=  $rows[0]['username'] ?></a>
          </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
            <a href="trainercode.php" class="nav-link ">
              <i class="nav-icon fa-solid fa-people-group"></i>
              <p>
                trainer code
                <!-- <span class="right badge badge-info">New</span> -->
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="card.php" class="nav-link ">
              <i class="nav-icon fa-solid fa-id-card"></i>
              <p>
                card member
                <!-- <span class="right badge badge-info">New</span> -->
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="setting.php" class="nav-link active">
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <h1> setting </h1>
          <br>
          <hr>
          
        </div>
      </div>
    </div>
  </div>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
