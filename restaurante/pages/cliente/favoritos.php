<?php
include '../../includes/head.php';
include '../../includes/navbar.php';
include '../../includes/mensajes.php';
require '../../database/db.php';

session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'cliente') {
    header("Location: ../../login.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("
    SELECT m.*
    FROM favoritos f
    JOIN menu m ON f.menu_id = m.id
    WHERE f.usuario_id = ?
");
$stmt->execute([$id_usuario]);
$favoritos = $stmt->fetchAll();
?>

<div class="container mt-5">
    <h2 class="mb-4">Mis Favoritos</h2>

    <?php if (empty($favoritos)): ?>
        <div class="alert alert-info">No tenés platos favoritos todavía.</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($favoritos as $item): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($item['nombre']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($item['descripcion']) ?></p>
                            <p class="card-text"><strong>$<?= number_format($item['precio'], 2) ?></strong></p>
                            <a href="quitar_favorito.php?id=<?= $item['id'] ?>" class="btn btn-danger">Quitar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
