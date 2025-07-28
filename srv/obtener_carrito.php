<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../lib/php/conexion.php';

$carrito = $_SESSION['carrito'] ?? [];

if (empty($carrito)) {
    echo json_encode(['productos' => []]);
    exit;
}

$ids = array_keys($carrito);
$placeholders = implode(',', array_fill(0, count($ids), '?'));

try {
    $stmt = $pdo->prepare("SELECT id, nombre, descripcion, precio, imagen_url FROM productos WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Agregar cantidad y total por producto
    foreach ($productos as &$producto) {
        $id = $producto['id'];
        $producto['cantidad'] = $carrito[$id];
        $producto['total'] = $producto['precio'] * $producto['cantidad'];
    }

    echo json_encode(['productos' => $productos]);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
