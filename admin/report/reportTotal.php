<?php
    $title = 'REPORT | APPLICATION';
    include '../middleware.php';
    $page = 'reportTotal';
    $date = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">

<?php include('./header.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'aside.php'?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                   <div class="row">
                        <div class="col-lg-12">
                            <div class="card mt-2 p-2">
                                <table class="table" id="example1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>จำนวน</th>
                                            <th>วัน/เดือน/ปี</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            require_once("../../includes/connection.php");
                                            $stmt = $conndb->query("SELECT * FROM `totel` ORDER BY id DESC");
                                            $stmt->execute();
                                            $result = $stmt->fetchAll();
                                            $i = 1;
                                            foreach ( $result AS $row ) :?>

                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $row['quantity'] ?></td>
                                                <td><?= date('d/m/Y' , strtotime($row['date'])) ?></td>
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

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../dist/js/adminlte.js"></script>
    <!-- datatables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script>
    $(function() {
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
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
    });
    </script>
</body>

</html>