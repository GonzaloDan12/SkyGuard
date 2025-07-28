<?php
session_start();
require_once __DIR__ . '/../lib/php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validar que vengan los campos
    if (!isset($_POST['username'], $_POST['password'])) {
        $_SESSION['error'] = "Por favor complete todos los campos.";
        header("Location: /lib/pagina/inicio.php");
        exit();
    }

    // Obtener y limpiar datos
    $email = strtolower(trim($_POST['username'])); // Usamos strtolower para normalizar
    $password = $_POST['password'];

    // Validar formato email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Correo electrónico inválido.";
        header("Location: /lib/pagina/inicio.php");
        exit();
    }

    try {
        // Consulta con JOIN para obtener info usuario y rol
        $stmt = $pdo->prepare("SELECT u.id, u.nombre, u.apellido, u.email, u.password, r.nombre_rol 
                               FROM usuarios u 
                               JOIN roles r ON u.rol_id = r.id 
                               WHERE u.email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Guardar datos en sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_role'] = $user['nombre_rol'];

            // Redirigir según rol
            if ($user['nombre_rol'] === 'admin') {
                header("Location: /lib/pagina/perfil_admin.php");
            } else {
                header("Location: /lib/pagina/perfil_user.php");
            }
            exit();
        } else {
            // Usuario no encontrado o contraseña incorrecta
            $_SESSION['error'] = "Correo o contraseña incorrectos.";
            header("Location: /lib/pagina/inicio.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al iniciar sesión: " . $e->getMessage();
        header("Location: /lib/pagina/inicio.php");
        exit();
    }
} else {
    // Si no es POST, redirigir al login
    header("Location: /lib/pagina/inicio.php");
    exit();
}
