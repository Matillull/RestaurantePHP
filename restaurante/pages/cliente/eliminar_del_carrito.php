<?php
session_start();

// Verificar si existe el producto en el carrito
$id = $_GET['id'] ?? null;

if ($id && isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
    $_SESSION['mensaje'] = "Producto eliminado del carrito.";
    $_SESSION['mensaje_tipo'] = "success";
}

header("Location: carrito.php");
exit;
