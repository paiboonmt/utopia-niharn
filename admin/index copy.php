<?php
  session_start();
  include("middleware.php");
  $title = 'DASHBOARD | TIGER APPLICATION';
  $page = 'index';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?></title>
  <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../dist/css/style_card.css">
  <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
  <?php include 'aside.php' ?>
    <div class="content-wrapper">
      <div class="content">
        <div class="container-fluid">
          <div class="row"><?php include('home/box.php'); ?></div>
          <div class="row">
            <div class="col-md-4"><?php include("home/count_packages.php"); ?></div>
            <div class="col-md-4"><?php include("home/count_fighter.php"); ?></div>
            <div class="col-md-4"><?php include("home/countTotal.php"); ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../plugins/jquery/jquery.min.js"></script>
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
<?php $conndb = null; ?>