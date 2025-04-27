<?php
include '../conexion.php'; 
include '../Inventario.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$inventario = new Inventario($db);

$inventario->ID_INVENTARIO = isset($_GET['ID_INVENTARIO']) ? $_GET['ID_INVENTARIO'] : die('ERROR: ID no encontrado.');

$inventario->leerUno();

if ($_POST) {
    $inventario->CODIGO_MENU = $_POST['CODIGO_MENU'];
    $inventario->NOMBRE_INGREDIENTE = $_POST['NOMBRE_INGREDIENTE'];
    $inventario->CANTIDAD = $_POST['CANTIDAD'];
    $inventario->ID_USUARIO = $_POST['ID_USUARIO'];
    
    if ($inventario->actualizar()) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <i class='bi bi-check-circle-fill'></i> Registro de inventario actualizado exitosamente.
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <i class='bi bi-exclamation-triangle-fill'></i> No se pudo actualizar el registro de inventario.
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    }
}

include '../includes/head.php'; // Include header file for Bootstrap and other styles
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-box-seam"></i> Editar Inventario</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?ID_INVENTARIO={$inventario->ID_INVENTARIO}"); ?>" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="CODIGO_MENU" class="form-label"><i class="bi bi-upc-scan"></i> Código Menú</label>
                                <input type="text" class="form-control" id="CODIGO_MENU" name="CODIGO_MENU" 
                                       value="<?= htmlspecialchars($inventario->CODIGO_MENU) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="NOMBRE_INGREDIENTE" class="form-label"><i class="bi bi-basket"></i> Nombre del Ingrediente</label>
                                <input type="text" class="form-control" id="NOMBRE_INGREDIENTE" name="NOMBRE_INGREDIENTE" 
                                       value="<?= htmlspecialchars($inventario->NOMBRE_INGREDIENTE) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="CANTIDAD" class="form-label"><i class="bi bi-123"></i> Cantidad</label>
                                <input type="number" class="form-control" id="CANTIDAD" name="CANTIDAD" 
                                       value="<?= htmlspecialchars($inventario->CANTIDAD) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="ID_USUARIO" class="form-label"><i class="bi bi-person"></i> ID Usuario</label>
                                <input type="text" class="form-control" id="ID_USUARIO" name="ID_USUARIO" 
                                       value="<?= htmlspecialchars($inventario->ID_USUARIO) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-calendar"></i> Fecha de Registro</label>
                                <input type="text" class="form-control" 
                                       value="<?= date('d/m/Y', strtotime($inventario->FECHA_REGISTRO)) ?>" readonly>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary me-md-2">
                                        <i class="bi bi-save"></i> Guardar Cambios
                                    </button>
                                    <a href="index_inventario.php" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left"></i> Volver al Listado
                                    </a>
                                </div>
                            </div>
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