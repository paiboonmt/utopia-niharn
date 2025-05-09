<?php

function getDataStore($conndb) {
    try {
        $sql = "SELECT * FROM store ORDER BY id ASC"; // ดึงข้อมูลทั้งหมดจากตาราง store
        $stmt = $conndb->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // ส่งคืนข้อมูลในรูปแบบ associative array
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function createDataStore($conndb, $name, $description, $price, $quantity, $image) {
    try {
        $sql = "INSERT INTO store (name, description, price, quantity, image) VALUES (:name, :description, :price, :quantity, :image)";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->execute();
        return true; // ส่งคืน true หากเพิ่มข้อมูลสำเร็จ
        $conndb = null; // ปิดการเชื่อมต่อฐานข้อมูล
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false; // ส่งคืน false หากเกิดข้อผิดพลาด
    }
}

function viewDataStore($conndb, $id) {
    try {
        $sql = "SELECT * FROM store WHERE id = :id"; // ดึงข้อมูลสินค้าตาม id
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // ส่งคืนข้อมูลในรูปแบบ associative array
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null; // ส่งคืน null หากเกิดข้อผิดพลาด
    }
}

function updateDataStore($conndb, $id, $name, $description, $price, $quantity, $image = null) {
    try {
        // ตรวจสอบว่ามีการอัปเดตรูปภาพหรือไม่
        if ($image) {
            $sql = "UPDATE store SET name = :name, description = :description, price = :price, quantity = :quantity, image = :image WHERE id = :id";
        } else {
            $sql = "UPDATE store SET name = :name, description = :description, price = :price, quantity = :quantity WHERE id = :id";
        }

        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

        if ($image) {
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        }

        $stmt->execute();
        return true; // ส่งคืน true หากอัปเดตสำเร็จ
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false; // ส่งคืน false หากเกิดข้อผิดพลาด
    }
}

function deleteDataStore($conndb, $id) {
    try {
        $sql = "DELETE FROM store WHERE id = :id"; // ลบข้อมูลสินค้าตาม id
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return true; // ส่งคืน true หากลบสำเร็จ
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false; // ส่งคืน false หากเกิดข้อผิดพลาด
    }
}

function deleteProduct($conndb, $id) {
    try {
        // ดึงข้อมูลสินค้าเพื่อตรวจสอบชื่อไฟล์รูปภาพ
        $sql = "SELECT image FROM store WHERE id = :id";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product && !empty($product['image'])) {
            $imagePath = '../uploads/' . $product['image'];
            // ตรวจสอบว่ามีไฟล์อยู่ในเซิร์ฟเวอร์หรือไม่
            if (file_exists($imagePath)) {
                unlink($imagePath); // ลบไฟล์รูปภาพ
            }
        }

        // ลบข้อมูลสินค้าจากฐานข้อมูล
        $sql = "DELETE FROM store WHERE id = :id";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return true; // ส่งคืน true หากลบสำเร็จ
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false; // ส่งคืน false หากเกิดข้อผิดพลาด
    }
}

