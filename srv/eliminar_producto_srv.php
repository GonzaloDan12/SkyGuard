<?php
session_start();
require_once __DIR__ . '/../lib/php/conexion.php';

// Verificar que el usuario esté autenticado y sea admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /index.html');
    exit();
}

// Validar id del producto
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID de producto inválido.";
    header('Location: /lib/pagina/lista_productos.php');
    exit();
}

$id = (int)$_GET['id'];

try {
    // Obtener la ruta de la imagen para eliminarla físicamente
    $stmt = $pdo->prepare("SELECT imagen_url FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        $_SESSION['error'] = "Producto no encontrado.";
        header('Location: /lib/pagina/lista_productos.php');
        exit();
    }

    // Eliminar producto de la base de datos
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);

    // Eliminar la imagen física si existe y no es placeholder
    if (!empty($producto['imagen_url'])) {
        $rutaImagen = __DIR__ . '/../' . ltrim($producto['imagen_url'], '/');
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }
    }

    $_SESSION['success'] = "Producto eliminado correctamente.";
    header('Location: /lib/pagina/lista_productos.php');
    exit();
} catch (PDOException $e) {
    $_SESSION['error'] = "Error al eliminar producto: " . $e->getMessage();
    header('Location: /lib/pagina/lista_productos.php');
    exit();
}
