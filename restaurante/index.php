<?php
session_start();
include 'includes/navbar.php';
include 'includes/mensajes.php';
require 'database/db.php';

// Obtener menú
$stmt = $pdo->query("SELECT * FROM menu ORDER BY creado_en DESC");
$menuItems = $stmt->fetchAll();

// Datos del cliente
$usuario_id = $_SESSION['usuario_id'] ?? null;
$isCliente = ($_SESSION['usuario_rol'] ?? '') === 'cliente';

$favoritos = [];
$carrito = [];

if ($isCliente) {
    $stmt = $pdo->prepare("SELECT menu_id FROM favoritos WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $favoritos = array_column($stmt->fetchAll(), 'menu_id');

    $carrito = $_SESSION['cart'] ?? [];
}
?>

<div class="container mt-4">
  <h1 class="mb-4">Menú del Restaurante</h1>

  <form method="GET" class="mb-3 d-flex gap-2">
    <select name="ordenar" class="form-select w-auto">
      <option value="">Ordenar por...</option>
      <option value="precio">Precio</option>
      <option value="nombre">Nombre</option>
    </select>
    <button class="btn btn-secondary" type="submit">Ordenar</button>
  </form>

  <?php
  if (isset($_GET['ordenar'])) {
      if ($_GET['ordenar'] === 'precio') {
          usort($menuItems, fn($a, $b) => $a['precio'] <=> $b['precio']);
      } elseif ($_GET['ordenar'] === 'nombre') {
          usort($menuItems, fn($a, $b) => strcmp($a['nombre'], $b['nombre']));
      }
  }
  ?>

  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($menuItems as $item): ?>
      <div class="col">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($item['nombre']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($item['descripcion']) ?></p>
            <p><strong>$<?= number_format($item['precio'], 2) ?></strong></p>

            <?php if ($isCliente): ?>
              <div class="d-flex gap-2">
                <?php if (!isset($carrito[$item['id']])): ?>
                  <a href="pages/cliente/agregar_al_carrito.php?id=<?= $item['id'] ?>" class="btn btn-primary btn-sm">🛒 Agregar al carrito</a>
                <?php else: ?>
                  <span class="text-success">🛒 En carrito</span>
                <?php endif; ?>

                <?php if (in_array($item['id'], $favoritos)): ?>
                  <a href="pages/cliente/quitar_favorito.php?id=<?= $item['id'] ?>" class="btn btn-outline-secondary btn-sm">❌ Quitar de favoritos</a>
                <?php else: ?>
                  <a href="pages/cliente/agregar_favorito.php?id=<?= $item['id'] ?>" class="btn btn-outline-danger btn-sm">❤️ Favorito</a>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
