<?php

    // view data
    function getData($conndb, $id) {
        $stmt = $conndb->prepare("SELECT * FROM customer WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getNationality($conndb){
        $stmt = $conndb->prepare("SELECT * FROM `tb_nationality`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getProduct($conndb){
        $stmt = $conndb->prepare("SELECT * FROM `products`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPayment($conndb){
        $stmt = $conndb->prepare("SELECT * FROM `payment`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getHistory($conndb, $id){
        $stmt = $conndb->prepare("SELECT * FROM `product_history` WHERE m_card = :m_card ORDER BY id DESC");
        $stmt->bindParam(':m_card', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
