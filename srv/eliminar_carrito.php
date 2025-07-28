<?php
session_start();
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$id = $input['id'] ?? null;

if ($id && isset($_SESSION['carrito'][$id])) {
    unset($_SESSION['carrito'][$id]);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Producto no encontrado']);
}
