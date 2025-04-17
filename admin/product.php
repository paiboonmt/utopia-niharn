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
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.png">
    <title><?= $title ?></title>
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
        <?php include './aside.php' ?>
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
                                        <form action="./product/sql.php" method="post">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">ชื่อสินค้าบริการ</span>
                                                </div>
                                                <input type="text" class="form-control" name="product_name" value="Product Test" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">ราคา</span>
                                                </div>
                                                <input type="number" class="form-control" name="price" value="10" require>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">จำนวนครั้ง</span>
                                                </div>
                                                <input type="number" class="form-control" name="value" value="1" require>
                                            </div>

                                            <input type="submit" name="saveProduct" value="บันทึก" class="form-control btn btn-success">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card mt-2">
                                <div class="card-header bg-dark">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <button style="width: 250px; text-transform: uppercase;" type="button" class="btn btn-info" data-toggle="modal" data-target="#addItem">
                                                <i class="fas fa-plus"></i> | Add Product
                                            </button>
                                        </div>
                                        <div class="col-sm-6"><span style="float: right;">
                                                <h3>PRODUCTS</h3>
                                            </span></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm" id="example1">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ชื่อสินค้า</th>
                                                <th>ราคา</th>
                                                <th>จำนวนครั้ง</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            require_once("../includes/connection.php");
                                            $stmt = $conndb->query("SELECT * FROM `products` ORDER BY  `id` DESC");
                                            $stmt->execute();
                                            foreach ($stmt as $row) :
                                            ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $row['product_name'] ?></td>
                                                    <td><?= number_format($row['price'], 2) ?></td>
                                                    <td><?= $row['value'] ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#id<?= $row['id'] ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger trash" id="<?= $row['id'] ?>"><i class="fas fa-trash-alt"></i></button>
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
                                                                    <form action="./product/sql.php" method="post">
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
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">จำนวนครั้ง</span>
                                                                            </div>
                                                                            <input type="number" class="form-control" name="value" value="<?= $row['value'] ?>" require>
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
                // "buttons": ["excel"],
                "stateSave": true
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
        $(document).ready(function() {
            $(".trash").click(function() {
                let trash_id = $(this).attr("id");
                console.log(trash_id);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to do ?",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, I won to do !'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "./product/sql.php",
                            method: 'POST',
                            data: {
                                id: trash_id,
                                action: 'delete'
                            },
                            success: function(response) {
                                location.reload();
                            }
                        });
                    }
                });
            });
        });
    </script>

    <?php if (isset($_SESSION['remove'])) { ?>
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
    <?php }
    unset($_SESSION['remove']); ?>

    <?php if (isset($_SESSION['add'])) { ?>
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
    <?php }
    unset($_SESSION['add']); ?>

    <?php if (isset($_SESSION['update'])) { ?>
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
    <?php }
    unset($_SESSION['update']); ?>

</body>

</html>
<?php $conndb = null; ?>