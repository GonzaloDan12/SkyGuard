<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Agregar Producto - SkyGuard Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/lib/css/agregar_producto.css" />
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
        <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/lista_productos.php"><i class="fas fa-shopping-cart"></i> Pedidos</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="/lib/pagina/lista_usuarios.php"><i class="fas fa-users"></i> Usuarios</a></li>
        <li class="nav-item px-3"><a class="nav-link" href="/index.html"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
      </ul>
    </div>
  </nav>

  <!-- CONTENIDO -->
  <div class="container-form">
    <a href="lista_productos.php" class="btn-back"><i class="fas fa-arrow-left"></i> Regresar al lista de productos</a>
    <h2 class="title">Agregar Nuevo Producto</h2>

    <form method="POST" action="/srv/agregar_producto_srv.php" enctype="multipart/form-data">
      <div class="form-group">
        <label for="nombre">Nombre del producto</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej. Dron SkyView X5" required />
      </div>
      <div class="form-group">
        <label for="precio">Precio</label>
        <input type="number" class="form-control" id="precio" name="precio" placeholder="Ej. 15000" required />
      </div>
      <div class="form-group">
        <label for="stock">Stock disponible</label>
        <input type="number" class="form-control" id="stock" name="stock" placeholder="Ej. 25" required />
      </div>
      <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Escribe una descripción del producto..." required></textarea>
      </div>
      <div class="form-group">
        <label for="imagen">Imagen del producto</label>
        <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*" />
      </div>
      <div class="btn-group-center">
        <button type="submit" class="btn btn-submit"><i class="fas fa-plus-circle"></i> Agregar producto</button>
        <button type="reset" class="btn btn-cancel">Cancelar</button>
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
