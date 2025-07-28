<?php
session_start();

// Verificar que el usuario esté autenticado y sea admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /index.html');
    exit();
}

// Incluir archivo de conexión (ajusta la ruta si es necesario)
require_once __DIR__ . '/../php/conexion.php';

// Consulta para obtener usuarios
$sql = "SELECT id, nombre, apellido, email, telefono, direccion FROM usuarios ORDER BY nombre ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Usuarios - SkyGuard Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/lib/css/lista_usuarios.css" />
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
        <li class="nav-item px-3 active"><a class="nav-link" href="/lib/pagina/lista_usuarios.php"><i class="fas fa-users"></i> Usuarios</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="/index.html"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
      </ul>
    </div>
  </nav>

  <!-- Contenedor principal -->
  <div class="container-main">
    <!-- Título -->
    <div class="user-header">Usuarios</div>

    <!-- Botones -->
    <div class="buttons-container mb-3">
      <a href="/lib/pagina/perfil_admin.php" class="btn btn-primary btn-sm">
        <i class="fas fa-arrow-left"></i> Regresar al perfil
      </a>
      <a href="/lib/pagina/agregar_usuario.php" class="btn btn-primary btn-sm" title="Agregar usuario">
        <i class="fas fa-plus"></i> Agregar
      </a>
    </div>

    <!-- Lista de usuarios -->
    <div class="user-list">
      <?php if (empty($usuarios)): ?>
        <p>No hay usuarios registrados.</p>
      <?php else: ?>
        <?php foreach ($usuarios as $usuario): ?>
          <div class="user-card">
            <div class="user-info">
              <div><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></div>
              <div><strong>Correo:</strong> <?php echo htmlspecialchars($usuario['email']); ?></div>
              <div><strong>Teléfono:</strong> <?php echo htmlspecialchars($usuario['telefono']); ?></div>
              <div><strong>Dirección:</strong> <?php echo htmlspecialchars($usuario['direccion']); ?></div>
            </div>
            <div class="user-actions">
              <a href="/lib/pagina/editar_usuario.php?id=<?php echo $usuario['id']; ?>" title="Editar usuario"><i class="fas fa-edit"></i></a>
              <a href="/srv/eliminar_usuario_srv.php?id=<?php echo $usuario['id']; ?>" title="Eliminar usuario" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');"><i class="fas fa-trash-alt"></i></a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div>
      © 2025 SkyGuard. Todos los derechos reservados. — 
      <a href="#">Política de privacidad</a> | <a href="#">Términos de servicio</a>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
