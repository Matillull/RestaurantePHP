<?php
session_start();
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

require '../../database/db.php';
include '../../includes/navbar.php';
include '../../includes/mensajes.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    $_SESSION['mensaje'] = "ID inválido.";
    header("Location: dashboard.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->execute([$id]);
$menu = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    $stmt = $pdo->prepare("UPDATE menu SET nombre = ?, descripcion = ?, precio = ? WHERE id = ?");
    $stmt->execute([$nombre, $descripcion, $precio, $id]);

    $_SESSION['mensaje'] = "Menú actualizado correctamente.";
    header("Location: dashboard.php");
    exit;
}
?>

<div class="container mt-4">
  <h2>Editar plato</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Nombre</label>
      <input class="form-control" name="nombre" value="<?= htmlspecialchars($menu['nombre']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea class="form-control" name="descripcion"><?= htmlspecialchars($menu['descripcion']) ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Precio</label>
      <input class="form-control" type="number" name="precio" step="0.01" value="<?= $menu['precio'] ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Guardar cambios</button>
  </form>
</div>
