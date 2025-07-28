<?php
require_once __DIR__ . '/../lib/php/conexion.php';


$id = $_POST['id'] ?? null;
$nombre = $_POST['nombre'] ?? '';
$precio = $_POST['precio'] ?? 0;
$stock = $_POST['stock'] ?? 0;
$descripcion = $_POST['descripcion'] ?? '';
$imagen_url = $_POST['imagen_actual'] ?? '';

if (!$id) {
    die("ID de producto no válido.");
}

// Procesar imagen si se subió
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $carpeta_destino = __DIR__ . '/../img_productos/';
    if (!is_dir($carpeta_destino)) {
        mkdir($carpeta_destino, 0755, true);
    }

    $nombre_archivo = uniqid('img_') . '_' . basename($_FILES['imagen']['name']);
    $ruta_destino = $carpeta_destino . $nombre_archivo;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
        $imagen_url = '/img_productos/' . $nombre_archivo;
    }
}

try {
    $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, precio = ?, stock = ?, descripcion = ?, imagen_url = ? WHERE id = ?");
    $stmt->execute([$nombre, $precio, $stock, $descripcion, $imagen_url, $id]);
    header("Location: /lib/pagina/lista_productos.php");
} catch (PDOException $e) {
    echo "Error al editar producto: " . $e->getMessage();
}
?>
