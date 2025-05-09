<?php
$title = 'สินค้า อุปกรณ์ และ เครื่องดื่ม | ร้านค้า';
include 'middleware.php';
$page = 'store';

require_once("../includes/connection.php");
include './layout/header.php';

// ตรวจสอบการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once './shop/function_shop.php';

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/'; // โฟลเดอร์สำหรับเก็บไฟล์ภาพ
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        // สร้างชื่อไฟล์ใหม่โดยอ้างอิงเวลาและเลขสุ่ม 10 ตัว
        $newFileName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $fileExtension;

        // ตรวจสอบและสร้างโฟลเดอร์หากยังไม่มี
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destPath = $uploadDir . $newFileName;

        // ย้ายไฟล์ไปยังโฟลเดอร์ที่กำหนด
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // บันทึกข้อมูลลงฐานข้อมูล
            if (createDataStore($conndb, $name, $description, $price, $quantity, $newFileName)) {
                $_SESSION['CreateSuccess'] = true; // ตั้งค่าความสำเร็จ
                header("Location: shop_store.php");
                exit;
            }
        } 
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
                                เพื่มรายการสินค้า
                            </div>
                            <div class="card-body">
                                <?php if (isset($successMessage)): ?>
                                    <div class="alert alert-success"><?= $successMessage ?></div>
                                <?php endif; ?>
                                <?php if (isset($errorMessage)): ?>
                                    <div class="alert alert-danger"><?= $errorMessage ?></div>
                                <?php endif; ?>

                                <form method="POST" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="name">ชื่อสินค้า</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">รายละเอียดสินค้า</label>
                                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="price">ราคา</label>
                                                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="quantity">จำนวน</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                                            </div>
                                            <button type="submit" class="btn btn-success">บันทึก</button>
                                            <a href="shop_list.php" class="btn btn-secondary">ยกเลิก</a>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="image">รูปภาพสินค้า</label>
                                                <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                                            </div>
                                            <div class="form-group">
                                                <img id="imagePreview" src="#" alt="ตัวอย่างรูปภาพ" style="max-width: 100%; height: auto; display: none; border: 1px solid #ddd; padding: 5px;">
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
        } else {
            preview.src = '#';
            preview.style.display = 'none'; // ซ่อนภาพตัวอย่าง
        }
    }
</script>
</body>

</html>
<?php $conndb = null; ?>