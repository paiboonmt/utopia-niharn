<?php
$servername = "localhost";
$username = "admin"; // ชื่อผู้ใช้ของคุณ
$password = "9itonly"; // รหัสผ่านของคุณ
$dbname = "member"; // ชื่อฐานข้อมูลของคุณ

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// เช็คการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, product_name, price, quantity FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // แสดงข้อมูลสินค้า
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Product Name: " . $row["product_name"]. " - Price: " . $row["price"]. " - Quantity: " . $row["quantity"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
