<?php
include '../conexion.php'; 
include '../Categoria.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$categoria = new Categoria($db);

$categoria->ID_CATEGORIA = isset($_GET['ID_CATEGORIA']) ? $_GET['ID_CATEGORIA'] : die('ERROR: ID no encontrado.');

$categoria->leerUno();

if($_POST){
    $categoria->NOMBRE = $_POST['NOMBRE'];
    
    if($categoria->actualizar()){
        echo "<div class='alert alert-success'>Categoría actualizada exitosamente.</div>";
    } else{
        echo "<div class='alert alert-danger'>No se pudo actualizar la categoría.</div>";
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
                    <div class="card-header bg-primary text-white">
                        <h2 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Categoría</h2>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?ID_CATEGORIA={$categoria->ID_CATEGORIA}"); ?>" method="post">
                            <div class="mb-3">
                                <label for="NOMBRE" class="form-label"><i class="bi bi-tag"></i> Nombre</label>
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" value="<?php echo htmlspecialchars($categoria->NOMBRE); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-info-circle"></i> Estado</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($categoria->ESTADO); ?>" readonly>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary me-md-2"><i class="bi bi-save"></i> Guardar Cambios</button>
                                <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
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