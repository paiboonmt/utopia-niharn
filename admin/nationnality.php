<?php
session_start();
include('./middleware.php');
$title = 'NATIONALITY | APPLICATION';
$page = 'nationality';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="../dist/img/logo.png">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="../dist/css/font.css">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <!-- datatables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
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
                      <h3>สัญชาติ</h3>
                    </div>
                    <div class="col text-right">
                      <button class="btn btn-primary" style="width: 150px;" data-toggle="modal" data-target="#nn1">เพื่มสัญชาติ</button>
                      <!-- modal -->
                      <div class="modal fade" id="nn1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;text-transform: uppercase;">CREATE nationnality </h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form action="./nationality/nationalitySql.php" method="POST">
                                <div class="form-group col">
                                  <input type="text" name="nation" class="form-control" required placeholder="ป้อนชื่อสัญชาติ">
                                </div>
                                <div class="form-group col">
                                  <input type="submit" name="insert" value="SAVE" class="btn btn-success" style="width: 100%;">
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- end modal -->
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-sm table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Nationality / Country</th>
                        <th class="text-center"> Action </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      require_once "../includes/connection.php";
                      $stmt = $conndb->prepare("SELECT * FROM `tb_nationality` ORDER BY nationality_id DESC ");
                      $stmt->execute();
                      $result = $stmt->fetchAll();
                      $count = 1;
                      foreach ($result as $row) : ?>
                        <tr>
                          <td><?php echo $count++ ?></td>
                          <td><?php echo $row['n_name']; ?></td>

                          <td class="text-center">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#edit<?php echo $row['nationality_id']; ?>"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger trash" id="<?php echo $row['nationality_id']; ?>"><i class="fas fa-trash"></i></button>
                          </td>

                          <!-- Modal -->
                          <div class="modal fade" id="edit<?= $row['nationality_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Edit Nationality</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form action="./nationality/nationalitySql.php" method="POST">
                                    <div class="form-group col">
                                      <input type="text" name="nation" class="form-control" value="<?= $row['n_name']; ?>">
                                      <input type="text" name="id" hidden class="form-control" value="<?= $row['nationality_id']; ?>">
                                    </div>
                                    <div class="form-group col">
                                      <input type="submit" name="update" value="UPDATE NOW" class="btn btn-warning" style="width: 100%;">
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

  <?php if (isset($_SESSION['insert'])) : ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Good job!',
        text: ' Your Create data Successfully!',
        showConfirmButton: true,
        timer: 1500
      })
    </script>
  <?php endif;
  unset($_SESSION['insert']) ?>

  <?php if (isset($_SESSION['update'])) : ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Good job!',
        text: ' Your Update data successfully!',
        showConfirmButton: true,
        timer: 1500
      })
    </script>
  <?php endif;
  unset($_SESSION['update']) ?>

  <script>
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      // "buttons": ["excel"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $(document).ready(function() {
      $(".trash").click(function() {
        let trash_id = $(this).attr("id");
        // console.log(trash_id);
        Swal.fire({
          title: 'Are you sure?',
          text: "Do you want to do ?",
          icon: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, I won to do !'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "./nationality/nationalitySql.php",
              method: 'POST',
              data: {
                id: trash_id,
                action: 'delete'
              },
              success: function(response) {
                location.reload();
              }
            });
          }
        });
      });
    });
  </script>
</body>

</html>
<?php $conndb = null; ?>