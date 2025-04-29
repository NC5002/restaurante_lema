<?php
include '../includes/conexion.php'; 
include '../clases/Inventario.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$inventario = new Inventario($db);

$inventario->ID_INVENTARIO = isset($_GET['ID_INVENTARIO']) ? $_GET['ID_INVENTARIO'] : die('ERROR: ID no encontrado.');

if ($inventario->eliminar()) {
    header('Location: index_inventario.php?action=deleted');
} else {
    die('No se pudo eliminar el registro de inventario.');
}
?>