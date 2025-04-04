<?php
  session_start();
  include './middleware.php';
  $title = 'ALL MEMBER | TIGER APPLICATION';
  $page = 'allmemberexpired';
  require_once '../includes/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="../dist/css/font.css">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>

  <style>
     .h {
      text-transform: uppercase;
      font-weight: 900;
      transition: 0.5s;
    }

    .h:hover {
      color: orangered;
      cursor: pointer;
    }

    .bb {
      text-transform: uppercase;
    }
    .btn{
      width: 100%;
    }
  </style>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include 'aside.php' ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <div class="row p-3">
            <h2 class="h">all member exppired</h2>
            <div class="col-lg-12">
              <div class="card p-2 mt-2">
                <table id="example1" class="table table-sm table-hover">
                  <thead>
                    <tr>
                      <th>View</th>
                      <th>Card ID</th>
                      <th hidden>Gender</th>
                      <th>Full Name</th>
                      <th hidden>birthday</th>
                      <th hidden>age</th>
                      <th>Invoice</th>
                      <th>Nationalty</th>
                      <th>Packcakde</th>
                      <th>Accom</th>
                      <th>StartTraining</th>
                      <th>End Training</th>
                      <th hidden>Create time</th>
                      <th hidden>Email</th>
                      <th>Edit by</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        $stmt = $conndb->query("SELECT m_card , sex , fname , birthday , age , invoice , 
                        nationalty , package , accom , sta_date,
                        exp_date , date , email , AddBy , id
                        FROM member 
                        WHERE `status_code` = 2
                        -- AND exp_date >= '2023-01-01' 
                        ORDER BY id DESC");
                        $stmt->execute();
                        foreach ($stmt as $row) : ?>
                      <tr>
                        <td>
                          <a href="member_profile.php?id=<?= $row['id']; ?>" target="_bank" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        </td>
                        <td><?= $row['m_card'] ?> </td>
                        <td hidden><?= $row['sex'] ?></td>
                        <td><?= $row['fname'] ?> </td>
                        <td hidden><?= date('d/m/y', strtotime($row['birthday'])) ?> </td>
                        <td hidden><?= $row['age'] ?> </td>
                        <td><?= $row['invoice'] ?> </td>
                        <td><?= $row['nationalty'] ?> </td>
                        <td><?= $row['package'] ?> </td>
                        <td><?= $row['accom'] ?> </td>
                        <td><?= date('d/m/Y', strtotime($row['sta_date'])); ?></td>
                        <td><?= date('d/m/Y', strtotime($row['exp_date'])); ?></td>
                        <td hidden><?= $row['date'] ?> </td>
                        <td hidden><?= $row['email'] ?></td>
                        <td><?= $row['AddBy'] ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
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

    <script>
      $(function() {
        $("#example1").DataTable({
          "responsive": true,
          "lengthChange": false,
          "autoWidth": false,
          "buttons": ["excel"],
        //   "pageLength": 15
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