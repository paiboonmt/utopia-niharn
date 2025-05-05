<?php
$title = 'สินค้าและบริการ';
include 'middleware.php';
$page = 'product';

require_once("../includes/connection.php");
$stmt = $conndb->query("SELECT * FROM `products` ORDER BY  `id` DESC");
$stmt->execute();

include './layout/header.php';
?>

    <div class="wrapper">
        <?php include './aside.php' ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <!-- Modal -->
                        <div class="modal fade" id="addItem" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="addItemTitle" aria-hidden="true">
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

                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">ประเภทกลุ่มสินค้า</span>
                                                </div>
                                                <select name="product_type" class="form-control" required>
                                                    <option value="" disabled selected>-- กรุณาเลือก --</option>
                                                    <option value="1">ประเภท ไม่นับจำนวนครั้ง</option>
                                                    <option value="2">ประเภท นับจำนวนครั้ง</option>
                                                </select>
                                            </div>

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
                                                <i class="fas fa-plus"></i> | เพื่มสินค้าบริการ
                                            </button>
                                        </div>
                                        <div class="col-sm-6">
                                            <span style="float: right;">
                                                <h3>สินค้าและบริการ</h3>
                                            </span>
                                        </div>
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
                                                <th class="text-center">ประเภท</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;

                                            foreach ($stmt as $row) :
                                            ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $row['product_name'] ?></td>
                                                    <td><?= number_format($row['price'], 2) ?></td>
                                                    <td><?= $row['value'] ?></td>
                                                    <td class="text-center">
                                                        <?php if ($row['product_type'] == 1) : ?>
                                                            <span class="badge badge-success">ประเภท ไม่นับจำนวนครั้ง</span>
                                                        <?php elseif ($row['product_type'] == 2) : ?>
                                                            <span class="badge badge-warning">ประเภท นับจำนวนครั้ง</span>
                                                        <?php endif ?>

                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#id<?= $row['id'] ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <?php  if ( $_SESSION['role'] == 'admin') : ?>
                                                            <button class="btn btn-sm btn-danger trash" id="<?= $row['id'] ?>"><i class="fas fa-trash-alt"></i></button>
                                                        <?php endif ?>
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

    <?php include './layout/footer.php'; ?>

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