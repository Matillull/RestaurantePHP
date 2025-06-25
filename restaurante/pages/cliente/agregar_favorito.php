<?php
// Incluir la cabecera y barra de navegación
session_start();
include '../../includes/navbar.php';
include '../../includes/mensajes.php';
require '../../database/db.php';

// Iniciar la sesión

// Verificar que el usuario sea cliente
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'cliente') {
    header("Location: ../../login.php");
    exit;
}

// Conectar con la base de datos
require '../../database/db.php';

// Obtener el ID del usuario y el plato
$id_usuario = $_SESSION['usuario_id'];
$id_menu = $_GET['id'] ?? null;

// Agregar a favoritos si el ID del menú es válido
if ($id_menu) {
    $stmt = $pdo->prepare("INSERT IGNORE INTO favoritos (usuario_id, menu_id) VALUES (?, ?)");
    $stmt->execute([$id_usuario, $id_menu]);
}

// Redirigir al inicio
header("Location: ../../index.php");
exit;
