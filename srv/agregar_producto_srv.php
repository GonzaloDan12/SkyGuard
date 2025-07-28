<?php
session_start();
require_once __DIR__ . '/../lib/php/conexion.php'; // Ajusta ruta si es necesario

// Verificar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /lib/pagina/agregar_producto.php');
    exit();
}

// Recibir y limpiar datos
$nombre = trim($_POST['nombre']);
$precio = floatval($_POST['precio']);
$stock = intval($_POST['stock']);
$descripcion = trim($_POST['descripcion']);

// Validar campos obligatorios
if (empty($nombre) || $precio <= 0 || $stock < 0 || empty($descripcion)) {
    $_SESSION['error'] = "Por favor completa todos los campos correctamente.";
    header('Location: /lib/pagina/agregar_producto.php');
    exit();
}

// Procesar la imagen
$imagen_url = null;

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['imagen']['tmp_name'];
    $fileName = $_FILES['imagen']['name'];
    $fileSize = $_FILES['imagen']['size'];
    $fileType = $_FILES['imagen']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Extensiones permitidas
    $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExtension, $allowedfileExtensions)) {
        // Crear un nombre único para evitar sobrescrituras
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Directorio donde se guardarán las imágenes (asegúrate que exista y tenga permisos)
        $uploadFileDir = __DIR__ . '/../lib/img_productos/';

        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Ruta que se guardará en DB, relativa a la raíz web para que sea accesible
            $imagen_url = '/lib/img_productos/' . $newFileName;
        } else {
            $_SESSION['error'] = 'Error al mover el archivo subido.';
            header('Location: /lib/pagina/agregar_producto.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Tipo de archivo no permitido. Solo JPG, JPEG, PNG y GIF.';
        header('Location: /lib/pagina/agregar_producto.php');
        exit();
    }
} else {
    // No se subió imagen o hubo error, puedes decidir si es obligatorio o no
    $_SESSION['error'] = 'Debe seleccionar una imagen para el producto.';
    header('Location: /lib/pagina/agregar_producto.php');
    exit();
}

// Guardar en la base de datos
try {
    $stmt = $pdo->prepare("INSERT INTO productos (nombre, precio, stock, descripcion, imagen_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $precio, $stock, $descripcion, $imagen_url]);

    $_SESSION['success'] = "Producto agregado correctamente.";
    header('Location: /lib/pagina/lista_productos.php');
    exit();
} catch (PDOException $e) {
    $_SESSION['error'] = "Error al guardar el producto: " . $e->getMessage();
    header('Location: /lib/pagina/agregar_producto.php');
    exit();
}
