<?php
$title = 'วิธีการชำระ';
include 'middleware.php';
$page = 'payment';
require_once '../includes/connection.php';
$stmt = $conndb->query("SELECT * FROM `payment`");
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
                    <div class="modal fade" id="addItem" tabindex="-1" role="dialog"
                        aria-labelledby="addItemTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Insert Payment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="./payment/sql.php" method="post">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Payment Type</span>
                                            </div>
                                            <input type="text" class="form-control" name="pay_name" required value="Test">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Value</span>
                                            </div>
                                            <input type="number" class="form-control" name="value" value="0" required>
                                        </div>
                                        <input type="submit" name="add" value="SAVE" class="form-control btn btn-success">
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
                                        <button style="width: 250px; text-transform: uppercase;" type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#addItem">
                                            <i class="fas fa-plus"></i> | เพื่มวิธีการชำระ
                                        </button>
                                    </div>
                                    <div class="col-sm-6"><span style="float: right; text-transform: uppercase;">
                                            <h3>การชำระเงิน</h3>
                                        </span></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm" id="example1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ประเภทการชำระเงิน</th>
                                            <th class="text-center">ค่า | ภาษี</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($stmt as $row) :
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $row['pay_name'] ?></td>
                                                <td class="text-center"><?= $row['value'] ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#id<?= $row['pay_id'] ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <?php if ($_SESSION['role'] == 'admin') { ?>
                                                        <button class="btn btn-sm btn-danger trash" id="<?= $row['pay_id'] ?>"><i class="fas fa-trash-alt"></i></button>
                                                    <?php } ?>
                                                </td>

                                                <!-- Modal -->
                                                <div class="modal fade" id="id<?= $row['pay_id'] ?>" tabindex="-1" role="dialog"
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

                                                                <form action="./payment/sql.php" method="post">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">Payment Type</span>
                                                                        </div>
                                                                        <input type="text" class="form-control" name="pay_name" value="<?= $row['pay_name'] ?>">
                                                                    </div>
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">Value</span>
                                                                        </div>
                                                                        <input type="number" class="form-control" name="value" value="<?= $row['value'] ?>">
                                                                    </div>
                                                                    <input type="hidden" name="pay_id" value="<?= $row['pay_id'] ?>">
                                                                    <input type="submit" name="update" value="UPDATE" class="form-control btn btn-success">
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

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["excel"],
            "stateSave": true
        });
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
                        url: "./payment/sql.php",
                        type: "POST",
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

</body>

</html>
<?php $conndb = null; ?>