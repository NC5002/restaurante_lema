<?php
include '../includes/conexion.php';
include '../clases/Rol.php';
$database = new Conexion();
$db = $database->obtenerConexion();
$rol = new Rol($db);
$rol->id = isset($_GET['id']) ? $_GET['id'] : die('ID de rol no especificado');

// Verificar si el rol está en uso
if($rol->verificarUso()) {
    header("Location: index_rol.php?error=used");
    exit();
}

if($rol->eliminar()){
    header("Location: index_rol.php?eliminado=1");
} else {
    header("Location: index_rol.php?error=1");
}
exit();
?>