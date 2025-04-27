<?php
include '../conexion.php'; 
include '../Cliente.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$cliente = new Cliente($db);

if($_POST){
    $cliente->NUMERO_CEDULA = $_POST['NUMERO_CEDULA'];
    $cliente->NOMBRE = $_POST['NOMBRE'];
    $cliente->APELLIDO = $_POST['APELLIDO'];
    $cliente->TELEFONO = $_POST['TELEFONO'];
    $cliente->CORREO = $_POST['CORREO'];
    $cliente->DIRECCION = $_POST['DIRECCION'];
    
    if($cliente->crear()){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <i class='bi bi-check-circle-fill'></i> Cliente registrado exitosamente.
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    } else{
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <i class='bi bi-exclamation-triangle-fill'></i> No se pudo registrar el cliente.
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
                    <h3 class="mb-0"><i class="bi bi-person-plus"></i> Registrar Nuevo Cliente</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="NUMERO_CEDULA" class="form-label"><i class="bi bi-credit-card"></i> Número de Cédula</label>
                                <input type="text" class="form-control" id="NUMERO_CEDULA" name="NUMERO_CEDULA" required
                                       pattern="[0-9]{10}" title="Ingrese 10 dígitos numéricos">
                            </div>
                            <div class="col-md-6">
                                <label for="NOMBRE" class="form-label"><i class="bi bi-person"></i> Nombre</label>
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" required>
                            </div>
                            <div class="col-md-6">
                                <label for="APELLIDO" class="form-label"><i class="bi bi-person"></i> Apellido</label>
                                <input type="text" class="form-control" id="APELLIDO" name="APELLIDO" required>
                            </div>
                            <div class="col-md-6">
                                <label for="TELEFONO" class="form-label"><i class="bi bi-telephone"></i> Teléfono</label>
                                <input type="tel" class="form-control" id="TELEFONO" name="TELEFONO" 
                                       pattern="[0-9]{10}" title="Ingrese 10 dígitos numéricos">
                            </div>
                            <div class="col-md-6">
                                <label for="CORREO" class="form-label"><i class="bi bi-envelope"></i> Correo Electrónico</label>
                                <input type="email" class="form-control" id="CORREO" name="CORREO">
                            </div>
                            <div class="col-md-6">
                                <label for="DIRECCION" class="form-label"><i class="bi bi-house"></i> Dirección</label>
                                <input type="text" class="form-control" id="DIRECCION" name="DIRECCION">
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary me-md-2">
                                        <i class="bi bi-save"></i> Guardar Cliente
                                    </button>
                                    <a href="index_cliente.php" class="btn btn-outline-secondary">
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