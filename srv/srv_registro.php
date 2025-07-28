<?php
session_start();
require_once __DIR__ . '/../lib/php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion'] ?? ''); // si agregas campo direccion en form
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Validaciones básicas
    if ($password !== $confirm) {
        $_SESSION['error'] = 'Las contraseñas no coinciden.';
        header('Location: /lib/pagina/registrosesion.php');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Correo electrónico inválido.';
        header('Location: /lib/pagina/registrosesion.php');
        exit();
    }

    if (!preg_match('/^\d{7,15}$/', $telefono)) {
        $_SESSION['error'] = 'Número de teléfono inválido.';
        header('Location: /lib/pagina/registrosesion.php');
        exit();
    }

    try {
        // Verificar si ya existe el correo
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = 'El correo ya está registrado.';
            header('Location: /lib/pagina/registrosesion.php');
            exit();
        }

        // Obtener rol 'usuario'
        $rolStmt = $pdo->prepare("SELECT id FROM roles WHERE nombre_rol = ?");
        $rolStmt->execute(['usuario']);
        $rol = $rolStmt->fetch(PDO::FETCH_ASSOC);
        if (!$rol) {
            $_SESSION['error'] = 'El rol "usuario" no existe.';
            header('Location: /lib/pagina/registrosesion.php');
            exit();
        }

        // Obtener plan por defecto (ejemplo: Premium)
        $planStmt = $pdo->prepare("SELECT id FROM plan WHERE nombre_plan = ?");
        $planStmt->execute(['Premium']);
        $plan = $planStmt->fetch(PDO::FETCH_ASSOC);
        $plan_id = $plan ? $plan['id'] : null;

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar usuario
        $insert = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, telefono, direccion, email, password, rol_id, plan_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->execute([$nombre, $apellido, $telefono, $direccion, $email, $password_hash, $rol['id'], $plan_id]);

        $_SESSION['success'] = 'Usuario registrado exitosamente.';
        header('Location: /lib/pagina/registrosesion.php');
        exit();

    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al registrar: ' . $e->getMessage();
        header('Location: /lib/pagina/registrosesion.php');
        exit();
    }
} else {
    header('Location: /lib/pagina/registrosesion.php');
    exit();
}
