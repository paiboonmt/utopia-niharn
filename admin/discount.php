<?php
$title = 'ส่วนลด';
include 'middleware.php';
$page = 'discount';
require_once("../includes/connection.php");
require_once './discount/function-discount.php'; // เรียกใช้ฟังก์ชัน

// ดึงข้อมูลส่วนลดจากฐานข้อมูล
$discounts = getDiscounts($conndb);

if (isset($_POST['create_discount'])) {
    $name = $_POST['name'];
    $amount = $_POST['amount'];

    if (createDiscount($conndb, $name, $amount)) {
        $_SESSION['CreateSuccess'] = true;
        header("Location: discount.php");
        exit();
    } else {
        $_SESSION['CreateError'] = true;
    }
}

if (isset($_POST['edit_discount'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $amount = $_POST['amount'];

    if (updateDiscount($conndb, $id, $name, $amount)) {
        $_SESSION['UpdateSuccess'] = true;
        header("Location: discount.php");
        exit();
    } else {
        $_SESSION['UpdateError'] = true;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    if (deleteDiscount($conndb, $id)) {
        $_SESSION['DeleteSuccess'] = true;
        header("Location: discount.php");
        exit();
    } else {
        $_SESSION['DeleteError'] = true;
    }
}

include './layout/header.php';
?>

<div class="wrapper">
    <?php include './aside.php' ?>
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mt-2">
                            <div class="card-header bg-dark">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn-outline-info btn" data-toggle="modal" data-target="#staticBackdrop" style="width: 250px; text-transform: uppercase;">
                                            <i class="fas fa-plus"></i> | เพื่มรายการส่วนลด
                                        </button>
                                       
                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="" method="post">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-dark">
                                                            <h5 class="modal-title">Modal title</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="discount_name">ชื่อส่วนลด</label>
                                                                <input type="text" class="form-control" name="name" placeholder="ชื่อส่วนลด" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="discount_amount">จำนวนส่วนลด</label>
                                                                <input type="number" class="form-control" name="amount" placeholder="จำนวนส่วนลด" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                                            <input type="submit" name="create_discount" value="สร้างส่วนลด" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <span style="float: right;">
                                            <h3>รายละเอียดส่วนลด</h3>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm" id="example1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อส่วนลด</th>
                                            <th>จำนวนส่วนลด</th>
                                            <th>การจัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($discounts)): ?>
                                            <?php foreach ($discounts as $index => $discount): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= htmlspecialchars($discount['name']) ?></td>
                                                    <td><?= $discount['amount'] ?> %</td>
                                                    
                                                    <td>
                                                        <!-- Edit Button trigger modal -->
                                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editDiscountModal<?= $discount['id'] ?>">
                                                            แก้ไข
                                                        </button>

                                                        <!-- Edit Modal -->
                                                        <div class="modal fade" id="editDiscountModal<?= $discount['id'] ?>" tabindex="-1" aria-labelledby="editDiscountModalLabel<?= $discount['id'] ?>" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form action="" method="post">
                                                                    <input type="hidden" name="id" value="<?= $discount['id'] ?>">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-warning">
                                                                            <h5 class="modal-title" id="editDiscountModalLabel<?= $discount['id'] ?>">แก้ไขส่วนลด</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label for="edit_name_<?= $discount['id'] ?>">ชื่อส่วนลด</label>
                                                                                <input type="text" class="form-control" id="edit_name_<?= $discount['id'] ?>" name="name" value="<?= htmlspecialchars($discount['name']) ?>" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="edit_amount_<?= $discount['id'] ?>">จำนวนส่วนลด</label>
                                                                                <input type="number" class="form-control" id="edit_amount_<?= $discount['id'] ?>" name="amount" value="<?= $discount['amount'] ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                                                            <input type="submit" name="edit_discount" value="บันทึก" class="btn btn-warning">
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <a href="?id=<?= $discount['id'] ?>&action=delete" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบส่วนลดนี้?')">ลบ</a>
                                                    </td>
                                                </tr> 
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">ไม่มีข้อส่วนลด</td>
                                            </tr>
                                        <?php endif; ?>
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
            "stateSave": true
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
</body>

</html>
<?php $conndb = null; ?>