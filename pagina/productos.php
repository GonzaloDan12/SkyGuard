<?php
session_start(); // Inicia la sesión para manejar el carrito
require_once __DIR__ . '/../php/conexion.php'; // Asegúrate de que la ruta sea correcta

// Consulta productos
try {
    $stmt = $pdo->query("SELECT * FROM productos");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener productos: " . $e->getMessage());
}

// Agregar al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = 1; // Establecer cantidad a 1, ya que no será necesario mostrar el campo de cantidad

    // Inicializar carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Si el producto ya está en el carrito, actualizar la cantidad
    if (isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto] += $cantidad;
    } else {
        $_SESSION['carrito'][$id_producto] = $cantidad;
    }

    // Redirigir a la misma página para evitar que se reenvíen los datos del formulario
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Catálogo de Productos - SkyGuard</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />  

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="/lib/css/productos.css" />
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <a class="navbar-brand" href="#"><i class="fas fa-shield-alt"></i> SkyGuard</a>
    <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span><i class="fas fa-bars"></i></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item px-3">
          <a class="nav-link" href="/index.html"><i class="fas fa-home"></i> Inicio</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="/lib/pagina/Catalogo.html"><i class="fas fa-concierge-bell"></i> Servicio</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="/lib/pagina/productos.php"><i class="fas fa-box-open"></i> Producto</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="/lib/pagina/carrito.php"><i class="fas fa-shopping-cart"></i> Carrito</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Contenedor de productos -->
  <main class="container" style="margin-top: 80px;">
    <div class="row">
      <?php foreach ($productos as $producto): ?>
        <div class="col-md-4 mb-4">
          <div class="card product-card">
            <img src="<?= htmlspecialchars($producto['imagen_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']) ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
              <p class="card-text"><?= htmlspecialchars($producto['descripcion']) ?></p>
              <p class="price">$<?= number_format($producto['precio'], 2) ?> MXN</p>

              <!-- Formulario para agregar al carrito -->
              <form action="productos.php" method="POST">
                <input type="hidden" name="id_producto" value="<?= htmlspecialchars($producto['id']) ?>">
                <button type="submit" class="btn btn-primary btn-buy">Agregar al carrito</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <!-- Footer y scripts -->
  <footer class="site-footer">
    <div class="container">
      <p>&copy; 2025 SkyGuard. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- Bootstrap JS y dependencias -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
