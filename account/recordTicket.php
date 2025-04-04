<?php
    session_start();
    $title = 'REPORT | APPLICATION';
    include './middleware.php';
    include("../includes/connection.php");
    $page = 'recordticket';
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
                    <div class="row p-2">
                        <div class="col-8 p-2 mx-auto">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Choose</span>
                                            </div>
                                            <input type="date" name="date" class="form-control" required value="<?= $date ?>">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <input type="submit" name="search" class="btn btn-primary form-control"
                                            value="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php if (isset($_POST['search'])) {?>
                            <h3>กำลังค้นหาข้อมูลวันที่ : <?= date('d-m-Y' , strtotime($_POST['date'])) ?></h3>
                        <?php } ?>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card p-2">
                                <table id="example1" class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Card id</th>
                                            <th>Text id</th>
                                            <th>name</th>
                                            <th>Type of Pay</th>
                                            <th>Discount</th>
                                            <th>Vat7%</th>
                                            <th>Vat3%</th>
                                            <th>Total Price</th>
                                            <th>Sale by</th>
                                            <th class="text-center">Void</th>
                                            <th class="text-center">Edit</th>
                                            <th class="text-center">Print</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($_POST['search'])) {

                                                $date = $_POST['date'];
                                                
                                                $sql = "SELECT orders.id , orders.ref_order_id , orders.fname ,
                                                orders.pay ,  orders.price ,orders.discount , orders.vat7 , orders.vat3 , orders.total , 
                                                orders.num_bill, member.AddBy , member.status_code, member.package ,orders.date , member.id AS mid,
                                                member.m_card
                                                FROM `member` , `orders` 
                                                WHERE member.m_card = orders.ref_order_id
                                                AND orders.date LIKE '%$date%'
                                                GROUP BY member.m_card
                                                ORDER BY member.id DESC ";

                                                $stmt = $conndb->query($sql);
                                                $stmt->execute();
                                                $count = 1;
                                                foreach ($stmt as $row) : ?>

                                        <?php if ( $row['status_code'] == 5 ) { ?>
                                                <tr class="bg-warning">
                                                    <td><?= $count++?></td>
                                                    <td><?= $row['m_card']?></td>
                                                    <td><?= $row['num_bill']?></td>
                                                    <td><?= $row['fname']?></td>
                                                    <td><?= $row['pay'] ?></td>
                                                    <td><?= $row['discount'] ?></td>
                                                    <td><?= 0 ?></td>
                                                    <td><?= 0 ?></td>
                                                    <td><?= '0' ?></td>
                                                    <td><?= $row['AddBy'] ?></td>
                                                    <td class="text-center">
                                                        <a onclick="return confirm('คุณต้องการลบบิลจริงหรือ ?')" href="./recordticketSql.php?id=<?= $row['id']?>&act=delete" class="btn btn-danger btn-sm disabled"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                    <td class="text-center disabled"><i class="far fa-edit"></i></td>
                                                    <td colspan="3" class="text-center">
                                                        <a href="./voidPrint.php?ref_order_id=<?=$row['ref_order_id']?>" class="btn btn-info btn-sm"><i class="fas fa-print"></i></a>
                                                    </td>
                                                </tr>
                                        <?php } else { ?>
                                            <tr>
                                            <td><?= $count++?></td>
                                                    <td><?= $row['ref_order_id']?></td>
                                                    <td class="text-left">
                                                        <?php 
                                                            $idd = $row['id'];
                                                            $checkRow = "SELECT product_name , quantity , price as ppp  FROM `order_details` WHERE order_id = '$idd'";
                                                            $stmtCheckRow = $conndb->prepare($checkRow);
                                                            $stmtCheckRow->execute();
                                                            $rowCount = $stmtCheckRow->rowCount();
                                                            foreach ( $stmtCheckRow AS $A ) : ?>
                                                                 <?php echo $A['product_name'] .' : '.$A['ppp']  .' '. ' | ' .' x '. ' | ' . $A['quantity']. '<br>'; ?> 
                                                           <?php endforeach; ?> 
                                                    </td>
                                                    <td><?= $row['fname']?></td>
                                                    <td style="width: 150px;"><?= $row['pay'] ?></td>
                                                    <td><?= $row['discount'] ?></td>
                                                    <td><?= $row['vat7'] ?></td>
                                                    <td><?= $row['vat3'] ?></td>
                                                    <td style="width: 170px;"><?= number_format( $row['total'],2 ) ?></td>
                                                    <td><?= $row['AddBy'] ?></td>
                                                <td class="text-center">
                                                    <a onclick="return confirm('Are your sure delete it ?')" href="voiceTicket.php?id=<?=$row['mid']?>&action=voice" class="btn btn-sm btn-danger disabled"><i class="fas fa-ban"></i></i></a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="recordticketEdit.php?id=<?=$row['id']?>" target="_blank" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="print/rePrintBil.php?id=<?= $row['id']?>" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-print"></i></a>
                                                </td>
                                            </tr>
                                        <?php  } ?>
                                        <?php endforeach ?>
                                        <?php } ?>
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

    <script>
    $(function() {
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
    });
    </script>
</body>

</html>

<?php $conndb = null; ?>