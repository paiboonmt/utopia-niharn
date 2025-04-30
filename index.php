<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>เข้าสู่ระบบ</title>
  <link rel="icon" type="image/x-icon" href="./dist/img/logo.png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    body {
      background: rgb(64, 3, 125);
      background: linear-gradient(137deg, rgba(64, 3, 125, 1) 0%, rgba(9, 111, 121, 1) 31%, rgba(255, 106, 0, 1) 95%);
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
    }

    #login-logo {
      background-color: #f8f9fa;
      border-radius: 10px;
    }

    .login-card-body {
      background-color: #f8f9fa;
      border-radius: 15px;
    }
  </style>

</head>

<body class="hold-transition login-page">
  <div class="login-box">

    <div class="login-logo">
      <img src="./dist/img/logo.png" width="15%">
      <a href="" style="color: white;"><b>TIGER | </b>SOFTWARE</a>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">ป้อนรหัสเพื่อเข้าใช้งานโปรแกรม</p>

        <form action="./checkLogin.php" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username" autofocus required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">

            <!-- /.col -->
            <div class="col">
              <input type="submit" class="btn btn-primary btn-block" value="Sign In">
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
    </div>

    <!-- <?php print_r($_SESSION); ?> -->
    <hr>

    <div class="text-center" style="text-transform: uppercase; font-size: 12px;">
      <p style="color: #fff;">copyright © 2024 all rights reserved by paiboon</p>
    </div>
  </div>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>

</body>
</html>

<?php if (isset($_SESSION['not_active'])) { ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'อุ๊ปส์...',
      text: 'User ของคุณยังไม่ได้รับอนุญาติเข้าใช้งาน!',
      footer: 'กรูณาติดต่อ admin', 
      showConfirmButton: true,
    })
  </script>
<?php }
unset($_SESSION['not_active']); ?>