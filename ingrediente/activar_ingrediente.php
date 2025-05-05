<?php
include '../includes/conexion.php';
include '../clases/Ingrediente.php';

$database = new Conexion();
$db       = $database->obtenerConexion();
$ing      = new Ingrediente($db);

$ing->ID_INGREDIENTE = isset($_GET['ID_INGREDIENTE']) ? $_GET['ID_INGREDIENTE'] : die('ID no encontrado.');
if($ing->activar()){
    echo "<div class='alert alert-success'>Ingrediente activado.</div>";
} else {
    echo "<div class='alert alert-danger'>Error al activar.</div>";
}
header("Refresh:2; url=index_ingrediente.php");
?>
