<?php
    session_start();
    include('../middleware.php');
    $title = 'REPORT | APPLICATION';
    $page = 'reportBetway';
    $data = null ;
?>
<!DOCTYPE html>
<html lang="en">

<?php include('./header.php') ?>

<body class="hold-transition sidebar-mini">
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
                                                <span class="input-group-text"> เริ่มวันที่ </span>
                                            </div>
                                            <input type="date" name="sdate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> เริ่มวันที่ </span>
                                            </div>
                                            <input type="date" name="edate" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <input type="submit" name="search" class="btn btn-primary form-control"
                                            value="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card p-2">
                                <table id="example1" class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Time</th>
                                            <th>card id</th>
                                            <th>Name</th>
                                            <th hidden>Email</th>
                                            <th hidden>Nationalty</th>
                                            <th hidden>Address</th>
                                            <th>Packages</th>
                                            <th hidden>Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (isset($_POST['search'])) {
                                                require_once '../../includes/connection.php';
                                                $sdate = $_POST['sdate'];
                                                $edate = $_POST['edate'];
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
                                                BETWEEN '$sdate' AND '$edate'
                                                GROUP BY `ref_m_card` ");
                                                $stmt->execute();
                                                $data = $stmt->fetchAll();
                                                foreach ($data as $row) : ?>
                                                <tr>
                                                    <td> <?=date('d-m-Y | H:s:i',strtotime($row['time'])) ?> </td>
                                                    <td> <?= $row['ref_m_card'] ?> </td>
                                                    <td> <?= $row['fname'] ?> </td>
                                                    <td hidden> <?= $row['email'] ?> </td>
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
                                                    <td hidden> <?= $row['phone'] ?> </td>
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