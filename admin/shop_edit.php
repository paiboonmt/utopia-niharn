<?php
$title = 'แก้ไขสินค้า | ร้านค้า';
include 'middleware.php';
$page = 'store';

require_once("../includes/connection.php");
require_once './shop/function_shop.php'; // เรียกใช้ฟังก์ชัน
include './layout/header.php';

// ตรวจสอบว่ามีการส่ง ID ของสินค้า
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: shop_store.php");
    exit;
}

$id = $_GET['id'];

// ดึงข้อมูลสินค้าจากฐานข้อมูล
$product = viewDataStore($conndb, $id);

if (!$product) {
    header("Location: shop_store.php");
    exit;
}

// ตรวจสอบการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = $product['image']; // เก็บชื่อไฟล์รูปภาพเดิม

    // ตรวจสอบว่ามีการอัปโหลดไฟล์ใหม่หรือไม่
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newFileName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $fileExtension;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destPath = $uploadDir . $newFileName;

        // ย้ายไฟล์ใหม่ไปยังโฟลเดอร์ที่กำหนด
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // ลบไฟล์รูปภาพเก่า หากมี
            if (!empty($product['image'])) {
                $oldImagePath = $uploadDir . $product['image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // ลบไฟล์เก่า
                }
            }

            $image = $newFileName; // ใช้ชื่อไฟล์ใหม่
        }
    }

    // อัปเดตข้อมูลสินค้าในฐานข้อมูล
    if (updateDataStore($conndb, $id, $name, $description, $price, $quantity, $image)) {
        $_SESSION['UpdateSuccess'] = true; // ตั้งค่าความสำเร็จ
        header("Location: shop_store.php");
        exit;
    } else {
        $errorMessage = "เกิดข้อผิดพลาดในการแก้ไขสินค้า.";
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
                                แก้ไขสินค้า
                            </div>
                            <div class="card-body">


                                <form method="POST" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="name">ชื่อสินค้า</label>
                                                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">รายละเอียดสินค้า</label>
                                                <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="price">ราคา</label>
                                                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $product['price'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="quantity">จำนวน</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" value="<?= $product['quantity'] ?>" required>
                                            </div>
                                            <button type="submit" class="btn btn-success">บันทึก</button>
                                            <a href="shop_store.php" class="btn btn-secondary">ยกเลิก</a>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="image">รูปภาพสินค้า</label>
                                                <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                                            </div>
                                            <div class="form-group">
                                                <img id="imagePreview" src="../uploads/<?= htmlspecialchars($product['image']) ?>" alt="ตัวอย่างรูปภาพ" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // แสดงภาพตัวอย่าง
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</body>

</html>
<?php $conndb = null; ?>