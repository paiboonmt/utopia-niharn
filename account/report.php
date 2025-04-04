<?php
session_start();
$title = 'REPORT | TIGER APPLICATION';
include './middleware.php';
$page = 'report';

$date = date('Y-m-d');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">
    <title><?=$title?></title>
    <link rel="stylesheet" href="../dist/css/font.css">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include './aside.php'?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row p-3">
                        <div class="col-8 p-2 mx-auto">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Choose</span>
                                            </div>
                                            <input type="date" name="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <input type="submit" name="search" class="btn btn-primary form-control"
                                            value="Search">
                                    </div>
                                </div>
                            </form>
                            <?php if (isset($_POST['search'])) {?>
                            <p>Searching for date information : <?= date('d-m-Y' , strtotime($_POST['date'])) ?></p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card p-2">
                                <table id="example1" class="table  table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Package Name</th>
                                            <th>Card id</th>
                                            <th>Customer name</th>
                                            <th>Create at</th>
                                            <th>Price</th>
                                            <th>Type of Pay</th>
                                            <th>Discount</th>
                                            <th>Vat7%</th>
                                            <th>Vat3%</th>
                                            <th>Total Price</th>
                                            <th>Sale by</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($_POST['search'])) {

                                        $date = $_POST['date'];
                                        $sum = 0;
                                        require_once "../includes/connection.php";
                                        $sql = "SELECT `id`,`package`, `m_card` , `fname` ,`AddBy` , `sta_date`, 
                                        `exp_date`, `date` , `total` ,`pay`,`vat7`,`vat3`,`discount`,`price`, `status_code`
                                        FROM `member`
                                        WHERE date(date) LIKE '$date'
                                        AND `status` = 1
                                        ORDER BY id DESC";
                                        $stmt = $conndb->query($sql);
                                        $stmt->execute();
                                        $count = 1;
                                        foreach ($stmt as $row) {

                                                
                                       if ($row['status_code'] == 1 ) { ?>
                                            <tr style='text-decoration:line-through' class="bg-warning">
                                                <td><?= $count++?></td>
                                                <td><?= $row['package']?></td>
                                                <td><?= $row['m_card']?></td>
                                                <td><?= $row['fname']?></td>
                                                <td><?= date('d-m-Y , H:i:s', strtotime($row['date']))?></td>
                                                <td><?= $row['price'] ?></td>
                                                <td><?= $row['pay'] ?></td>
                                                <td><?= $row['discount'] ?></td>
                                                <td><?= $row['vat7'] ?></td>
                                                <td><?= $row['vat3'] ?></td>
                                                <td><?= 0 ?></td>
                                                <td><?= $row['AddBy'] ?></td>
                                            </tr>
                                        <?php } else { ?>
                                            <tr>
                                                <td><?= $count++?></td>
                                                <td><?= $row['package']?></td>
                                                <td><?= $row['m_card']?></td>
                                                <td><?= $row['fname']?></td>
                                                <td><?= date('d-m-Y , H:i:s', strtotime($row['date']))?></td>
                                                <td><?= $row['price'] ?></td>
                                                <td><?= $row['pay'] ?></td>
                                                <td><?= $row['discount'] ?></td>
                                                <td><?= $row['vat7'] ?></td>
                                                <td><?= $row['vat3'] ?></td>
                                                <td><?= number_format( $row['total'],2 ) ?></td>
                                                <td><?= $row['AddBy'] ?></td>

                                            </tr>
                                        <?php } ?>
                                            <?php $sum += (int)$row['total'];?>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="9"></td>
                                            <td>Total</td>
                                            <td><?= number_format($sum,2) ?></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                    <?php } else {?>
                                    <tbody>

                                    </tbody>
                                    <?php } ?>
                                </table>
                                <?php $conndb = null ; ?>
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