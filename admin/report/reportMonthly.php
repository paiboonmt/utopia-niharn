<?php
    include('../middleware.php');
    $title = 'REPORT | APPLICATION';
    $page = 'reportMonthly';
    $month = date('m');
    $data = null;
?>
<!DOCTYPE html>
<html lang="en">

<?php include('./header.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include './aside.php' ?>
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
                                                <span class="input-group-text">Choose</span>
                                            </div> 
                                            <input type="month" name="month" class="form-control" value="<?= $month ?>">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <input type="submit" name="search" class="btn btn-primary form-control" value="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="col">
                            <div class="card p-2">
                                <table id="example1" class="table  table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Time</th>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th hidden>Nationality</th>
                                            <th hidden>Address</th>
                                            <th>Packages</th>
                                            <th>Start</th>
                                            <th>Exprired</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (isset($_POST['search'])) {
                                                require_once '../../includes/connection.php';
                                                $month = $_POST['month'];
                                                $stmt = $conndb->query("SELECT T.time,T.ref_m_card,
                                                M.fname,M.email,M.nationalty,M.accom,
                                                M.package,
                                                M.status_code ,M.sta_date , 
                                                M.exp_date ,M.sex , M.type_fighter ,
                                                p.product_name ,
                                                p.id
                                                FROM `tb_time` AS T
                                                LEFT JOIN member AS M ON T.ref_m_card = M.m_card
                                                LEFT JOIN products AS p ON M.package = p.id
                                                WHERE `time`
                                                LIKE '%$month%' AND `status_code`!= 1 
                                                GROUP BY M.fname");
                                                 
                                                $stmt->execute();
                                                $data = $stmt->fetchAll();
                                            
                                        foreach ($data as $row) : ?>
                                            <tr>
                                                <td> <?= date('d-m-Y | H:s:i', strtotime($row['time'])) ?> </td>
                                                <td> <?= $row['ref_m_card'] ?> </td>
                                                <td> <?= $row['fname'] ?> </td>
                                                <td hidden> <?= $row['nationalty'] ?> </td>
                                                <td hidden> <?= $row['accom'] ?> </td>
                                                <td>
                                                   <?php
                                                        if ( $row['status_code'] == 2 ) {
                                                           echo $row['package'];
                                                        } else if ( $row['status_code'] == 4) {
                                                           echo $row['product_name'];
                                                        } elseif ( $row['status_code'] == 3 ) {
                                                            echo $row['type_fighter'];
                                                        }
                                                   ?>
                                                </td>
                                                <td> <?= $row['sta_date'] ?> </td>
                                                <td> <?= $row['exp_date'] ?> </td>
                                            </tr>
                                        <?php endforeach; } ?>
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

</body>
</html>
<?php $conndb = null; ?>