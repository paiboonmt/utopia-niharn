<?php


    function getData($conndb, $id) {
        $sql = "SELECT * FROM orders WHERE id = :id";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function cancelTicket($conndb, $id) {
        $sql = "UPDATE orders SET pay = 'Canceled' WHERE id = :id";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }