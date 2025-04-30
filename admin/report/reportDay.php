<?php
    include('../middleware.php');
    $title = 'REPORT | APPLICATION';
    $page = 'reportDay';
    $date = date('Y-m-d');
    $data = ''; 
?>
<!DOCTYPE html>
<html lang="en">

<?php include('./header.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'aside.php' ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row p-3">
                        <div class="col-8 p-2 mx-auto">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">เลือก</span>
                                            </div>
                                            <input type="date" name="date" class="form-control" value="<?= $date ?>">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <input type="submit" name="search" class="btn btn-primary form-control" value="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card p-2">
                                <table id="example1" class="table  table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>เวลา</th>
                                            <th>หมายเลขบัตร</th>
                                            <th>ชื่อลูกค้า</th>
                                            <th>รายการสินค้า</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (isset($_POST['search'])) {
                                                require_once '../../includes/connection.php';
                                                $date = $_POST['date'];
                                                $stmt = $conndb->prepare("SELECT * FROM `checkin` WHERE checkin_date = :date GROUP BY `checkin_card_number`");
                                                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                                                $stmt->execute();
                                                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                           
                                                foreach ($data as $row) : ?>
                                                <tr>
                                                    <td><?= $row['checkin_time'] ?></td>
                                                    <td><?= $row['checkin_card_number'] ?></td>
                                                    <td><?= $row['checkin_customer_name'] ?></td>
                                                    <td><?= $row['checkin_product'] ?></td>
                                                    
                                                </tr>
                                        <?php endforeach;  } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>
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
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["excel"],
                "stateSave": true
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