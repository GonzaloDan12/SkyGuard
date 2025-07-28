<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /index.html');
    exit();
}

require_once __DIR__ . '/../lib/php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /lib/pagina/lista_usuarios.php');
    exit();
}

$id = $_POST['id'] ?? null;
$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');

// Validar datos básicos
if (!$id || empty($nombre) || empty($apellido) || empty($email) || empty($telefono) || empty($direccion) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Datos inválidos.");
}

try {
    $stmt = $pdo->prepare("UPDATE usuarios SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, direccion = :direccion WHERE id = :id");
    $stmt->execute([
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':email' => $email,
        ':telefono' => $telefono,
        ':direccion' => $direccion,
        ':id' => $id,
    ]);

    header('Location: /lib/pagina/lista_usuarios.php?msg=usuario_actualizado');
    exit();
} catch (PDOException $e) {
    die("Error al actualizar usuario: " . $e->getMessage());
}
