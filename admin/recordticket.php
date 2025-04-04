<?php
    session_start();
    $title = 'REPORT TICKET | APPLICATION';
    include './middleware.php';
    $page = 'recordticket';
    $hostname = gethostname();
    unset($_SESSION['total']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.jpg">
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

                    <div class="row">
                        <div class="col-md-12 p-1">
                            <div class="card p-3">
                                <table class="table table-sm" id="example1">
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
                                        <?php
                                            $date = date('Y-m-d');
                                            $sql = "SELECT orders.id , orders.ref_order_id , orders.fname ,
                                            orders.pay ,  orders.price ,orders.discount , orders.vat7 , orders.vat3 , orders.total , 
                                            orders.num_bill, member.AddBy , member.status_code, member.package ,orders.date , member.id AS mid,
                                            member.m_card , orders.sta_date , orders.exp_date , orders.comment 
                                            FROM `member` , `orders` 
                                            WHERE member.m_card = orders.ref_order_id
                                            AND orders.date LIKE '%$date%'
                                            GROUP BY member.m_card
                                            ORDER BY member.id DESC";
                                            $stmt = $conndb->query($sql);
                                            $stmt->execute();
                                            $count = 1;
                                            foreach ($stmt as $row) {
                                            if ( $row['status_code'] == 5 ) { ?>
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
                                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#id<?= $row['id'] ?>">
                                                        <i class="fas fa-ban"></i>
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="recordticketEdit.php?id=<?=$row['id']?>" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="./cart/print/rePrintBil.php?id=<?= $row['id']?>" class="btn btn-info btn-sm"><i class="fas fa-print"></i></a>
                                                    </td>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="id<?=$row['id']?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Voice item : <?= $row['ref_order_id'] ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="./NewvoiceTicket.php" method="post">

                                                                 
                                                                    <input type="hidden" name="comment" value="<?= $row['comment'] ?>">
                                                                    <input type="hidden" name="hostname " value="<?= $hostname ?>">

                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">OrderId</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" disabled  name="order_id" value="<?= $row['id'] ?>">
                                                                    <input type="hidden" class="form-control"   name="order_id" value="<?= $row['id'] ?>">
                                                                </div>

                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Card number</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" disabled  name="ref_order_id" value="<?= $row['ref_order_id'] ?>">
                                                                    <input type="hidden" class="form-control"   name="ref_order_id" value="<?= $row['ref_order_id'] ?>">
                                                                </div>
                                                                    
                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Text id</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" disabled  name="num_bill" value="<?= $row['num_bill'] ?>">
                                                                    <input type="hidden" class="form-control"   name="num_bill" value="<?= $row['num_bill'] ?>">
                                                                </div>
                                                                    
                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Customer name</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" disabled  name="fname" value="<?= $row['fname'] ?>">
                                                                    <input type="hidden" class="form-control"   name="fname" value="<?= $row['fname'] ?>">
                                                                </div>

                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Create at</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" disabled  name="date" value="<?= $row['date'] ?>">
                                                                    <input type="hidden" class="form-control"   name="date" value="<?= $row['date'] ?>">
                                                                </div>

                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Price of ordered</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" disabled  name="price" value="<?= $row['price'] ?>">
                                                                    <input type="hidden" class="form-control"   name="price" value="<?= $row['price'] ?>">
                                                                </div>
                                                                   
                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Payment</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" disabled  name="pay" value="<?= $row['pay'] ?>">
                                                                    <input type="hidden" class="form-control"   name="pay" value="<?= $row['pay'] ?>">
                                                                </div>
                                                                   
                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Discount</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" disabled  name="discount" value="<?= $row['discount'] ?>">
                                                                    <input type="hidden" class="form-control"   name="discount" value="<?= $row['discount'] ?>">
                                                                </div>
                                                                   
                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Vat7</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" disabled  name="vat7" value="<?= $row['vat7'] ?>">
                                                                    <input type="hidden" class="form-control"   name="vat7" value="<?= $row['vat7'] ?>">
                                                                </div>
                                                                   
                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Vat3</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" disabled  name="vat3" value="<?= $row['vat3'] ?>">
                                                                    <input type="hidden" class="form-control"  name="vat3" value="<?= $row['vat3'] ?>">
                                                                </div>

                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Total Amount</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" disabled  name="total" value="<?= $row['total'] ?>">
                                                                    <input type="hidden" class="form-control"   name="total" value="<?= $row['total'] ?>">
                                                                </div>

                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="">Date Start || Expired date</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" disabled value="<?= $row['sta_date'] ?> || <?= $row['exp_date'] ?> ">
                                                                    <input type="hidden" class="form-control"   name="sta_date" value="<?= $row['sta_date'] ?>">
                                                                    <input type="hidden" class="form-control"   name="exp_date" value="<?= $row['exp_date'] ?>">
                                                                </div>

                                                                <input type="hidden" class="form-control"   name="user" value="<?= $_SESSION['username'] ?>">
                                                                
                                                            </div>
                                                                <div class="modal-footer">
                                                                    <input type="submit" name="voice" class="btn btn-danger col-7"  value="Voicie" onclick="return confirm('Are your sure delete it ?')" >
                                                                    <button type="button" class="btn btn-secondary col-4" data-dismiss="modal">ยกเลิก</button>
                                                                </div>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </tr>
                                            <?php  } ?>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <!-- ประเภทการชำระ -->
                        <div class="col-md-4">
                            <div class="card p-2">
                                <div class="card-header">
                                    ประเภทการชำระ
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm" id="tablePay">
                                        <thead>
                                            <th>ประเภท</th>
                                            <th class="text-center">จำนวนครั้ง</th>
                                            <th class="text-right">ยอดขายรวม</th>
                                        </thead>
                                        <tbody>
                                                <?php 
                                                $date = date('Y-m-d');
                                                $sqlCash = $conndb->query("SELECT  `pay` , COUNT(pay) AS count , SUM(total) AS sum  
                                                FROM `orders` 
                                                WHERE `date` LIKE '%$date%' 
                                                GROUP BY `pay`");
                                                $sqlCash->execute();
                                                $total = 0;
                                                foreach ( $sqlCash AS $rowCash ) :?>
                                                <tr>
                                                    <td><?= $rowCash['pay'] ?></td>
                                                    <td class="text-center"><?= $rowCash['count'] ?></td>
                                                    <td class="text-right"><?= number_format($rowCash['sum'],2) ?></td>
                                                </tr>
                                                <?php $total = $total += $rowCash['sum'] ?>
                                                <?php endforeach ?> 
                                                <tr>
                                                    <th>ยอดรวมทั้งหมด</th>
                                                    <th></th>
                                                    <th class="text-right"><?= number_format($total,2) ?></th>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- ส่วนลด -->
                        <div class="col-md-4">
                            <div class="card p2">
                                <div class="card-header">
                                    ส่วนลด
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm" id="discount">
                                        <thead>
                                            <th>หมายเลขบิล</th>
                                            <th class="text-right">ส่วนลด</th>
                                            <th class="text-right">จำนวนส่วนลด</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $totalDis = 0;
                                                $date = date("Y-m-d");
                                                $sqlDis = "SELECT `num_bill`,`fname`,`discount`,`price`
                                                FROM `orders` 
                                                WHERE  `discount` > 0  AND`date` LIKE '%$date%'";
                                                $stmtDis = $conndb->query($sqlDis);
                                                $stmtDis->execute();
                                                foreach ( $stmtDis AS $rowDis ) :?>
                                                <tr>
                                                    <td><?= $rowDis['num_bill'] ?></td>
                                                    <td class="text-right"><?= $rowDis['discount'] ?> % </td>
                                                    <td class="text-right"><?= number_format(($rowDis['price'] * $rowDis['discount']) / 100 ,2 )  ?></td>
                                                </tr>
                                                <?php $totalDis = $totalDis += ($rowDis['price'] * $rowDis['discount']) / 100 ?>
                                                <?php endforeach ?>
                                                <tr>
                                                    <td colspan="2">ยอดรวมทั้งหมด</td>
                                                    <td class="text-right"><?= number_format($totalDis,2) ?></td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- รายการขายสินค้า -->
                        <div class="col-md-4">
                            <div class="card p-2">
                                <div class="card-header">
                                    รายการขายสินค้า
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm" id="tableProduct">
                                        <thead>
                                            <th>ประเภท</th>
                                            <th class="text-right">จำนวนครั้ง</th>
                                        </thead>
                                        <tbody>
                                                <?php
                                                $date = date('Y-m-d');
                                                $sqlProduct = "SELECT `product_name`, COUNT(product_name) AS count , 
                                                od.total AS od ,o.total AS o , o.date
                                                FROM `orders` AS o
                                                INNER JOIN `order_details` AS od
                                                ON od.order_id = o.id
                                                WHERE o.date LIKE '%$date%'
                                                GROUP BY od.product_name";
                                                $stmtProduct = $conndb->query($sqlProduct);
                                                $stmtProduct->execute();
                                                $totalProduct = 0;
                                                foreach ( $stmtProduct AS $rowProduct ) :?>
                                                <tr>
                                                    <td><?= $rowProduct['product_name'] ?></td>
                                                    <td class="text-right"><?= $rowProduct['count'] ?></td>
                                                </tr>
                                                <?php endforeach ?> 
                                                <tr>
                                                    <td colspan="1">ยอดรวมทั้งหมด</td>
                                                    <th class="text-right"><?= number_format($total,2) ?></th>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
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

     <?php if ( isset($_SESSION['canotFind']) ) : ?> 
        <script>
            Swal.fire({
                title: "This number was not found.",
                text: "You clicked the button!",
                icon: "warning"
            });
        </script>
     <?php endif; unset($_SESSION['canotFind'])  ?> 
    
    <script>
       
        $(function() {
            $("#example1").DataTable({
                "pageLength" : 5,
                "buttons": ["excel"],
                "stateSave": true,
                
            });
        });
        $(function() {
            $("#tablePay").DataTable({
                "pageLength" : 8,
                "searching": false,
                "info":     false,
                "dom": 'rtip'
            });
        });
        $(function() {
            $("#tableProduct").DataTable({
                "pageLength" : 8,
                "searching": false,
                "info":     false,
                "dom": 'rtip'
            });
        });
        $(function() {
            $("#discount").DataTable({
                "pageLength" : 8,
                "searching": false,
                "info":     false,
                "dom": 'rtip'
            });
        });
    </script>
</body>
</html>
<?php $conndb = null;?>