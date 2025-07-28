<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inicio de sesión</title>
  <link rel="stylesheet" href="/lib/css/inicio.css" />
</head>
<body>
  <div class="wrapper fadeInDown">
    <div id="formContent">
      <a href="/lib/pagina/inicio.php"><h2 class="active">Inicio de sesión</h2></a>
      <a href="/lib/pagina/registrosesion.php"><h2 class="inactive underlineHover">Registrarse</h2></a>

      <div class="fadeIn first">
        <img src="/lib/img/user.png" id="icon" alt="User Icon" />
      </div>

      <?php if (isset($_SESSION['error'])): ?>
        <div style="color: red; margin-bottom: 10px;">
          <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <form action="/srv/srv_inicio.php" method="post" autocomplete="off">
        <input type="email" name="username" placeholder="Correo electrónico" required class="fadeIn second" />
        <input type="password" name="password" placeholder="Contraseña" required class="fadeIn third" />
        <input type="submit" value="Iniciar sesión" class="fadeIn fourth" />
      </form>

      <div id="formFooter">
        <a href="#" class="underlineHover">¿Olvidaste tu contraseña?</a>
      </div>
    </div>
  </div>
</body>
</html>
