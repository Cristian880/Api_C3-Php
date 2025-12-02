<?php
require_once 'db.php';

function getAllItems() {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT * FROM INVENT");
        $stmt->execute(); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        http_response_code(500);
        return[
            "error" => $e->getMessage()
        ];
    }
}

function getIventById($id) {
    global $conn;

    try {
        $stmt = $conn->prepare("SELECT * FROM INVENT WHERE ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        http_response_code(500);
        return[
            "error" => $e->getMessage()
        ];
    }
}

function createInvent($descripcion, $cantidad): array|bool{
    global $conn;

    try {
        $stmt = $conn->prepare("INSERT INTO INVENT (DESCRIPCION, CANTIDAD) VALUES (?, ?)");
        $stmt->execute([$descripcion, $cantidad]);
        return true;
        
    } catch (PDOException $e) {
        http_response_code(500);
        return[
            "error" => $e->getMessage()
        ];
    }
}

function updateInvent($id, $descripcion, $cantidad): array|bool{
    global $conn;

    try {
        $stmt = $conn->prepare("UPDATE INVENT SET DESCRIPCION = ?, CANTIDAD = ? WHERE ID = ?");
        $stmt->execute([$descripcion, $cantidad, $id]);
        return true;
        
    } catch (PDOException $e) {
        http_response_code(500);
        return[
            "error" => $e->getMessage()
        ];
    }
}

function deleteInvent($id): array|bool{
    global $conn;

    try {
        $stmt = $conn->prepare("DELETE FROM INVENT WHERE ID = ?");
        $stmt->execute([$id]);
        return true;
        
    } catch (PDOException $e) {
        http_response_code(500);
        return[
            "error" => $e->getMessage()
        ];
    }
}
?>