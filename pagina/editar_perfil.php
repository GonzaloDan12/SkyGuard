<?php
session_start();
require_once __DIR__ . '/../php/conexion.php';

// Redirigir si no hay sesión
if (!isset($_SESSION['user_id'])) {
  header('Location: /index.html');
  exit();
}

$user_id = $_SESSION['user_id'];

// Obtener datos actuales del usuario (sin movil)
$stmt = $pdo->prepare("SELECT nombre, email, telefono, direccion FROM usuarios WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  $_SESSION['error'] = "Usuario no encontrado.";
  header("Location: /index.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Editar Perfil</title>

  <!-- Estilos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="/lib/css/editar_perfil.css"/>
</head>
<body>

<!-- NAV -->
<nav class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="#"><i class="fas fa-shield-alt"></i> SkyGuard</a>
  <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
  </button>
  <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/vista-camara.php"><i class="fas fa-drone"></i> Control de Dron</a></li>
      <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/historial_compras.html"><i class="fas fa-file-invoice-dollar"></i> Compras</a></li>
      <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/pagos_plan.html"><i class="fas fa-clipboard-list"></i> Pago</a></li>
      <li class="nav-item px-3"><a class="nav-link" href="/index.html"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
    </ul>
  </div>
  <div class="ml-auto d-flex align-items-center navbar-social-icons">
    <a href="#"><i class="fab fa-facebook-f"></i></a>
    <a href="#"><i class="fab fa-instagram"></i></a>
    <a href="#"><i class="fab fa-twitter"></i></a>
  </div>
</nav>

<!-- FORMULARIO -->
<div class="form-container">
  <h2><i class="fas fa-user-edit"></i> Editar Perfil</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
    <?php unset($_SESSION['success']); ?>
  <?php elseif (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <form method="POST" action="/srv/editar_perfil_srv.php">
    <label for="nombre">Nombre completo</label>
    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($user['nombre']) ?>" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

    <label for="telefono">Teléfono</label>
    <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($user['telefono']) ?>">

    <label for="direccion">Dirección</label>
    <textarea id="direccion" name="direccion" rows="3"><?= htmlspecialchars($user['direccion']) ?></textarea>

    <div class="btn-group">
      <button type="submit" class="btn-save"><i class="fas fa-save"></i> Guardar Cambios</button>
      <a href="/lib/pagina/perfil_user.php" class="btn-cancel"><i class="fas fa-times"></i> Cancelar</a>
    </div>
  </form>
</div>

<!-- FOOTER -->
<footer class="footer text-center mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-6 text-left">
        <h5>Sobre SkyGuard</h5>
        <p>SkyGuard es una empresa líder en venta de drones para seguridad, vigilancia y monitoreo inteligente.</p>
      </div>
      <div class="col-md-6 text-right">
        <h5>Contacto</h5>
        <p>Email: contacto@skyguard.com</p>
        <p>Tel: +52 55 1234 5678</p>
        <div class="social-icons mt-2">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>
    <hr style="background-color: white;" />
    <p class="mb-0">© 2025 SkyGuard. Todos los derechos reservados.</p>
  </div>
</footer>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
