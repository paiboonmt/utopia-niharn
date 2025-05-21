<?php
include './middleware.php';
$title = 'NEW MEMBER | APPLICATION';
$page = 'newmember';
require_once '../includes/connection.php';
$sql = "SELECT * FROM customer ORDER BY id DESC";
$stmt = $conndb->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
include './layout/header.php';
?>

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
                        <th class="text-center">จัดการ</th>
                      </tr>
                    </thead>
                    <tbody class="text-sm">
                      <?php

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
                          <td class="text-center">
                            <a href="editmember.php?id=<?= $row['m_card'] ?>" class="btn btn-sm btn-warning">
                              <i class="fas fa-edit"></i>|แก้ไข
                            </a>
                           <?php if ($_SESSION['role'] == 'admin'): ?>
                              <a href="delete.php?id=<?= $row['m_card'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">
                                <i class="fas fa-trash"></i>|ลบ
                              </a>
                            <?php endif; ?>
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

<?php include './layout/footer.php' ?>

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