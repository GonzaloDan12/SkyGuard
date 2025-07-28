<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Editar Perfil</title>

  <!-- Íconos y estilos de Bootstrap + FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" />

  <!-- Archivo CSS personalizado -->
  <link rel="stylesheet" href="/lib/css/editar_perfil_admin.css" />
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
        <li class="nav-item px-3">
          <a class="nav-link" href="/lib/pagina/perfil_admin.php"><i class="fas fa-home"></i> Inicio</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="/lib/pagina/lista_productos.php"><i class="fas fa-box-open"></i> Productos</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="/lib/pagina/listapedidos.html"><i class="fas fa-shopping-cart"></i> Pedidos</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="/lib/pagina/lista_usuarios.php"><i class="fas fa-users"></i> Usuarios</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="/index.html"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mt-4">
    <!-- Mensajes de error o éxito -->
    <?php
    session_start();
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">'.htmlspecialchars($_SESSION['error']).'</div>';
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success">'.htmlspecialchars($_SESSION['success']).'</div>';
        unset($_SESSION['success']);
    }
    ?>
  </div>

  <!-- FORMULARIO -->
  <div class="form-container container mt-3">
    <h2><i class="fas fa-user-edit"></i> Editar Perfil</h2>
    <form action="/srv/editar_perfil_procesar.php" method="POST">
      <label for="nombre">Nombre completo</label>
      <input type="text" id="nombre" name="nombre" placeholder="Ej. Juan Pérez" required />

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Ej. juan@email.com" required />

      <label for="telefono">Teléfono</label>
      <input type="text" id="telefono" name="telefono" placeholder="Ej. 55 1234 5678" />

      <label for="direccion">Dirección</label>
      <textarea id="direccion" name="direccion" rows="3" placeholder="Ej. Calle 123, Colonia, Ciudad"></textarea>

      <div class="btn-group mt-3">
        <button type="submit" class="btn btn-primary btn-save"><i class="fas fa-save"></i> Guardar Cambios</button>
        <a href="/lib/pagina/perfil_admin.php" class="btn btn-secondary btn-cancel"><i class="fas fa-times"></i> Cancelar</a>
      </div>
    </form>
  </div>

  <!-- FOOTER -->
  <footer class="footer mt-5 py-3 bg-light text-center">
    <div>
      © 2025 SkyGuard. Todos los derechos reservados. — 
      <a href="#">Política de privacidad</a> | <a href="#">Términos de servicio</a>
    </div>
  </footer>

  <!-- Scripts Bootstrap y FontAwesome -->
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
