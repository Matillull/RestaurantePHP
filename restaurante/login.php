<?php
session_start();

// Si ya está logueado, redirigir
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

require 'database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && $password === $usuario['password']) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_rol'] = $usuario['rol'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['mensaje'] = "Bienvenido, " . $usuario['nombre'];
        $_SESSION['mensaje_tipo'] = "success";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['mensaje'] = "Credenciales inválidas.";
        $_SESSION['mensaje_tipo'] = "danger";
    }
}
?>

<?php include 'includes/navbar.php'; ?>
<?php include 'includes/mensajes.php'; ?>

<div class="container mt-4">
  <h2>Iniciar sesión</h2>
  <form method="post" class="mt-3">
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input name="email" type="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Contraseña</label>
      <input name="password" type="password" class="form-control" required>
    </div>
    <button class="btn btn-success" type="submit">Entrar</button>
  </form>
</div>
