<?php
$printerName = "POS"; // เปลี่ยนตามชื่อเครื่องปริ้นใน Windows
$filePath = "./test.text"; // เปลี่ยน path ให้ถูกต้อง

// สั่งพิมพ์
$cmd = "print /D:\"$printerName\" \"$filePath\"";
exec($cmd, $output, $status);

if ($status === 0) {
    echo "ส่งพิมพ์เรียบร้อย";
} else {
    echo "พิมพ์ไม่สำเร็จ: " . implode("\n", $output);
}
?>
