<?php 
  session_start();
  include './middleware.php';
  $title = 'SEARCH | APPLICATION';
  $page = 'search';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.png">
    <title><?= $title ?></title>
    <link rel="stylesheet"href="../dist/css/font.css">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include './aside.php' ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-4 mt-3">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h3>SEARCH</h3>
                                </div>
                                <div class="card-body">
                                    <input type="text" id="txt_input" class="form-control" autofocus required>
                                </div>
                                <div class="card-footer">
                                    <ul>
                                        <h5>ขั้นตอนการค้นหาข้อมูล </h5>
                                        <li>ป้อนหมายเลขไอดีของบัตรสมาชิกได้</li>
                                        <li>ป้อนชื่อลูกค้าได้ </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-8 mt-3">
                            <div class="card p-2">
                                <table class="table table-sm" id="example1">
                                    <thead>
                                        <tr>
                                            <th>ดู</th>
                                            <th>หมายเลขบัตร</th>
                                            <th>ชื่อ</th>
                                            <td>รายการ</td>
                                            <td>วันเริ่ม</td>
                                            <td>วันหมดอายุ</td>
                                        </tr>
                                    </thead>
                                    <tbody id="searchresult">
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
    <script src="../dist/js/adminlte.js"></script>
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
</body>

</html>
<script>
  $(document).ready(function() {
      $("#txt_input").keyup(function() {
          let input = $(this).val();
          console.log(input);
          if (input != '') {
              $.ajax({
                  url: 'searchSql.php',
                  method: 'post',
                  data: {
                      input: input
                  },
                  success: function(data) {
                      $("#searchresult").html(data);
                      console.log(data)
                  }
              });
          } else {
              $("#searchresult").html('<p> Not found </p>');
          }
      });
  });

  $(function() {
        $("#example1").DataTable({
          "responsive": true,
          "lengthChange": true,
          "autoWidth": false,
          "buttons": ["excel"]
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