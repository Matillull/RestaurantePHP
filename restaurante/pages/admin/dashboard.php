<?php
session_start();
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

require '../../database/db.php';
include '../../includes/navbar.php';
include '../../includes/mensajes.php';

$stmt = $pdo->query("SELECT * FROM menu ORDER BY creado_en DESC");
$menuItems = $stmt->fetchAll();
?>

<div class="container mt-4">
  <h2>Gestión del Menú</h2>

  <a href="add_menu.php" class="btn btn-success mb-3">➕ Agregar nuevo plato</a>

  <div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Precio</th>
          <th>Fecha de creación</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($menuItems as $item): ?>
          <tr>
            <td><?= $item['id'] ?></td>
            <td><?= htmlspecialchars($item['nombre']) ?></td>
            <td><?= htmlspecialchars($item['descripcion']) ?></td>
            <td>$<?= number_format($item['precio'], 2) ?></td>
            <td><?= $item['creado_en'] ?></td>
            <td>
              <a href="edit_menu.php?id=<?= $item['id'] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
              <a href="delete_menu.php?id=<?= $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este plato?')">🗑️ Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($menuItems)): ?>
          <tr><td colspan="6" class="text-center">No hay platos en el menú.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
