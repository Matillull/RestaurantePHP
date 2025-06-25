<?php
// Iniciar la sesión
session_start();

// Incluir la cabecera y barra de navegación
include '../../includes/navbar.php';
include '../../includes/mensajes.php';
require '../../database/db.php';


// Verificar que el usuario sea administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

// Conectar con la base de datos
require '../../database/db.php';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;

    $stmt = $pdo->prepare("INSERT INTO menu (nombre, descripcion, precio) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $precio]);

    $_SESSION['mensaje'] = "Plato agregado correctamente.";
    $_SESSION['mensaje_tipo'] = "success";
    header("Location: dashboard.php");
    exit;
}
?>

<!-- Formulario con Bootstrap -->
<div class="container mt-4">
  <h2>Agregar nuevo plato al menú</h2>
  <form method="POST" class="mt-4">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre del plato</label>
      <input class="form-control" name="nombre" id="nombre" required>
    </div>
    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea class="form-control" name="descripcion" id="descripcion"></textarea>
    </div>
    <div class="mb-3">
      <label for="precio" class="form-label">Precio</label>
      <input class="form-control" name="precio" type="number" step="0.01" id="precio" required>
    </div>
    <button type="submit" class="btn btn-primary">Agregar al menú</button>
  </form>
</div>
