<?php
include '../conexion.php'; 
include '../Categoria.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$categoria = new Categoria($db);

$categoria->ID_CATEGORIA = isset($_GET['ID_CATEGORIA']) ? $_GET['ID_CATEGORIA'] : die('ERROR: ID no encontrado.');

if($categoria->eliminar()){
    header('Location: index.php?action=deleted');
} else{
    die('No se pudo eliminar la categoría.');
}
?>