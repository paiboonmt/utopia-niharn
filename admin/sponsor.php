<?php
  session_start();
  include './middleware.php';
  $title = 'SPONSOR FIGHTER | TIGER APPLICATION';
  $page = 'sponsor';
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
  <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <style>
    img {
      border-radius: 50px;
      width: 50px;
      height: 50px;
    }

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
  </style>
  
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include 'aside.php' ?>
    <div class="content-wrapper">
      <div class="content">
        <div class="container-fluid">
          <div class="row p-3">
            <h2 class="h">sponsor fighter</h2>
            <div class="col-lg-12">
              <div class="card p-2 mt-2">
                <table id="example1" class="table table-sm table-hover">
                  <thead>
                    <tr>
                      <th>Image</th>
                      <th>Full Name</th>
                      <th>Nationalty</th>
                      <th>Type Training</th>
                      <th>Type Fighter</th>
                      <th>Affiliate</th>
                      <th>Start</th>
                      <th>Expiry</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $today = date('Y-m-d');
                      $sql_result = null;
                      $sql_data = $conndb->query("SELECT * FROM `member` WHERE status_code = 3  ORDER BY `id` DESC");
                      $sql_data->execute();
                      foreach ($sql_data as $row) : ?>
                        <tr>
                        
                          <td> <a href="fighter_profile.php?id=<?= $row['id']; ?>" target="_blank"><img src=" <?= 'http://172.16.0.3/fighterimg/img/' . $row['image'] ?>"></a></td>
                          <td> <?= $row['fname'] ?></td>
                          <td> <?= $row['nationalty'] ?></td>
                          <td> <?= $row['type_training'] ?></td>
                          <td> <?= $row['type_fighter'] ?></td>
                          <td> <?= $row['sponsored'] ?></td>
                          <td> <?= date('d/m/Y', strtotime($row['sta_date'])); ?></td>
                          <td> <?= date('d/m/Y', strtotime($row['exp_date'])); ?></td>
                          <td>
                            <?php if ($row['exp_date'] <= $today) { ?>
                              <div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-focused bootstrap-switch-animate bootstrap-switch-on" style="width: 65px;">
                                <div class="bootstrap-switch-container" style="width: 126px; margin-left: 0px;">
                                  <span class="bootstrap-switch-label" style="width: 10px;">&nbsp;</span>
                                  <span class="bootstrap-switch-handle-off bootstrap-switch-danger" style="width: 45px;">OFF</span>
                                </div>
                              </div>
                            <?php } else { ?>
                              <div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-focused bootstrap-switch-animate bootstrap-switch-on" style="width: 65px;">
                                <div class="bootstrap-switch-container" style="width: 126px; margin-left: 0px;">
                                  <span class="bootstrap-switch-handle-on bootstrap-switch-success" style="width: 45px;">ON</span>
                                  <span class="bootstrap-switch-label" style="width: 42px;">&nbsp;</span>
                                </div>
                              </div>
                            <?php } ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
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
  <script>
      $(function() {
        $("#example1").DataTable({
          "responsive": true,
          "lengthChange": false,
          "autoWidth": false,
          "buttons": ["excel"],
        //   "pageLength": 15
          // "pageLength" : 15,
          "stateSave": true ,
        })
      });
    </script>
</body>
</html>
<?php $conndb = null; ?>