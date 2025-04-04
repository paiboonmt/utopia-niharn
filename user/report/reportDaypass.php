<?php
    session_start();
    include('./middleware.php');
    $title = 'REPORT | TIGER APPLICATION';
    $page = 'report4';
    $data = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- datatables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include './aside.php' ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row p-3">
                        <div class="col">
                            <div class="card p-2">
                                <table class="table" id="example1">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Customer Name</th>
                                            <th>Package Name</th>
                                            <th>Card id</th>
                                            <th>Sale Time</th>
                                            <th>Price</th>
                                            <th>Sale by</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../includes/connection.php");
                                        $sql = " SELECT `fname` , `package`, `m_card` , `AddBy` , `date` , `price`
                                        FROM `member`  
                                        WHERE date(date) = CURDATE() AND package = 'Day Pass'
                                        ORDER BY date DESC; ";
                                        $stmt = $conndb->query($sql);
                                        $stmt->execute();
                                        $resoult = $stmt->fetchAll();
                                        $count = 1;
                                        foreach ($resoult as $row) : ?>
                                            <tr>
                                                <td><?= $count++ ?></td>
                                                <td><?= $row['fname'] ?></td>
                                                <td><?= $row['package'] ?></td>
                                                <td><?= $row['m_card'] ?></td>
                                                <td><?= $row['date'] ?></td>
                                                <td><?= $row['price'] ?></td>
                                                <td><?= $row['AddBy'] ?></td>
                                            </tr>
                                        <?php endforeach ?>
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
                "buttons": ["excel", "pdf"]
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