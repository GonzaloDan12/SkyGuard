<?php
session_start();
header('Content-Type: application/json');

$id_producto = $_POST['id_producto'] ?? null;
$cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : null;

if (!$id_producto || $cantidad === null || $cantidad < 1) {
    echo json_encode(['ok' => false, 'mensaje' => 'Datos inválidos']);
    exit;
}

if (isset($_SESSION['carrito'][$id_producto])) {
    $_SESSION['carrito'][$id_producto] = $cantidad;
    echo json_encode(['ok' => true, 'mensaje' => 'Cantidad actualizada']);
} else {
    echo json_encode(['ok' => false, 'mensaje' => 'Producto no existe en el carrito']);
}
