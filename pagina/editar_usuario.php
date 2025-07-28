<?php
session_start();

// Verificar autenticación admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /index.html');
    exit();
}

require_once __DIR__ . '/../php/conexion.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /lib/pagina/lista_usuarios.php');
    exit();
}

// Obtener datos del usuario
$stmt = $pdo->prepare("SELECT id, nombre, apellido, email, telefono, direccion FROM usuarios WHERE id = :id");
$stmt->execute([':id' => $id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Usuario no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Editar Usuario - SkyGuard Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/lib/css/agregar_usuario.css" />
</head>
<body>
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#"><i class="fas fa-shield-alt"></i> SkyGuard Admin</a>
    <!-- Navbar similar al otro -->
  </nav>

  <div class="container-form">
    <a href="/lib/pagina/lista_usuarios.php" class="btn-back"><i class="fas fa-arrow-left"></i> Regresar a la lista de usuarios</a>
    <h2 class="title">Editar Usuario</h2>
    <form method="POST" action="/srv/editar_usuario_srv.php">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>" />
      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" class="form-control" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required />
      </div>
      <div class="form-group">
        <label for="apellido">Apellido</label>
        <input type="text" name="apellido" class="form-control" id="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required />
      </div>
      <div class="form-group">
        <label for="email">Correo electrónico</label>
        <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required />
      </div>
      <div class="form-group">
        <label for="telefono">Teléfono</label>
        <input type="tel" name="telefono" class="form-control" id="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required />
      </div>
      <div class="form-group">
        <label for="direccion">Dirección</label>
        <textarea name="direccion" class="form-control" id="direccion" rows="2" required><?php echo htmlspecialchars($usuario['direccion']); ?></textarea>
      </div>
      <div class="btn-group-center">
        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Guardar cambios</button>
        <a href="/lib/pagina/lista_usuarios.php" class="btn-cancel">Cancelar</a>
      </div>
    </form>
  </div>

  <footer class="footer">
    © 2025 SkyGuard. Todos los derechos reservados.
  </footer>

  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
