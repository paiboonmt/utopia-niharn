<?php
$title = 'REPORT | APPLICATION';
include '../middleware.php';
$page = 'PaymentReport';
$date = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">

<?php include('./header.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'aside.php' ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">

                    <?php if (!isset($_POST['search'])): ?>
                        <div class="row p-2">
                            <div class="col-7 p-2 mx-auto">
                                <form action="" method="post">
                                    <div class="card">
                                        <div class="card-header bg-dark text-white">
                                            <h3 class="card-title">Payment Report</h3>
                                        </div>

                                        <div class="card-body">
                                            <div class="col mx-auto">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Choose</span>
                                                    </div>
                                                    <input type="date" name="date" class="form-control" required value="<?= $date ?>">
                                                </div>
                                            </div>
                                            <div class="col mx-auto">
                                                <input type="submit" name="search" class="btn btn-primary form-control" value="Search">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if (isset($_POST['search'])) { ?>

                        <?php
                        echo '<pre>';
                        $date = $_POST['date'];
                        echo 'Selected Date: ' . date('d/m/Y', strtotime($date)) . '<br>';
                        echo '</pre>';
                        ?>
                        <div class="row">
                            <div class="col">
                                <div class="card p-2">
                                    <table id="example1" class="table table-sm">
                                        <thead>
                                            <th> แยกประเภทวิธีการชำระ </th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-right"> จำนวนครั้ง </th>
                                            <th class="text-right">ยอดขายรวม</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlCash = $conndb->query("SELECT  `pay`, COUNT(pay) as count , SUM(total) AS total
                                        FROM `orders` 
                                        WHERE date(`date`) LIKE '%$date%'
                                        GROUP BY `pay`
                                        ORDER BY count DESC ");
                                            $sqlCash->execute();
                                            $totalAmount = 0;
                                            foreach ($sqlCash as $rowCash) : ?>
                                                <tr>
                                                    <td><?= $rowCash['pay'] ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-right"><?= $rowCash['count'] ?></td>
                                                    <td colspan="2" class="text-right"><?= number_format($rowCash['total'], 2) ?></td>
                                                </tr>
                                                <?php $totalAmount =  $totalAmount += $rowCash['total'] ?>
                                            <?php endforeach ?>
                                            <tr class="text-danger">
                                                <th>ยอดรวมทั้งหมด</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th class="text-right "><?= number_format($totalAmount, 2) ?></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    <?php }  ?>
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