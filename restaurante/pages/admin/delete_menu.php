<?php
// Incluir la cabecera y barra de navegación
include '../../includes/navbar.php';
include '../../includes/mensajes.php';
require '../../database/db.php';

// Iniciar la sesión
session_start();

// Verificar que el usuario sea administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

// Conectar con la base de datos
require '../../database/db.php';

// Obtener el ID del plato a eliminar desde la URL
$id = $_GET['id'] ?? null;

// Verificar que el ID sea válido
if ($id) {
    // Eliminar el plato del menú
    $stmt = $pdo->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->execute([$id]);
}

// Redirigir al panel principal
header("Location: dashboard.php");
exit;
