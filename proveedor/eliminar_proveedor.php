<?php
include '../conexion.php'; 
include '../Proveedor.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$proveedor = new Proveedor($db);

$proveedor->ID_PROVEEDOR = isset($_GET['ID_PROVEEDOR']) ? $_GET['ID_PROVEEDOR'] : die('ERROR: ID no encontrado.');

if ($proveedor->eliminar()) {
    header('Location: index_proveedores.php?action=deleted');
} else {
    die('No se pudo eliminar el proveedor.');
}
?>