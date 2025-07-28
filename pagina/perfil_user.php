<?php
session_start();

require_once __DIR__ . '/../php/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /lib/pagina/inicio.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT u.nombre, u.apellido, u.telefono, u.direccion, u.email,
  p.nombre_plan, p.numero_drones, p.direccion_plan, p.fecha_inicio, p.fecha_expiracion,
  p.estado_plan, p.tipo_suscripcion, p.cantidad_max_drones, p.drones_activos, p.costo_plan,
  p.servicios_incluidos, p.contacto_soporte, p.ultima_actualizacion, p.notas_adicionales
  FROM usuarios u
  LEFT JOIN plan p ON u.plan_id = p.id
  WHERE u.id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Usuario no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Perfil de Administrador</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <!-- Custom CSS -->
  <link href="/lib/css/perfil_User.css" rel="stylesheet" />
</head>
<body>
  <!-- NAV -->
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">SkyGuard</a>
    <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/vista-camara.php">Control de Dron</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/historial_compras.html">Compras</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/pagos_plan.html">Pago</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="/index.html">Cerrar Sesión</a></li>
      </ul>
    </div>
    <div class="ml-auto d-flex align-items-center navbar-social-icons">
      <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
      <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
      <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
    </div>
  </nav>

  <div class="container main-body" style="margin-top:20px;">
    <div class="row gutters-sm">
      <!-- Columna izquierda -->
      <div class="col-md-4 mb-3 sticky-col">
        <div class="card">
          <div class="card-body text-center">
            <img src="/lib/img/droid.png" alt="Admin" class="rounded-circle" width="140" />
            <h4><i class="fas fa-user-circle"></i> <?= htmlspecialchars($user['nombre'] . ' ' . $user['apellido']); ?></h4>
            <p class="text-secondary mb-1">Cliente</p>
            <p class="text-muted font-size-sm">Confederación de Sistemas Independientes</p>
          </div>
        </div>
        <div class="card mt-3">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <i class="fas fa-globe"></i>
              <strong> Website:</strong> <span class="text-secondary">#</span>
            </li>
            <li class="list-group-item">
              <i class="fab fa-github"></i>
              <strong> Github:</strong> <span class="text-secondary">#</span>
            </li>
          </ul>
        </div>
      </div>

      <!-- Columna derecha -->
      <div class="col-md-8">
        <!-- Información personal -->
        <div class="card mb-3">
          <div class="card-body">
            <div class="row mb-3"><div class="col-sm-3"><strong>Nombre completo</strong></div><div class="col-sm-9 text-secondary"><?= htmlspecialchars($user['nombre'] . ' ' . $user['apellido']); ?></div></div>
            <div class="row mb-3"><div class="col-sm-3"><strong>Email</strong></div><div class="col-sm-9 text-secondary"><?= htmlspecialchars($user['email']); ?></div></div>
            <div class="row mb-3"><div class="col-sm-3"><strong>Teléfono</strong></div><div class="col-sm-9 text-secondary"><?= htmlspecialchars($user['telefono']); ?></div></div>
            <div class="row mb-3"><div class="col-sm-3"><strong>Dirección</strong></div><div class="col-sm-9 text-secondary"><?= htmlspecialchars($user['direccion']); ?></div></div>
            <div class="row"><div class="col-sm-12"><a class="btn btn-info" href="/lib/pagina/editar_perfil.php">Editar</a></div></div>
          </div>
        </div>

        <!-- Información del Plan -->
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="mb-3">Información del Plan</h5>
            <div class="row mb-3"><div class="col-sm-4"><strong>Nombre del Plan</strong></div><div class="col-sm-8 text-secondary"><?= htmlspecialchars($user['nombre_plan'] ?? 'Sin plan'); ?></div></div>
            <div class="row mb-3"><div class="col-sm-4"><strong>Número de drones</strong></div><div class="col-sm-8 text-secondary"><?= htmlspecialchars($user['numero_drones'] ?? '-'); ?></div></div>
            <div class="row mb-3"><div class="col-sm-4"><strong>Dirección del Plan</strong></div><div class="col-sm-8 text-secondary"><?= htmlspecialchars($user['direccion_plan'] ?? '-'); ?></div></div>
            <div class="row mb-3"><div class="col-sm-4"><strong>Fecha de inicio</strong></div><div class="col-sm-8 text-secondary"><?= isset($user['fecha_inicio']) ? date('d \d\e F, Y', strtotime($user['fecha_inicio'])) : '-'; ?></div></div>
            <div class="row mb-3"><div class="col-sm-4"><strong>Fecha de expiración</strong></div><div class="col-sm-8 text-secondary"><?= isset($user['fecha_expiracion']) ? date('d \d\e F, Y', strtotime($user['fecha_expiracion'])) : '-'; ?></div></div>
            <div class="row mb-3"><div class="col-sm-4"><strong>Estado del plan</strong></div><div class="col-sm-8 text-secondary"><?= htmlspecialchars($user['estado_plan'] ?? '-'); ?></div></div>
            <div class="row mb-3"><div class="col-sm-4"><strong>Tipo de suscripción</strong></div><div class="col-sm-8 text-secondary"><?= htmlspecialchars($user['tipo_suscripcion'] ?? '-'); ?></div></div>
            <div class="row mb-3"><div class="col-sm-4"><strong>Cantidad máxima drones</strong></div><div class="col-sm-8 text-secondary"><?= htmlspecialchars($user['cantidad_max_drones'] ?? '-'); ?></div></div>
            <div class="row mb-3"><div class="col-sm-4"><strong>Drones activos</strong></div><div class="col-sm-8 text-secondary"><?= htmlspecialchars($user['drones_activos'] ?? '-'); ?></div></div>
            <div class="row mb-3"><div class="col-sm-4"><strong>Costo del plan</strong></div><div class="col-sm-8 text-secondary">$<?= number_format($user['costo_plan'] ?? 0, 2) ?> MXN / mes</div></div>
            <div class="row mb-3">
              <div class="col-sm-4"><strong>Servicios incluidos</strong></div>
              <div class="col-sm-8 text-secondary">
                <?php
                if (!empty($user['servicios_incluidos'])) {
                    $servicios = explode(',', $user['servicios_incluidos']);
                    echo '<ul class="mb-0 pl-3">';
                    foreach ($servicios as $servicio) {
                        echo '<li>' . htmlspecialchars(trim($servicio)) . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '-';
                }
                ?>
              </div>
            </div>
            <div class="row mb-3"><div class="col-sm-4"><strong>Contacto soporte</strong></div><div class="col-sm-8 text-secondary"><?= htmlspecialchars($user['contacto_soporte'] ?? '-'); ?></div></div>
            <div class="row mb-3"><div class="col-sm-4"><strong>Última actualización</strong></div><div class="col-sm-8 text-secondary"><?= isset($user['ultima_actualizacion']) ? date('d \d\e F, Y', strtotime($user['ultima_actualizacion'])) : '-'; ?></div></div>
            <!-- Aquí mantenemos el Historial de pagos -->
            <div class="row mb-3">
              <div class="col-sm-4"><strong>Historial de pagos</strong></div>
              <div class="col-sm-8">
                <a href="/lib/pagina/historial_pagos.html" class="btn btn-sm btn-outline-primary">Ver recibos</a>
              </div>
            </div>
            <div class="row"><div class="col-sm-4"><strong>Notas adicionales</strong></div><div class="col-sm-8 text-secondary"><?= htmlspecialchars($user['notas_adicionales'] ?? '-'); ?></div></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="footer text-center">
    <div class="container">
      <div class="row">
        <div class="col-md-6 text-left">
          <h5>Sobre SkyGuard</h5>
          <p>
            SkyGuard es una empresa líder en venta de drones para seguridad,
            vigilancia y monitoreo inteligente.
          </p>
        </div>
        <div class="col-md-6 text-right">
          <h5>Contacto</h5>
          <p>Email: contacto@skyguard.com</p>
          <p>Tel: +52 55 1234 5678</p>
          <div class="social-icons mt-2">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
      <hr style="background-color: white;" />
      <p class="mb-0">© 2025 SkyGuard. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
