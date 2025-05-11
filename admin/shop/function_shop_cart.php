<?php 

/**
 * ดึงข้อมูลสินค้าจากตาราง store
 * 
 * @param PDO $conndb การเชื่อมต่อฐานข้อมูล
 * @param int|null $product_id (ไม่บังคับ) ID ของสินค้า หากระบุจะดึงข้อมูลเฉพาะสินค้านั้น
 * @return array ข้อมูลสินค้าหรือสินค้าทั้งหมด
 */
function getProduct($conndb, $product_id = null)
{
    try {
        if ($product_id) {
            // ดึงข้อมูลสินค้าตาม ID
            $sql = "SELECT * FROM store WHERE id = :product_id";
            $stmt = $conndb->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        } else {
            // ดึงข้อมูลสินค้าทั้งหมด
            $sql = "SELECT * FROM store";
            $stmt = $conndb->prepare($sql);
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        // จัดการข้อผิดพลาด
        error_log("Error fetching product: " . $e->getMessage());
        return [];
    }

    /**
     * เพิ่มสินค้าในตะกร้า
     * 
     * @param array $cart ตะกร้าสินค้าในปัจจุบัน
     * @param int $product_id ID ของสินค้า
     * @param int $quantity จำนวนสินค้าที่ต้องการเพิ่ม
     * @return array ตะกร้าสินค้าที่อัปเดตแล้ว
     */
    function cart_add($cart, $product_id, $quantity)
    {
        if (isset($cart[$product_id])) {
            // หากสินค้ามีอยู่ในตะกร้าแล้ว ให้เพิ่มจำนวน
            $cart[$product_id] += $quantity;
        } else {
            // หากสินค้าไม่มีในตะกร้า ให้เพิ่มใหม่
            $cart[$product_id] = $quantity;
        }

        return $cart;
    }
}