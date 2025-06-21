<?php
session_start(); // Siempre al inicio
include 'includes/head.php';
include 'includes/navbar.php';
include 'includes/mensajes.php';

$id = $_GET['id'] ?? null; // Prevención si no se pasa id

if (!$id) {
    // Redirigir si no hay ID
    $_SESSION['mensaje'] = "Producto inválido.";
    $_SESSION['mensaje_tipo'] = "warning";
    header("Location: ../../index.php");
    exit;
}

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}

header("Location: ../../index.php");
exit;
