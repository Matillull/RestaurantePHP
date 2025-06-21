<?php
session_start();
require '../../database/db.php';
include '../../includes/navbar.php';
include '../../includes/mensajes.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM ordenes WHERE usuario_id = ? ORDER BY creado_en DESC");
$stmt->execute([$usuario_id]);
$ordenes = $stmt->fetchAll();
?>

<div class="container mt-4">
  <h2>Historial de compras</h2>
  <?php if (!$ordenes): ?>
    <div class="alert alert-info">No tenés compras registradas.</div>
  <?php else: ?>
    <?php foreach ($ordenes as $orden): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Orden #<?= $orden['id'] ?> - $<?= $orden['total'] ?> - <?= $orden['creado_en'] ?></h5>
          <?php
          $stmtItems = $pdo->prepare("SELECT m.nombre, oi.cantidad FROM orden_items oi JOIN menu m ON m.id = oi.menu_id WHERE oi.orden_id = ?");
          $stmtItems->execute([$orden['id']]);
          $items = $stmtItems->fetchAll();
          ?>
          <ul class="list-group list-group-flush">
            <?php foreach ($items as $item): ?>
              <li class="list-group-item"><?= $item['nombre'] ?> x<?= $item['cantidad'] ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
