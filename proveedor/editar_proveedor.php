<?php
include '../conexion.php'; 
include '../Proveedor.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$proveedor = new Proveedor($db);

$proveedor->ID_PROVEEDOR = isset($_GET['ID_PROVEEDOR']) ? $_GET['ID_PROVEEDOR'] : die('ERROR: ID no encontrado.');

$proveedor->leerUno();

if ($_POST) {
    $proveedor->RUC_CEDULA = $_POST['RUC_CEDULA'];
    $proveedor->NOMBRE = $_POST['NOMBRE'];
    $proveedor->DIRECCION = $_POST['DIRECCION'];
    $proveedor->TELEFONO = $_POST['TELEFONO'];
    $proveedor->CORREO = $_POST['CORREO'];
    $proveedor->OBSERVACIONES = $_POST['OBSERVACIONES'];
    
    if ($proveedor->actualizar()) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <i class='bi bi-check-circle-fill'></i> Proveedor actualizado exitosamente.
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <i class='bi bi-exclamation-triangle-fill'></i> No se pudo actualizar el proveedor.
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
                    <h3 class="mb-0"><i class="bi bi-truck"></i> Editar Proveedor</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?ID_PROVEEDOR={$proveedor->ID_PROVEEDOR}"); ?>" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="RUC_CEDULA" class="form-label"><i class="bi bi-credit-card"></i> RUC/Cédula</label>
                                <input type="text" class="form-control" id="RUC_CEDULA" name="RUC_CEDULA" 
                                       value="<?= htmlspecialchars($proveedor->RUC_CEDULA) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="NOMBRE" class="form-label"><i class="bi bi-person"></i> Nombre</label>
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" 
                                       value="<?= htmlspecialchars($proveedor->NOMBRE) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="DIRECCION" class="form-label"><i class="bi bi-house"></i> Dirección</label>
                                <input type="text" class="form-control" id="DIRECCION" name="DIRECCION" 
                                       value="<?= htmlspecialchars($proveedor->DIRECCION) ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="TELEFONO" class="form-label"><i class="bi bi-telephone"></i> Teléfono</label>
                                <input type="tel" class="form-control" id="TELEFONO" name="TELEFONO" 
                                       value="<?= htmlspecialchars($proveedor->TELEFONO) ?>" 
                                       pattern="[0-9]{10}" title="Ingrese 10 dígitos numéricos">
                            </div>
                            <div class="col-md-6">
                                <label for="CORREO" class="form-label"><i class="bi bi-envelope"></i> Correo Electrónico</label>
                                <input type="email" class="form-control" id="CORREO" name="CORREO" 
                                       value="<?= htmlspecialchars($proveedor->CORREO) ?>">
                            </div>
                            <div class="col-md-12">
                                <label for="OBSERVACIONES" class="form-label"><i class="bi bi-chat-left-text"></i> Observaciones</label>
                                <textarea class="form-control" id="OBSERVACIONES" name="OBSERVACIONES" rows="3"><?= htmlspecialchars($proveedor->OBSERVACIONES) ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-calendar"></i> Fecha de Registro</label>
                                <input type="text" class="form-control" 
                                       value="<?= date('d/m/Y', strtotime($proveedor->FECHA_REGISTRO)) ?>" readonly>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary me-md-2">
                                        <i class="bi bi-save"></i> Guardar Cambios
                                    </button>
                                    <a href="index_proveedor.php" class="btn btn-outline-secondary">
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