<?php
session_start();
require '../../database/db.php';
include '../../includes/navbar.php';
include '../../includes/mensajes.php';

$carrito = $_SESSION['cart'] ?? [];

if (empty($carrito)) {
    echo "<div class='container mt-4'><div class='alert alert-info'>El carrito está vacío.</div></div>";
    exit;
}

$placeholders = implode(',', array_fill(0, count($carrito), '?'));
$stmt = $pdo->prepare("SELECT * FROM menu WHERE id IN ($placeholders)");
$stmt->execute(array_keys($carrito));
$productos = $stmt->fetchAll();

$total = 0;
?>

<div class="container mt-4">
  <h2>Tu carrito</h2>
  <?php foreach ($productos as $item): ?>
    <?php $subtotal = $carrito[$item['id']] * $item['precio']; $total += $subtotal; ?>
    <div class="card mb-3">
      <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($item['nombre']) ?></h5>
        <p class="card-text">Cantidad: <?= $carrito[$item['id']] ?></p>
        <p class="card-text">Subtotal: $<?= number_format($subtotal, 2) ?></p>
        <a href="eliminar_del_carrito.php?id=<?= $item['id'] ?>" class="btn btn-danger btn-sm">🗑️ Eliminar</a>
      </div>
    </div>
  <?php endforeach; ?>
  <div class="mt-3">
    <h4>Total: $<?= number_format($total, 2) ?></h4>
    <a href="finalizar_compra.php" class="btn btn-success">Finalizar compra</a>
  </div>
</div>
