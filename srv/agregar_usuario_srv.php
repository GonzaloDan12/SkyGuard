<?php
session_start();

require_once __DIR__ . '/../lib/php/conexion.php'; // Ajusta ruta si es necesario

// Verificar autenticación y rol admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /index.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /lib/pagina/agregar_usuario.php');
    exit();
}

// Recibir y limpiar datos
$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$telefono = trim($_POST['telefono'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$rol = $_POST['rol'] ?? 'user';

// Validaciones básicas
if (
    empty($nombre) || empty($apellido) || empty($email) || empty($password) ||
    empty($telefono) || empty($direccion) ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    !in_array($rol, ['admin', 'user'])
) {
    die("Datos inválidos. Verifica la información.");
}

// Mapear rol a rol_id (ajusta los IDs según tu tabla roles)
$rol_id = ($rol === 'admin') ? 2 : 1;

// Hashear contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password, telefono, direccion, rol_id, plan_id) VALUES (:nombre, :apellido, :email, :password, :telefono, :direccion, :rol_id, NULL)");

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password_hash);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':rol_id', $rol_id);

    $stmt->execute();

    header('Location: /lib/pagina/lista_usuarios.php?msg=usuario_agregado');
    exit();
} catch (PDOException $e) {
    die("Error al agregar usuario: " . $e->getMessage());
}
