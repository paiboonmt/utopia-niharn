<?php
  session_start();
  $title = 'PRODUCT | APPLICATION';
  include 'middleware.php';
  $page = 'product'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.jpg">
    <title><?=$title?></title>
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../dist/css/font.css">
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

                        <!-- Modal -->
                        <div class="modal fade" id="addItem" tabindex="-1" role="dialog"
                            aria-labelledby="addItemTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">เพื่มสินค้าบริการ</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="./productSql.php" method="post">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">ชื่อสินค้าบริการ</span>
                                                </div>
                                                <input type="text" class="form-control" name="product_name" autofocus required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">ราคา</span>
                                                </div>
                                                <input type="number" class="form-control" name="price">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">โค๊คสินค้า</span>
                                                </div>
                                                <input type="number" name="code" class="form-control" value="0">
                                            </div>
                                            <div class="input-group mb-3">
                                                <textarea class="form-control" name="detail" rows="5" placeholder="รายละเอียด"></textarea>
                                            </div>
                                            <input type="submit" name="saveProduct" value="บันทึก" class="form-control btn btn-success">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card mt-2">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#addItem">
                                                เพื่มสินค้าบริการ
                                            </button>
                                        </div>
                                        <div class="col-sm-6"><span style="float: right;"><h3>รายการสินค้า</h3></span></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm" id="example1">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product name</th>
                                                <th>Price</th>
                                                <th>Details</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i=1;
                                                require_once("../includes/connection.php");
                                                $stmt = $conndb->query("SELECT * FROM `products` ORDER BY  `id` DESC");
                                                $stmt->execute();
                                                foreach ( $stmt AS $row ) : 
                                            ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $row['product_name']?></td>
                                                <td><?= number_format($row['price'],2)?></td>
                                                <td><?= substr($row['detail'],0,100).'.....' .'More'?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#id<?= $row['id'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="productSql.php?id=<?= $row['id'] ?>"class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                                                </td>

                                                <!-- Modal -->
                                                <div class="modal fade" id="id<?= $row['id'] ?>" tabindex="-1" role="dialog"
                                                    aria-labelledby="addItemTitle" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">เพื่มสินค้าบริการ</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="./productSql.php" method="post">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">ชื่อสินค้าบริการ</span>
                                                                        </div>
                                                                        <input type="text" class="form-control" name="product_name" value="<?= $row['product_name'] ?>">
                                                                    </div>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">ราคา</span>
                                                                        </div>
                                                                        <input type="number" class="form-control" name="price" value="<?= $row['price'] ?>">
                                                                    </div>
                                                                    <div class="input-group mb-3">
                                                                        <textarea class="form-control" name="detail" rows="5" placeholder="รายละเอียด"><?= $row['detail']?></textarea>
                                                                    </div>
                                                                    <input type="text" name="id" hidden value="<?= $row['id'] ?>">
                                                                    <input type="submit" name="updateProduct" value="อัปเดท" class="form-control btn btn-success">
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

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

    <?php if (isset($_SESSION['remove'])){ ?>
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                icon: 'success',
                title: 'remove successfully!'
            });
        </script>
    <?php } unset($_SESSION['remove']);?>

    <?php if (isset($_SESSION['add'])){ ?>
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                icon: 'success',
                title: 'Add item successfully!'
            });
        </script>
    <?php } unset($_SESSION['add']);?>

    <?php if (isset($_SESSION['update'])){ ?>
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                icon: 'success',
                title: 'Update item successfully!'
            });
        </script>
    <?php } unset($_SESSION['update']);?>

</body>
</html>
<?php $conndb = null; ?>