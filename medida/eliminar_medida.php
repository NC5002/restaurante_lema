<?php
include '../conexion.php'; 
include '../Medida.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$medida = new Medida($db);

$medida->ID_MEDIDA = isset($_GET['ID_MEDIDA']) ? $_GET['ID_MEDIDA'] : die('ERROR: ID no encontrado.');

if ($medida->eliminar()) {
    header('Location: index_medidas.php?action=deleted');
} else {
    die('No se pudo eliminar la medida.');
}
?>