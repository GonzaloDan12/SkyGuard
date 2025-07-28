<?php
session_start();
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['id'])) {
    echo json_encode(['success' => false, 'error' => 'No se recibió id']);
    exit;
}

$id = $input['id'];
$nombre = $input['nombre'] ?? '';
$precio = $input['precio'] ?? 0;
$imagen = $input['imagen'] ?? '';
$cantidad = $input['cantidad'] ?? 1;

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Si el producto ya existe en el carrito, sumar cantidad
if (isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
} else {
    $_SESSION['carrito'][$id] = [
        'id' => $id,
        'nombre' => $nombre,
        'precio' => $precio,
        'imagen' => $imagen,
        'cantidad' => $cantidad,
    ];
}

echo json_encode(['success' => true, 'carrito' => $_SESSION['carrito']]);
