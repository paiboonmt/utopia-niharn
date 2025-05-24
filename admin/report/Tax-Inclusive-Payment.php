<?php
$title = 'Tax-Inclusive-Payment | แยกประเภทการชำระแบบมีภาษี';;
include '../middleware.php';
$page = 'Tax-Inclusive-Payment';
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
                                            <h3 class="card-title">แยกประเภทการชำระแบบมีภาษี</h3>
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
                                            <th>แยกประเภทการชำระแบบมีภาษี</th>
                                            <th></th>
                                            <th class="text-right">หมายเลขบิล</th>
                                            <th class="text-right">ยอด</th>
                                            <th class="text-right">จำนวนภาษี</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql_pay = "SELECT id , pay , num_bill , total 
                                            FROM `orders` 
                                            WHERE `date` LIKE '%$date%' AND pay != 'Cash'
                                            GROUP BY id";
                                            $stmt_pay = $conndb->query($sql_pay);
                                            $stmt_pay->execute();
                                            $vat = 0;
                                            $sumVat = 0;
                                            $sumRowPay = 0;
                                            foreach ($stmt_pay as $row_pay) : ?>
                                                <tr>
                                                    <td> <?= $row_pay['pay'] ?> </td>
                                                    <td></td>
                                                    <td class="text-right"> <?= $row_pay['num_bill'] ?> </td>
                                                    <td class="text-right"> <?= number_format($row_pay['total'], 2) ?> </td>
                                                    <?php $vat = ($row_pay['total'] * 3) / 103 ?>
                                                    <td class="text-right"> <?= number_format($vat, 2) ?> </td>
                                                </tr>

                                                <?php $sumRowPay = $sumRowPay += $row_pay['total'] ?>
                                                <?php $sumVat = $sumVat += $vat  ?>

                                            <?php endforeach; ?>

                                        </tbody>
                                        <tr class="text-danger">
                                            <td>ยอดรวมภาษี</td>
                                            <th colspan="6" class="text-right"><?= number_format($sumVat, 2) ?></th>
                                        </tr>
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
                "buttons": ["excel", "print"],
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