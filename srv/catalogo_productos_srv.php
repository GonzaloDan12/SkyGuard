<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../lib/php/conexion.php';

try {
    $stmt = $pdo->query("SELECT * FROM productos");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($productos);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
