<?php
include '../includes/conexion.php';
include '../clases/Receta.php';

$receta = new Receta($database->obtenerConexion());
$receta->id = isset($_GET['id']) ? $_GET['id'] : die('ID de receta no especificado');

if($receta->eliminar()){
    header("Location: index_receta.php?eliminado=1");
} else {
    header("Location: index_receta.php?error=1");
}
exit();
?>