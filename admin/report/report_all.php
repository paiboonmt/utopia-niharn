<?php 
  session_start(); 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Report</title>
  <!-- icon -->
  <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../dist/css/style.css">
  <!-- datatables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <style>
   .content-wrapper .nav_menu{
     background: rgba(0,0,0,0.4);
     padding-top: 15px;
     display: flex;
     align-items: center;
     justify-content: space-around;
   }
   .content-wrapper .nav_menu .menu_bran {
     /* color: white; */
     font-size: 55px;
   }
   .content-wrapper .nav_menu ul {
     display: flex;
   }
   .content-wrapper .nav_menu ul li {
     list-style: none;
     padding: 0 15px;
   }
   .content-wrapper .nav_menu ul li a {
       color: white;
       font-size: 18px;
       text-transform: uppercase;
       padding: 0  5px;
       border-radius: 15px;
       transition: 0.1s;
   }
   .content-wrapper .nav_menu ul li a:hover {
       color: #000;
   }
   .active {
     background:rgba(0,0,0,0.1);
   }
</style>

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

      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img src="<?= '../user/img/'.$rows[0]['img'] ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            <a href="user.php" class="d-block" style="text-transform: uppercase;"><?=  $rows[0]['username'] ?></a>
            </div>
        </div>
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
              <a href="report.php" class="nav-link active">
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

          </ul>
        </nav>
      </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   <nav class="nav_menu">
      <h1 class="menu_bran">report all</h1>
      <ul>
        <li><a href="report.php" > daily report </a></li>
        <li><a href="report_all_time.php"> report all time </a></li>
        <li><a href="report_all.php" class="active" > report all </a></li>
        <li><a href="report_res.php"> research </a></li>
      </ul>
   </nav>

   <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col mt-2">
            <!-- report customer -->
              <table id="example1" class="table  table-border table-hover">
                <thead>
                    <tr>
                        <th>รายงาน ลูกค้าที่เข้าใช้บริการวันนี้ </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                    // เชื่อมตอ่ฐานข้อมูล
                    require_once '../includes/connection.php';
                    // เรียกข้อมูลในส่วนของสมาชิกทั้งหมดที่เข้ามาเช็คอิน
                    $stmt = $conndb->query("SELECT `ref_m_card` FROM tb_time WHERE date(time)=curdate()");
                    $stmt->execute();
                    $count2 = $stmt->rowCount();
                    // แบ่งจำนวนตาม packages customer
                    $customer = $conndb->query("SELECT  m.package , COUNT(m.package) , m.group, m.m_card,t.ref_m_card
                    FROM tb_time AS t
                    INNER JOIN member AS m ON t.ref_m_card = m.m_card
                    WHERE  date(t.time)=curdate() AND m.group = 'customer'
                    GROUP BY m.package");
                    $customer->execute();
                    $query_run_customer = $customer->fetchAll();
                    // แบ่งจำนวนตาม packages fighter
                    $fighter = $conndb->query("SELECT  m.type_fighter , COUNT(m.type_fighter) ,m.group
                    FROM tb_time AS t
                    INNER JOIN member AS m ON t.ref_m_card = m.m_card
                    WHERE  date(t.time)=curdate() AND m.group = 'fighter' 
                    GROUP BY m.type_fighter");
                    $fighter->execute();
                    $query_run_fighter = $fighter->fetchAll();

                  ?>

                    <?php  foreach ( $query_run_customer as $row1 ) :?>
                      <tr>
                        <td><?php echo 'Customer'.' '. ($row1[0])?></td>
                        <td><?php echo ($row1[1])?> คน</td>
                      </tr>
                    <?php endforeach; ?>
                    
                    <?php foreach ( $query_run_fighter as $row2 ) :?>
                      <tr>
                          <td><?php echo 'Fighter'. ' ' . ($row2[0])?></td>
                          <td><?php echo ($row2[1])?> คน</td>
                      </tr>
                    <?php endforeach; ?>
                      <tr>
                        <td>สมาชิกทั้งหมดที่เข้ามาเช็คอิน วันนี้</td>
                        <td><?php echo $count2 ?> คน</td>
                      </tr>

                </tbody>
              </table>
            <!-- report customer -->
          </div>
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
<!-- datatables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel","print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<?php $conndb = null; ?>

</body>
</html>
