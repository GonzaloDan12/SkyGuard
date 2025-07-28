<?php
session_start();
require_once __DIR__ . '/../lib/php/conexion.php';

// Verificar sesión
if (!isset($_SESSION['user_id'])) {
  header('Location: /index.html');
  exit();
}

$user_id = $_SESSION['user_id'];

// Recibir datos del formulario
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');

// Validaciones básicas
if (empty($nombre) || empty($email)) {
  $_SESSION['error'] = "El nombre y el email son obligatorios.";
  header("Location: /lib/pagina/editar_perfil.php");
  exit();
}

try {
  $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, email = ?, telefono = ?, direccion = ? WHERE id = ?");
  $stmt->execute([$nombre, $email, $telefono, $direccion, $user_id]);

  $_SESSION['success'] = "Perfil actualizado correctamente.";
  header("Location: /lib/pagina/perfil_user.php");
  exit();
} catch (PDOException $e) {
  $_SESSION['error'] = "Error al actualizar el perfil: " . $e->getMessage();
  header("Location: /lib/pagina/editar_perfil.php");
  exit();
}
