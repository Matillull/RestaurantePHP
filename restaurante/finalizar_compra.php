<?php
session_start();
include 'includes/head.php';
include 'includes/navbar.php';
include 'includes/mensajes.php';
require '../../database/db.php';

$cart = $_SESSION['cart'] ?? [];
$usuario_id = $_SESSION['usuario_id'] ?? null;

if (!$cart || !$usuario_id) {
    $_SESSION['mensaje'] = "Debes iniciar sesión y tener productos en el carrito.";
    $_SESSION['mensaje_tipo'] = "warning";
    header("Location: carrito.php");
    exit;
}

// Obtener menú y calcular total
$placeholders = implode(',', array_fill(0, count($cart), '?'));
$stmt = $pdo->prepare("SELECT * FROM menu WHERE id IN ($placeholders)");
$stmt->execute(array_keys($cart));
$items = $stmt->fetchAll();

$total = 0;
foreach ($items as $item) {
    $total += $cart[$item['id']] * $item['precio'];
}

// Insertar orden
$stmt = $pdo->prepare("INSERT INTO ordenes (usuario_id, total) VALUES (?, ?)");
$stmt->execute([$usuario_id, $total]);
$orden_id = $pdo->lastInsertId();

// Insertar ítems
foreach ($items as $item) {
    $stmt = $pdo->prepare("INSERT INTO orden_items (orden_id, menu_id, cantidad) VALUES (?, ?, ?)");
    $stmt->execute([$orden_id, $item['id'], $cart[$item['id']]]);
}

// Simular email
mail("cliente@example.com", "Gracias por tu compra", "Total: $$total");

// Limpiar carrito
unset($_SESSION['cart']);

echo "<p>Compra finalizada. Total: $$total</p><a href='../../index.php'>Volver al inicio</a>";
