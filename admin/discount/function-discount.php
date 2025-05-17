<?php

function getDiscounts($conn) {
    $stmt = $conn->prepare("SELECT * FROM discounts");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createDiscount($conn, $name, $amount) {
    $stmt = $conn->prepare("INSERT INTO discounts (name, amount) VALUES (:name, :amount)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':amount', $amount);
    return $stmt->execute();
}

function updateDiscount($conn, $id, $name, $amount) {
    $stmt = $conn->prepare("UPDATE discounts SET name = :name, amount = :amount WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':amount', $amount);
    return $stmt->execute();
}

function deleteDiscount($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM discounts WHERE id = :id");
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}