<?php
include '../includes/conexion.php'; 
include '../clases/Cliente.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$cliente = new Cliente($db);

$cliente->ID_CLIENTE = isset($_GET['ID_CLIENTE']) ? $_GET['ID_CLIENTE'] : die('ERROR: ID no encontrado.');

$cliente->leerUno();

if($_POST){
    $cliente->NUMERO_CEDULA = $_POST['NUMERO_CEDULA'];
    $cliente->NOMBRE = $_POST['NOMBRE'];
    $cliente->APELLIDO = $_POST['APELLIDO'];
    $cliente->TELEFONO = $_POST['TELEFONO'];
    $cliente->CORREO = $_POST['CORREO'];
    $cliente->DIRECCION = $_POST['DIRECCION'];
    
    if($cliente->actualizar()){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <i class='bi bi-check-circle-fill'></i> Cliente actualizado exitosamente.
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    } else{
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <i class='bi bi-exclamation-triangle-fill'></i> No se pudo actualizar el cliente.
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
                    <h3 class="mb-0 color-primario"><i class="bi bi-person-lines-fill"></i> Editar Cliente</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?ID_CLIENTE={$cliente->ID_CLIENTE}"); ?>" method="post">
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                
                                <input type="text" class="form-control" id="NUMERO_CEDULA" name="NUMERO_CEDULA" 
                                       value="<?= htmlspecialchars($cliente->NUMERO_CEDULA) ?>" required
                                       pattern="[0-9]{10}" title="Ingrese 10 dígitos numéricos" placeholder="cedula">
                                <label for="NUMERO_CEDULA" class="form-label">Número de Cédula</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" 
                                       value="<?= htmlspecialchars($cliente->NOMBRE) ?>" required  placeholder="nombre">
                                       <label for="NOMBRE" class="form-label">Nombre</label>
                            </div>
                            <div class="col-md-6 form-floating">
                               
                                <input type="text" class="form-control" id="APELLIDO" name="APELLIDO" 
                                       value="<?= htmlspecialchars($cliente->APELLIDO) ?>" required  placeholder="apellido">
                                       <label for="APELLIDO" class="form-label">Apellido</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <input type="tel" class="form-control" id="TELEFONO" name="TELEFONO" 
                                       value="<?= htmlspecialchars($cliente->TELEFONO) ?>"
                                       pattern="[0-9]{10}" title="Ingrese 10 dígitos numéricos"  placeholder="telefono">
                                       <label for="TELEFONO" class="form-label">Teléfono</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <input type="email" class="form-control" id="CORREO" name="CORREO" 
                                       value="<?= htmlspecialchars($cliente->CORREO) ?>"  placeholder="correo">
                                       <label for="CORREO" class="form-label">Correo Electrónico</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <input type="text" class="form-control" id="DIRECCION" name="DIRECCION" 
                                       value="<?= htmlspecialchars($cliente->DIRECCION) ?>"  placeholder="direccion">
                                       <label for="DIRECCION" class="form-label">Dirección</label>
                            </div>
                            <div class="col-md-6 form-floating">
                               
                                <input type="text" class="form-control" 
                                       value="<?= date('d/m/Y', strtotime($cliente->FECHA_REGISTRO)) ?>" readonly  placeholder="fecha">
                                       <label class="form-label">Fecha de Registro</label>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primario me-md-2">
                                        <i class="bi bi-save"></i> Guardar Cambios
                                    </button>
                                    <a href="index_cliente.php" class="btn btn-secundario">
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