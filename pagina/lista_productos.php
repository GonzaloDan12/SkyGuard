<?php
session_start();
require_once __DIR__ . '/../php/conexion.php';

// Verificar que el usuario esté autenticado y tenga rol admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /index.html');
    exit();
}

// Obtener productos
try {
    $stmt = $pdo->query("SELECT id, nombre, precio, stock, descripcion, imagen_url FROM productos ORDER BY id DESC");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener productos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Productos - SkyGuard Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/lib/css/lista_productos.css" />
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#"><i class="fas fa-shield-alt"></i> SkyGuard Admin</a>
    <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/perfil_admin.php"><i class="fas fa-home"></i> Inicio</a></li>
        <li class="nav-item px-3 active"><a class="nav-link" href="/lib/pagina/lista_productos.php"><i class="fas fa-box-open"></i> Productos</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/listapedidos.html"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/lista_usuarios.php"><i class="fas fa-users"></i> Usuarios</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="/index.html"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
      </ul>
    </div>
  </nav>

  <!-- Título -->
  <div class="product-header text-center">Productos</div>

  <!-- Botones -->
  <div class="buttons-container d-flex justify-content-between">
    <a href="/lib/pagina/perfil_admin.php" class="btn-sm btn-primary">
      <i class="fas fa-arrow-left"></i> Regresar al perfil
    </a>
    <a href="/lib/pagina/agregar_producto.php" class="btn-sm btn-primary" title="Agregar producto">
      <i class="fas fa-plus"></i> Agregar
    </a>
  </div>

  <!-- Lista de productos -->
  <div class="product-list">
    <?php if (empty($productos)): ?>
      <p>No hay productos disponibles.</p>
    <?php else: ?>
      <?php foreach ($productos as $producto): ?>
        <?php
          $img_url = !empty($producto['imagen_url']) ? $producto['imagen_url'] : 'https://via.placeholder.com/100';
          $id_esc = (int)$producto['id'];
        ?>
        <div class="product-card">
          <img src="<?= htmlspecialchars($img_url) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="product-image" />
          <div class="product-info">
            <h3 class="product-name"><?= htmlspecialchars($producto['nombre']) ?></h3>
            <div class="product-price">$<?= number_format($producto['precio'], 2) ?> MXN</div>
            <div class="product-stock">Stock: <?= (int)$producto['stock'] ?> unidades</div>
            <p class="product-description"><?= htmlspecialchars($producto['descripcion']) ?></p>
          </div>
          <div class="product-actions">
            <a href="/lib/pagina/editar_producto.php?id=<?= $id_esc ?>" title="Editar producto">
              <i class="fas fa-edit"></i>
            </a>
            <a href="/srv/eliminar_producto_srv.php?id=<?= $id_esc ?>" title="Eliminar producto" onclick="return confirm('¿Seguro que quieres eliminar este producto?');">
              <i class="fas fa-trash-alt"></i>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div>
      © 2025 SkyGuard. Todos los derechos reservados. —
      <a href="#">Política de privacidad</a> |
      <a href="#">Términos de servicio</a>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
