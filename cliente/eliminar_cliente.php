<?php
include '../includes/conexion.php'; 
include '../clases/Cliente.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$cliente = new Cliente($db);

$cliente->ID_CLIENTE = isset($_GET['ID_CLIENTE']) ? $_GET['ID_CLIENTE'] : die('ERROR: ID no encontrado.');

if($cliente->eliminar()){
    header('Location: listar_clientes.php?action=deleted');
} else{
    die('No se pudo eliminar el cliente.');
}
?>