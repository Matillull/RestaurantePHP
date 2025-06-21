<?php
// Incluir la cabecera y barra de navegación
include '../../includes/head.php';
include '../../includes/navbar.php';
include '../../includes/mensajes.php';
require '../../database/db.php';


// Iniciar la sesión
session_start();

// Verificar que el usuario sea cliente
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'cliente') {
    header("Location: ../../login.php");
    exit;
}

// Conectar con la base de datos
require '../../database/db.php';

// Obtener el ID del usuario y del menú
$id_usuario = $_SESSION['usuario_id'];
$id_menu = $_GET['id'] ?? null;

// Eliminar de favoritos si el ID del menú es válido
if ($id_menu) {
    $stmt = $pdo->prepare("DELETE FROM favoritos WHERE usuario_id = ? AND menu_id = ?");
    $stmt->execute([$id_usuario, $id_menu]);
}

// Redirigir a la lista de favoritos
header("Location: favoritos.php");
exit;
