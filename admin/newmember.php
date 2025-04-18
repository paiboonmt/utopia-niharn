<?php
session_start();
include './middleware.php';
$title = 'NEW MEMBER | APPLICATION';
$page = 'newmember';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="../dist/img/logo.png">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../dist/css/font.css">
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include 'aside.php' ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-12 mt-2">
              <div class="card">
                <div class="card-header bg-dark">
                  <div class="row">
                    <div class="col">
                      <h3>สมาชิก</h3>
                    </div>
                    <div class="col text-right">
                      <a href="createmember.php">
                        <button class="btn btn-primary ml-5 mb-2 bb">สร้างสมาชิกใหม่</button>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-sm table-hover">
                    <thead>
                      <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>เลขที่สมาชิก</th>
                        <th>ชื่อสินค้า</th>
                        <th>การชำระ</th>
                        <th>สัญชาติ</th>
                        <th>เบอร์โทร</th>
                        <th>อีเมล</th>
                        <th>ภาพ</th>
                        <th>จัดการ</th>
                      </tr>
                    </thead>
                    <tbody class="text-sm">
                      <?php
                        $sql = "SELECT * FROM customer ORDER BY id DESC";
                        $stmt = $conndb->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $i = 1;
                      foreach ($result as $row): ?>
                        <tr>
                          <td><?= $i++ ?></td>
                          <td><?= htmlspecialchars($row['fname']) ?></td>
                          <td><?= htmlspecialchars($row['m_card']) ?></td>
                          <td><?= htmlspecialchars($row['product_name']) ?></td>
                          <td><?= htmlspecialchars($row['payment']) ?></td>
                          <td><?= htmlspecialchars($row['nationality']) ?></td>
                          <td><?= htmlspecialchars($row['phone']) ?></td>
                          <td><?= htmlspecialchars($row['email']) ?></td>
                          <td>
                            <?php if (!empty($row['image'])): ?>
                              <img src="../memberimg/img/<?= htmlspecialchars($row['image']) ?>" style="width: 50px; height: 50px; object-fit: cover;">
                            <?php else: ?>
                              <span>ไม่มีภาพ</span>
                            <?php endif; ?>
                          </td>
                          <td>
                            <a href="editmember.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                              <i class="fas fa-edit"></i>
                            </a>
                            <a href="./customer/sql.php?id=<?= $row['id'] ?>&action=deleteMember" class="btn btn-sm btn-danger" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบสมาชิกนี้?')">
                              <i class="fas fa-trash"></i>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </section>
    </div>
  </div>

  <script src="../plugins/jquery/jquery.min.js"></script>
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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

  <?php if (isset($_SESSION['success'])) : ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Good job!',
        text: ' Your create member successfully!',
        showConfirmButton: true,
        timer: 1000
      })
    </script>
  <?php endif;
  unset($_SESSION['success']) ?>

  <?php if (isset($_SESSION['status_delete'])) : ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Good job!',
        text: ' Your delete member successfully!',
        showConfirmButton: true,
        timer: 1000
      })
    </script>
  <?php endif;
  unset($_SESSION['status_delete']) ?>

  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ['excel']
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

</body>

</html>
<?php $conndb = null; ?>