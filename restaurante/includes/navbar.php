<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$rol = $_SESSION['usuario_rol'] ?? null;
$nombre = $_SESSION['usuario_nombre'] ?? null;
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
  <a class="navbar-brand" href="/restaurante/index.php">Restaurante</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <?php if ($rol === 'admin'): ?>
        <li class="nav-item"><a class="nav-link" href="/restaurante/pages/admin/add_menu.php">Agregar Menú</a></li>
        <li class="nav-item"><a class="nav-link" href="/restaurante/pages/admin/dashboard.php">Dashboard</a></li>
      <?php endif; ?>

      <?php if ($rol === 'cliente'): ?>
        <li class="nav-item"><a class="nav-link" href="/restaurante/pages/cliente/carrito.php">Carrito</a></li>
        <li class="nav-item"><a class="nav-link" href="/restaurante/pages/cliente/favoritos.php">Favoritos</a></li>
        <li class="nav-item"><a class="nav-link" href="/restaurante/pages/cliente/historial.php">Historial</a></li>
      <?php endif; ?>
    </ul>

    <ul class="navbar-nav">
      <?php if ($rol): ?>
        <li class="nav-item text-white me-2 d-flex align-items-center">
          <span>👋 Hola, <strong><?= htmlspecialchars($nombre) ?></strong></span>
        </li>
        <li class="nav-item"><a class="nav-link" href="/restaurante/logout.php">Cerrar sesión</a></li>
      <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="/restaurante/login.php">Iniciar sesión</a></li>
        <li class="nav-item"><a class="nav-link" href="/restaurante/register.php">Registrarse</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
<hr>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
