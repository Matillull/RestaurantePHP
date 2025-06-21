<?php
session_start();

// Redirigir si ya está logueado
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

require 'database/db.php';

$errores = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol = $_POST['rol'] ?? 'cliente';

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $email, $password, $rol]);
        $_SESSION['mensaje'] = "Registrado correctamente.";
        $_SESSION['mensaje_tipo'] = "success";
        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        $errores = "Error al registrar: " . $e->getMessage();
    }
}
?>

<?php include 'includes/navbar.php'; ?>
<?php include 'includes/mensajes.php'; ?>

<div class="container mt-4">
  <h2>Registrarse</h2>
  <?php if ($errores): ?>
    <div class="alert alert-danger"><?= $errores ?></div>
  <?php endif; ?>
  <form method="post" class="mt-3">
    <div class="mb-3">
      <label class="form-label">Nombre</label>
      <input name="nombre" type="text" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input name="email" type="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Contraseña</label>
      <input name="password" type="password" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Rol</label>
      <select name="rol" class="form-select">
        <option value="cliente" selected>Cliente</option>
        <option value="admin">Admin</option>
      </select>
    </div>
    <button class="btn btn-primary" type="submit">Registrarse</button>
  </form>
</div>
