<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro</title>
  <link rel="stylesheet" href="/lib/css/registro.css" />
</head>
<body>
  <div class="wrapper fadeInDown">
    <div id="formContent">

      <!-- Título -->
      <a href="/lib/pagina/registrosesion.php"><h2 class="active">Registrarse</h2></a>
      <a href="/lib/pagina/inicio.php"><h2 class="inactive underlineHover">Inicio de Sesión</h2></a>

      <!-- Icono -->
      <div class="fadeIn first">
        <img src="/lib/img/registro.png" id="icon" alt="User Icon" />
      </div>

      <!-- Mensajes -->
      <?php if (isset($_SESSION['error'])): ?>
        <div style="color: red; margin-bottom: 10px;">
          <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION['success'])): ?>
        <div style="color: green; margin-bottom: 10px;">
          <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
      <?php endif; ?>

      <!-- Formulario de Registro -->
      <form action="/srv/srv_registro.php" method="post" autocomplete="off">
        <input type="text" id="nombre" name="nombre" placeholder="Nombre" required />
        <input type="text" id="apellido" name="apellido" placeholder="Apellido" required />
        <input type="tel" id="telefono" name="telefono" placeholder="Teléfono" required pattern="\d{7,15}" title="Solo números, 7-15 dígitos" />
        <input type="text" id="direccion" name="direccion" placeholder="Dirección" required />
        <input type="email" id="email" name="email" placeholder="Correo Electrónico" required />
        <input type="password" id="password" name="password" placeholder="Contraseña" required minlength="6" />
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmar Contraseña" required minlength="6" />
        <input type="submit" value="Registrarse" />
      </form>

    </div>
  </div>
</body>
</html>
