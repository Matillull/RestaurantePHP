<?php
session_start();
include '../../includes/navbar.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['mensaje'] = "Producto inválido.";
    $_SESSION['mensaje_tipo'] = "warning";
    header("Location: ../../index.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}

$_SESSION['mensaje'] = "Producto agregado al carrito.";
$_SESSION['mensaje_tipo'] = "success";
header("Location: ../../index.php");
exit;
?>
