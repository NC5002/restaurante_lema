<?php
include '../includes/conexion.php'; 
include '../clases/Menu.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$menu = new Menu($db);

$menu->CODIGO_MENU = isset($_GET['CODIGO_MENU']) ? $_GET['CODIGO_MENU'] : die('ERROR: ID no encontrado.');

if($menu->eliminar()){
    header('Location: listar_menu.php?action=deleted');
} else{
    die('No se pudo desactivar el ítem de menú.');
}
?>