<?php
session_start();
require_once __DIR__ . '/../php/conexion.php'; // Asegúrate que la ruta sea correcta

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Manejo de eliminar producto del carrito
if (isset($_POST['eliminar'])) {
    $id_producto = $_POST['eliminar'];
    unset($_SESSION['carrito'][$id_producto]); // Eliminar producto del carrito
    header("Location: carrito.php");
    exit;
}

// Manejo de actualización de cantidades (aumentar o disminuir)
if (isset($_POST['accion'])) {
    $id_producto = $_POST['id_producto'];
    $accion = $_POST['accion'];

    if (isset($_SESSION['carrito'][$id_producto])) {
        if ($accion === 'aumentar') {
            $_SESSION['carrito'][$id_producto]++;
        } elseif ($accion === 'disminuir') {
            $_SESSION['carrito'][$id_producto]--;
            if ($_SESSION['carrito'][$id_producto] < 1) {
                unset($_SESSION['carrito'][$id_producto]);
            }
        }
    }
    header("Location: carrito.php");
    exit;
}

// Obtener carrito actual
$carrito = $_SESSION['carrito'];

// Obtener detalles productos del carrito
$productosCarrito = [];
$total = 0;
foreach ($carrito as $producto_id => $cantidad) {
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
    $stmt->execute(['id' => $producto_id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        $producto['cantidad'] = $cantidad;
        $productosCarrito[] = $producto;
        $total += $producto['precio'] * $cantidad;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mi Bolsa - SkyGuard</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="/lib/css/carrito.css" />
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#"><i class="fas fa-shield-alt"></i> SkyGuard</a>
    <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
          <a class="nav-link" href="/lib/pagina/inicio.php"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- MAIN -->
  <main class="main-content container">
    <div class="left-panel">
      <div class="tabs">
        <button class="tab-button active">Mi Carrito (<?= count($carrito) ?>)</button>
      </div>

      <div class="product-list">
        <?php if (empty($carrito)): ?>
          <p>No tienes productos en el carrito.</p>
        <?php else: ?>
          <?php foreach ($productosCarrito as $producto): ?>
            <div class="product-item d-flex align-items-center justify-content-between mb-3 p-3 border rounded">
              <div class="product-image mr-3" style="width: 100px;">
                <img src="<?= htmlspecialchars($producto['imagen_url']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="img-fluid" />
              </div>
              <div class="product-details flex-grow-1">
                <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                <p><?= htmlspecialchars($producto['descripcion']) ?></p>
              </div>
              <div class="product-price mr-3" style="min-width: 100px;">
                <span class="original-price">$<?= number_format($producto['precio'], 2) ?></span>
              </div>

              <!-- Formulario para actualizar cantidad -->
              <div class="product-quantity mr-3">
                <form action="carrito.php" method="POST" class="d-flex align-items-center">
                  <input type="hidden" name="id_producto" value="<?= $producto['id'] ?>">

                  <!-- Botón de disminuir -->
                  <button type="submit" name="accion" value="disminuir" class="btn btn-sm btn-outline-secondary mx-2" <?= $producto['cantidad'] <= 1 ? 'disabled' : '' ?>>
                    <i class="fas fa-minus"></i>
                  </button>

                  <span class="mx-2"><?= $producto['cantidad'] ?></span>

                  <!-- Botón de aumentar -->
                  <button type="submit" name="accion" value="aumentar" class="btn btn-sm btn-outline-secondary mx-2">
                    <i class="fas fa-plus"></i>
                  </button>
                </form>
              </div>

              <!-- Mostrar total del producto -->
              <div class="product-total mr-3" style="min-width: 100px;">
                $<?= number_format($producto['precio'] * $producto['cantidad'], 2) ?>
              </div>

              <!-- Botón para eliminar producto -->
              <form action="carrito.php" method="POST">
                <input type="hidden" name="eliminar" value="<?= $producto['id'] ?>">
                <button type="submit" class="btn btn-danger">Eliminar</button>
              </form>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

    <aside class="right-panel">
      <div class="summary-box p-3 border rounded">
        <h4>Detalle de Compra</h4>
        <p>Subtotal (<?= count($productosCarrito) ?> productos): <span>$<?= number_format($total, 2) ?></span></p>
        <p>Descuentos: <span>$0.00</span></p>
        <p>Cupones: <span>$0.00</span></p>
        <p>Costo de envío: <span>Gratis</span></p>
        <hr />
        <p class="total font-weight-bold">Total (IVA Incluido): <span>$<?= number_format($total, 2) ?></span></p>
        <p class="note"><small>*Los precios aplican de acuerdo a forma de pago.</small></p>
        <a href="/lib/pagina/direccion.html"><button class="btn btn-primary btn-block">Comprar</button></a>
        <div class="payment-methods mt-3">
          <h5>Formas de pago disponibles</h5>
          <div class="payment-icons d-flex">
            <img src="/lib/img/visa.png" alt="Visa" style="height: 40px; margin-right: 10px;" />
            <img src="/lib/img/master.jpg" alt="Mastercard" style="height: 40px;" />
          </div>
        </div>
      </div>
    </aside>
  </main>

  <!-- FOOTER -->
  <footer class="site-footer mt-5 bg-light py-4">
    <div class="container d-flex flex-wrap justify-content-between">
      <div class="footer-section mb-3">
        <h5>Atención a Clientes</h5>
        <ul class="list-unstyled">
          <li><a href="#"><i class="fas fa-question-circle"></i> Ayuda</a></li>
          <li><a href="#"><i class="fas fa-info-circle"></i> Preguntas Frecuentes</a></li>
          <li><a href="#"><i class="fas fa-envelope"></i> Contacto</a></li>
          <li><a href="#"><i class="fas fa-file-invoice"></i> Facturación Electrónica</a></li>
        </ul>
      </div>
      <div class="footer-section mb-3">
        <h5>Información Legal</h5>
        <ul class="list-unstyled">
          <li><a href="#"><i class="fas fa-file-contract"></i> Términos y Condiciones</a></li>
          <li><a href="#"><i class="fas fa-user-shield"></i> Aviso de Privacidad</a></li>
          <li><a href="#"><i class="fas fa-undo-alt"></i> Política de Devoluciones</a></li>
        </ul>
      </div>
      <div class="footer-section mb-3">
        <h5>Mi Cuenta</h5>
        <ul class="list-unstyled">
          <li><a href="#"><i class="fas fa-user"></i> Mi Perfil</a></li>
          <li><a href="#"><i class="fas fa-clipboard-list"></i> Mis Pedidos</a></li>
          <li><a href="#"><i class="fas fa-credit-card"></i> SkyGuard Crédito</a></li>
        </ul>
      </div>
      <div class="footer-section social-media mb-3">
        <h5>Síguenos</h5>
        <div class="social-icons">
          <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom text-center mt-3">
      <p>&copy; 2025 SkyGuard. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- Bootstrap JS y dependencias -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
