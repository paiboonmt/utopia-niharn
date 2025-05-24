<?php
$title = 'REPORT | APPLICATION';
include '../middleware.php';
$page = 'reportTicket';
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
                                        <input type="submit" name="search" class="btn btn-primary form-control" value="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php if (isset($_POST['search'])) { ?>
                            <h3>กำลังค้นหาข้อมูลวันที่ : <?= date('d-m-Y', strtotime($_POST['date'])) ?></h3>
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
                                            <th>Product</th>
                                            <th>name</th>
                                            <th>Type of Pay</th>
                                            <th>Discount</th>
                                            <th>Vat7%</th>
                                            <th>Vat3%</th>
                                            <th>Total Price</th>
                                            <th>Sale by</th>
                                            <th class="text-center">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($_POST['search'])) {
                                            $date = $_POST['date'];
                                            $sql = "SELECT 
                                                        O.id, 
                                                        O.ref_order_id, 
                                                        O.fname, 
                                                        O.comment, 
                                                        O.exp_date, 
                                                        O.sta_date,
                                                        O.pay, 
                                                        O.discount, 
                                                        O.vat7, 
                                                        O.vat3, 
                                                        O.total, 
                                                        O.price AS Oprice,
                                                        O.num_bill, 
                                                        O.date, 
                                                        M.AddBy, 
                                                        M.status_code, 
                                                        M.package, 
                                                        M.id AS mid, 
                                                        M.m_card, 
                                                        ORR.product_name, 
                                                        ORR.order_id
                                                    FROM 
                                                        `orders` O
                                                    JOIN 
                                                        `member` M ON M.m_card = O.ref_order_id
                                                    LEFT JOIN 
                                                        `order_details` ORR ON ORR.order_id = O.id
                                                    WHERE 
                                                        O.date >= '{$date}' AND O.date < DATE_ADD('{$date}', INTERVAL 1 DAY)
                                                    ORDER BY 
                                                        M.id DESC";
                                            $stmt = $conndb->query($sql);
                                            $stmt->execute();
                                            $check = $stmt->fetchAll();
                                            $count = 1;
                                            foreach ($check as $row) : ?>
                                                <?php if ($row['status_code'] == 5) { ?>
                                                    <tr class="bg-warning">
                                                        <td><?= $count++ ?></td>
                                                        <td><?= $row['ref_order_id'] ?></td>
                                                        <td><?= $row['num_bill'] ?></td>
                                                        <td><?= $row['fname'] ?></td>
                                                        <td><?= $row['pay'] ?></td>
                                                        <td><?= $row['discount'] ?></td>
                                                        <td><?= 0 ?></td>
                                                        <td><?= 0 ?></td>
                                                        <td><?= '0' ?></td>
                                                        <td><?= $row['AddBy'] ?></td>
                                                        <td class="text-center">
                                                            <a onclick="return confirm('คุณต้องการลบบิลจริงหรือ ?')" href="./recordticketSql.php?id=<?= $row['id'] ?>&act=delete" class="btn btn-danger btn-sm disabled"><i class="fas fa-trash"></i></a>
                                                            <a href="voidPrint.php?ref_order_id=<?= $row['ref_order_id'] ?>" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-print"></i></a>

                                                        </td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td><?= $count++ ?></td>
                                                        <td><?= $row['ref_order_id'] ?></td>
                                                        <td class="text-left">
                                                            <?php
                                                            $idd = $row['id'];
                                                            $checkRow = "SELECT product_name ,quantity , price as ppp  FROM `order_details` WHERE order_id = '$idd'";
                                                            $stmtCheckRow = $conndb->prepare($checkRow);
                                                            $stmtCheckRow->execute();
                                                            $rowCount = $stmtCheckRow->rowCount();
                                                            foreach ($stmtCheckRow as $A) : ?>
                                                                <?php echo $A['product_name'] . ' : ' . $A['ppp']  . ' ' . ' | ' . ' x ' . ' | ' . $A['quantity'] . '<br>'; ?>
                                                            <?php endforeach; ?>
                                                        </td>
                                                        <td><?= $row['fname'] ?></td>
                                                        <td style="width: 150px;"><?= $row['pay'] ?></td>
                                                        <td><?= $row['discount'] ?></td>
                                                        <td><?= $row['vat7'] ?></td>
                                                        <td><?= $row['vat3'] ?></td>
                                                        <td style="width: 170px;"><?= number_format($row['total'], 2) ?></td>
                                                        <td><?= $row['AddBy'] ?></td>
                                                        <td class="text-center">

                                                            <?php if ($_SESSION['username'] == 'admin') { ?>
                                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#id<?= $row['mid'] ?>">
                                                                    <i class="fas fa-ban"></i>
                                                                </button>
                                                            <?php } ?>

                                                            <a href="?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></a>

                                                            <a href="print/rePrintBil.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm" target="__blank"><i class="fas fa-print"></i></a>
                                                        </td>
                                                        <!-- Modal void item -->
                                                        <div class="modal fade" id="id<?= $row['mid'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Voice item : <?= $row['ref_order_id'] ?></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="NewvoiceTicket.php" method="post">


                                                                            <input type="hidden" name="comment" value="<?= $row['comment'] ?>">
                                                                            <input type="hidden" name="hostname " value="<?= $hostname ?>">

                                                                            <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">OrderId</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" disabled name="order_id" value="<?= $row['id'] ?>">
                                                                                <input type="hidden" class="form-control" name="order_id" value="<?= $row['id'] ?>">
                                                                            </div>

                                                                            <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">Card number</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" disabled name="ref_order_id" value="<?= $row['ref_order_id'] ?>">
                                                                                <input type="hidden" class="form-control" name="ref_order_id" value="<?= $row['ref_order_id'] ?>">
                                                                            </div>

                                                                            <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">Text id</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" disabled name="num_bill" value="<?= $row['num_bill'] ?>">
                                                                                <input type="hidden" class="form-control" name="num_bill" value="<?= $row['num_bill'] ?>">
                                                                            </div>

                                                                            <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">Customer name</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" disabled name="fname" value="<?= $row['fname'] ?>">
                                                                                <input type="hidden" class="form-control" name="fname" value="<?= $row['fname'] ?>">
                                                                            </div>

                                                                            <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">Create at</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" disabled name="date" value="<?= $row['date'] ?>">
                                                                                <input type="hidden" class="form-control" name="date" value="<?= $row['date'] ?>">
                                                                            </div>

                                                                            <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">Price of ordered</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" disabled name="price" value="<?= $row['Oprice'] ?>">
                                                                                <input type="hidden" class="form-control" name="price" value="<?= $row['Oprice'] ?>">
                                                                            </div>

                                                                            <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">Payment</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" disabled name="pay" value="<?= $row['pay'] ?>">
                                                                                <input type="hidden" class="form-control" name="pay" value="<?= $row['pay'] ?>">
                                                                            </div>

                                                                            <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">Discount</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" disabled name="discount" value="<?= $row['discount'] ?>">
                                                                                <input type="hidden" class="form-control" name="discount" value="<?= $row['discount'] ?>">
                                                                            </div>

                                                                            <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">Vat7</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" disabled name="vat7" value="<?= $row['vat7'] ?>">
                                                                                <input type="hidden" class="form-control" name="vat7" value="<?= $row['vat7'] ?>">
                                                                            </div>

                                                                            <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">Vat3</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" disabled name="vat3" value="<?= $row['vat3'] ?>">
                                                                                <input type="hidden" class="form-control" name="vat3" value="<?= $row['vat3'] ?>">
                                                                            </div>

                                                                            <div class="input-group mb-1">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">Total Amount</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" disabled name="total" value="<?= $row['total'] ?>">
                                                                                <input type="hidden" class="form-control" name="total" value="<?= $row['total'] ?>">
                                                                            </div>

                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="">Date Start || Expired date</span>
                                                                                </div>
                                                                                <input type="text" class="form-control" disabled value="<?= $row['sta_date'] ?> || <?= $row['exp_date'] ?> ">
                                                                                <input type="hidden" class="form-control" name="sta_date" value="<?= $row['sta_date'] ?>">
                                                                                <input type="hidden" class="form-control" name="exp_date" value="<?= $row['exp_date'] ?>">
                                                                            </div>

                                                                            <input type="hidden" class="form-control" name="user" value="<?= $_SESSION['username'] ?>">

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="submit" name="voice" class="btn btn-danger col-7" value="Voicie" onclick="return confirm('Are your sure delete it ?')">
                                                                        <button type="button" class="btn btn-secondary col-4" data-dismiss="modal">ยกเลิก</button>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
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