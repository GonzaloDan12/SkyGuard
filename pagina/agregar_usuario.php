<?php
session_start();
// Verifica que el usuario esté autenticado y sea admin para poder acceder
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Agregar Usuario - SkyGuard Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/lib/css/agregar_usuario.css" />
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
        <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/lista_productos.php"><i class="fas fa-box-open"></i> Productos</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/listapedidos.html"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/lista_usuarios.php"><i class="fas fa-users"></i> Usuarios</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="/index.html"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
      </ul>
    </div>
  </nav>

  <!-- CONTENIDO -->
  <div class="container-form">
    <a href="/lib/pagina/lista_usuarios.php" class="btn-back"><i class="fas fa-arrow-left"></i> Regresar a la lista de usuarios</a>
    <h2 class="title">Agregar Nuevo Usuario</h2>
    <form method="POST" action="/srv/agregar_usuario_srv.php">
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej. Juan" required />
      </div>
      <div class="form-group">
        <label for="apellido">Apellido</label>
        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ej. Pérez" required />
      </div>
      <div class="form-group">
        <label for="email">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Ej. juan.perez@example.com" required />
      </div>
      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña segura" required />
      </div>
      <div class="form-group">
        <label for="telefono">Teléfono</label>
        <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ej. 55 1234 5678" required />
      </div>
      <div class="form-group">
        <label for="direccion">Dirección</label>
        <textarea class="form-control" id="direccion" name="direccion" rows="2" placeholder="Ej. Calle Falsa 123, CDMX" required></textarea>
      </div>
      <div class="form-group">
        <label for="rol">Rol</label>
        <select class="form-control" id="rol" name="rol" required>
          <option value="user">Usuario</option>
          <option value="admin">Administrador</option>
        </select>
      </div>
      <div class="btn-group-center">
        <button type="submit" class="btn-submit"><i class="fas fa-plus-circle"></i> Agregar usuario</button>
        <button type="reset" class="btn-cancel">Cancelar</button>
      </div>
    </form>
  </div>

  <!-- FOOTER -->
  <footer class="footer">
    © 2025 SkyGuard. Todos los derechos reservados. —
    <a href="#">Política de privacidad</a> | <a href="#">Términos de servicio</a>
  </footer>

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
