<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /index.html');
    exit();
}

require_once __DIR__ . '/../lib/php/conexion.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /lib/pagina/lista_usuarios.php');
    exit();
}

try {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $id]);

    header('Location: /lib/pagina/lista_usuarios.php?msg=usuario_eliminado');
    exit();
} catch (PDOException $e) {
    die("Error al eliminar usuario: " . $e->getMessage());
}
