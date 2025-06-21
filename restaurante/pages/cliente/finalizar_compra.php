<?php
session_start();
require '../../database/db.php';

$usuario_id = $_SESSION['usuario_id'] ?? null;
$carrito = $_SESSION['cart'] ?? [];

if (!$usuario_id || empty($carrito)) {
    header("Location: carrito.php");
    exit;
}

$placeholders = implode(',', array_fill(0, count($carrito), '?'));
$stmt = $pdo->prepare("SELECT * FROM menu WHERE id IN ($placeholders)");
$stmt->execute(array_keys($carrito));
$productos = $stmt->fetchAll();

$total = 0;
foreach ($productos as $producto) {
    $total += $producto['precio'] * $carrito[$producto['id']];
}

// Insertar orden
$stmt = $pdo->prepare("INSERT INTO ordenes (usuario_id, total) VALUES (?, ?)");
$stmt->execute([$usuario_id, $total]);
$orden_id = $pdo->lastInsertId();

// Insertar ítems
foreach ($productos as $producto) {
    $stmt = $pdo->prepare("INSERT INTO orden_items (orden_id, menu_id, cantidad) VALUES (?, ?, ?)");
    $stmt->execute([$orden_id, $producto['id'], $carrito[$producto['id']]]);

    $detalle[] = $producto['nombre'] . " x" . $carrito[$producto['id']];
}

// Limpiar carrito
unset($_SESSION['cart']);

// Simulación de email
$mensaje = "Gracias por tu compra. Total: $$total\n\n" . implode("\n", $detalle);
mail("cliente@demo.com", "Tu pedido en el restaurante", $mensaje);

$_SESSION['mensaje'] = "Compra finalizada con éxito.";
$_SESSION['mensaje_tipo'] = "success";
header("Location: historial.php");
exit;
