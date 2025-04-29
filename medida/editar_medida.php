<?php
include '../includes/conexion.php'; 
include '../clases/Medida.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$medida = new Medida($db);

$medida->ID_MEDIDA = isset($_GET['ID_MEDIDA']) ? $_GET['ID_MEDIDA'] : die('ERROR: ID no encontrado.');

$medida->leerUno();

if ($_POST) {
    $medida->DESCRIPCION = $_POST['DESCRIPCION'];
    
    if ($medida->actualizar()) {
        echo "<div class='alert alert-success'>Medida actualizada exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>No se pudo actualizar la medida.</div>";
    }
}

include '../includes/head.php'; // Include header file for Bootstrap and other styles
include '../includes/header.php';
?>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h2 class="mb-0 color-primario"><i class="bi bi-pencil-square"></i> Editar Medida</h2>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?ID_MEDIDA={$medida->ID_MEDIDA}"); ?>" method="post">
                            <div class="mb-3 form-floating">
                                
                                <input type="text" class="form-control" id="DESCRIPCION" name="DESCRIPCION" value="<?php echo htmlspecialchars($medida->DESCRIPCION); ?>" required placeholder="descripcion">
                                <label for="DESCRIPCION" class="form-label"><i class="bi bi-tag"></i> Descripción</label>
                            </div>
                            <div class="mb-3 form-floating">
                            
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($medida->FECHA_REGISTRO); ?>" readonly placeholder="fecha">
                                <label class="form-label"><i class="bi bi-calendar"></i> Fecha de Registro</label>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primario me-md-2"><i class="bi bi-save"></i> Guardar Cambios</button>
                                <a href="index_medida.php" class="btn btn-secundario"><i class="bi bi-arrow-left"></i> Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php 
include '../includes/footer.php'; // Include footer file for Bootstrap and other scripts
?>