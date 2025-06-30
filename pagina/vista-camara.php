<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Vista de Cámara del Dron</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap CSS -->
  <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
  />
  <!-- FontAwesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding-top: 0px;  /* espacio para navbar fijo */
      padding-bottom: 0px; /* espacio para footer fijo */
    }
    .container {
      width: 80%;
      margin: 30px auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
    }
    .stream {
      width: 100%;
      max-width: 700px;
      margin: 0 auto 20px;
      display: block;
    }
    .btn-group {
      margin-bottom: 20px;
    }
    button {
      padding: 10px 20px;
      margin-right: 10px;
      border: none;
      border-radius: 4px;
      background: #56baed;
      color: #fff;
      cursor: pointer;
    }
    button.active {
      background: #56baed;
    }
    .media-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 25px;
      justify-items: center;
    }
    .media-grid img,
    .media-grid video {
      width: 100%;
      max-width: 320px;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 2px 6px #ccc;
    }
    /* NAVBAR */
    nav.navbar {
      background-color: #56baed;
      width: 100%;

      top: 0;
      left: 0;
      right: 0;
      z-index: 1030;
      padding-left: 1rem;
      padding-right: 1rem;
    }
    .navbar-brand,
    .nav-link {
      color: white !important;
      font-weight: 500;
    }
    .navbar-brand:hover,
    .nav-link:hover {
      color: #1f2533 !important;
    }
    .navbar-social-icons a {
      color: white;
      margin-left: 10px;
      font-size: 18px;
    }
    .navbar-social-icons a:hover {
      color: #1f2533;
    }
    /* FOOTER */
    footer.footer {
      background-color: #56baed;
      color: white;
      padding: 40px 0;
      bottom: 0;
      left: 0;
      width: 100%;
      text-align: center;
      box-sizing: border-box;
      z-index: 1030;
    }
    footer.footer .social-icons i {
      font-size: 20px;
      margin: 0 10px;
      color: #1f2533;
      cursor: pointer;
      transition: color 0.3s;
    }
    footer.footer .social-icons i:hover {
      color: white;
    }
    @media (max-width: 768px) {
      .media-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      button {
        margin-bottom: 10px;
        width: 100%;
      }
      .btn-group {
        display: flex;
        flex-direction: column;
      }
      .navbar-social-icons a {
        margin-left: 5px;
        font-size: 16px;
      }
    }
  </style>
</head>
<body>
  <!-- NAV -->
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">SkyGuard</a>

    <button
      class="navbar-toggler text-white"
      type="button"
      data-toggle="collapse"
      data-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item px-3">
          <a class="nav-link" href="/pagina/perfil_user.html">Perfil</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="#">Pagos</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="/index.html">Cerrar Sesion</a>
        </li>
      </ul>
    </div>

    <div class="ml-auto d-flex align-items-center navbar-social-icons">
      <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
      <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
      <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
    </div>
  </nav>

  <div class="container">
    <h2>Transmisión del dron</h2>
    <!-- esto es para poder hacer la vinculación de la transmisión -->
    <img
      class="stream"
      src="https://placehold.co/700x400?text=Transmision+En+Vivo"
      alt="Transmisión en vivo"
    />

    <div class="btn-group">
      <form method="get" style="display: inline;">
        <button
          type="submit"
          name="media"
          value="photos"
          <?php if ($_GET['media'] ?? '' === 'photos') echo 'class="active"'; ?>
        >
          Fotos
        </button>
      </form>
      <form method="get" style="display: inline;">
        <button
          type="submit"
          name="media"
          value="videos"
          <?php if ($_GET['media'] ?? '' === 'videos') echo 'class="active"'; ?>
        >
          Videos
        </button>
      </form>
    </div>

    <div class="media-grid">
      <?php
      $mediaType = $_GET['media'] ?? 'photos';
      $dir = $mediaType === 'videos' ? 'videos' : 'fotos';
      $allowed = $mediaType === 'videos' ? ['mp4', 'webm', 'ogg'] : ['jpg', 'jpeg', 'png', 'gif'];

      if (is_dir($dir)) {
        $files = array_diff(scandir($dir), ['.', '..']);
        $hasFiles = false;
        foreach ($files as $file) {
          $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
          if (in_array($ext, $allowed)) {
            $hasFiles = true;
            if ($mediaType === 'photos') {
              echo "<img src='$dir/$file' alt='Foto del dron'>";
            } else {
              echo "<video controls src='$dir/$file'></video>";
            }
          }
        }
        if (!$hasFiles) {
          echo "<p>No hay archivos disponibles.</p>";
        }
      } else {
        echo "<p>No hay archivos disponibles.</p>";
      }
      ?>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="footer">
    <div>
      <h5>Sobre SkyGuard</h5>
      <p>
        SkyGuard es una empresa líder en venta de drones para seguridad,
        vigilancia y monitoreo inteligente.
      </p>
      <div class="social-icons mt-2">
        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
      </div>
      <p class="mt-3 mb-0">© 2025 SkyGuard. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- Scripts Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"
  ></script>
</body>
</html>
