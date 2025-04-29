<?php
include '../includes/conexion.php'; 
include '../clases/Proveedor.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$proveedor = new Proveedor($db);

if ($_POST) {
    $proveedor->RUC_CEDULA = $_POST['RUC_CEDULA'];
    $proveedor->NOMBRE = $_POST['NOMBRE'];
    $proveedor->DIRECCION = $_POST['DIRECCION'];
    $proveedor->TELEFONO = $_POST['TELEFONO'];
    $proveedor->CORREO = $_POST['CORREO'];
    $proveedor->OBSERVACIONES = $_POST['OBSERVACIONES'];
    
    if ($proveedor->crear()) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <i class='bi bi-check-circle-fill'></i> Proveedor registrado exitosamente.
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <i class='bi bi-exclamation-triangle-fill'></i> No se pudo registrar el proveedor.
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
                <div class="card-header bg-dark">
                    <h3 class="mb-0 color-primario"><i class="bi bi-truck"></i>Nuevo Proveedor</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                
                                <input type="text" class="form-control" id="RUC_CEDULA" name="RUC_CEDULA" required placeholder="cedula">
                                <label for="RUC_CEDULA" class="form-label">RUC/Cédula</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" required placeholder="nombre">
                                <label for="NOMBRE" class="form-label">Nombre</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <input type="text" class="form-control" id="DIRECCION" name="DIRECCION" placeholder="direccion">
                                <label for="DIRECCION" class="form-label">Dirección</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <input type="tel" class="form-control" id="TELEFONO" name="TELEFONO" 
                                       pattern="[0-9]{10}" title="Ingrese 10 dígitos numéricos" placeholder="telefono">
                                       <label for="TELEFONO" class="form-label">Teléfono</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <input type="email" class="form-control" id="CORREO" name="CORREO" placeholder="correo">
                                <label for="CORREO" class="form-label">Correo Electrónico</label>
                            </div>
                            <div class="col-md-12 form-floating">
                            
                                <textarea class="form-control" id="OBSERVACIONES" name="OBSERVACIONES" rows="3" placeholder="observaciones"></textarea>
                                <label for="OBSERVACIONES" class="form-label">Observaciones</label>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primario me-md-2">
                                        <i class="bi bi-save"></i> Guardar Proveedor
                                    </button>
                                    <a href="index_proveedor.php" class="btn btn-secundario">
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