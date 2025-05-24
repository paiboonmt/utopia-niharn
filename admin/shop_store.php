<?php
$title = 'สินค้า อุปกรณ์ และ เครื่องดื่ม | ร้านค้า';
include 'middleware.php';
$page = 'store';
require_once("../includes/connection.php");
require_once './shop/function_shop.php'; // เรียกใช้ฟังก์ชัน
include './layout/header.php';

// ดึงข้อมูลสินค้าจากฐานข้อมูล
$products = getDataStore($conndb);

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    if (deleteProduct($conndb, $id)) {
        $_SESSION['DeleteSuccess'] = true;
        header("Location: shop_store.php");
        exit();
    }
}

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
                                        <a href="./shop_create.php" class="btn btn-info" style="width: 250px; text-transform: uppercase;">
                                            <i class="fas fa-plus"></i> | เพื่มรายการสินค้า
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <span style="float: right;">
                                            <h3>รายการสินค้า</h3>
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
                                            <th>รายละเอียด</th>
                                            <th>ราคา</th>
                                            <th>จำนวน</th>
                                            <th>รูปภาพ</th>
                                            <th>การจัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($products)): ?>
                                            <?php foreach ($products as $index => $product): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                                    <td><?= htmlspecialchars($product['description']) ?></td>
                                                    <td><?= number_format($product['price'], 2) ?> บาท</td>
                                                    <td><?= $product['quantity'] ?></td>
                                                    <td>
                                                        <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" alt="รูปภาพสินค้า" style="width: 50px; height: 50px; object-fit: cover;">
                                                    </td>
                                                    <td>
                                                        <a href="./shop_edit.php?id=<?= $product['id'] ?>" class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="?action=delete&id=<?= $product['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('คุณต้องการลบสินค้านี้หรือไม่?');">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">ไม่มีข้อมูลสินค้า</td>
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

<?php if (isset($_SESSION['UpdateSuccess'])) : ?>
    <script>
        Swal.fire({
            toast: true,
            showConfirmButton: false,
            timer: 2000,
            icon: 'success',
            title: 'Update item successfully!'
        });
    </script>
<?php endif;
unset($_SESSION['UpdateSuccess']); ?>

<?php if (isset($_SESSION['CreateSuccess'])) : ?>
    <script>
        Swal.fire({
            toast: true,
            showConfirmButton: false,
            timer: 2000,
            icon: 'success',
            title: 'Create item successfully!'
        });
    </script>
<?php endif;
unset($_SESSION['CreateSuccess']); ?>

<?php if (isset($_SESSION['DeleteSuccess'])) : ?>
    <script>
        Swal.fire({
            toast: true,
            showConfirmButton: false,
            timer: 2000,
            icon: 'success',
            title: 'Delete item successfully!'
        });
    </script>
<?php endif;
unset($_SESSION['DeleteSuccess']); ?>