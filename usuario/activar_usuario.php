<?php
// activar_usuario.php
include '../includes/conexion.php';
include '../clases/Usuario.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$usuario = new Usuario($db);
$usuario->id = isset($_GET['id']) ? $_GET['id'] : die('ID de usuario no especificado');

if($usuario->activar()){
    header("Location: index_usuario.php?activado=1");
} else {
    header("Location: index_usuario.php?error=1");
}
exit();