<?php
include '../includes/conexion.php'; 
include '../clases/Medida.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$medida = new Medida($db);

if ($_POST) {
    $medida->DESCRIPCION = $_POST['DESCRIPCION'];
    
    if ($medida->crear()) {
        echo "<div class='alert alert-success'>Medida creada exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>No se pudo crear la medida.</div>";
    }
}

include '../includes/head.php'; // Include header file for Bootstrap and other styles
include '../includes/header_configuracion.php';
?>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h2 class="mb-0 color-primario"><i class="bi bi-plus-circle"></i> Crear Nueva Medida</h2>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="mb-3 form-floating">
                                
                                <input type="text" class="form-control" id="DESCRIPCION" name="DESCRIPCION" required placeholder="descripcion">
                                <label for="DESCRIPCION" class="form-label">Descripción</label>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primario me-md-2"><i class="bi bi-save"></i> Guardar</button>
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