<?php
include '../includes/conexion.php'; 
include '../clases/Cliente.php';

function validarCedula($cedula) {
    // Verificar que la cédula tenga exactamente 10 dígitos
    if (strlen($cedula) != 10) {
        return "La cédula debe tener 10 dígitos.";
    }

    // Los dos primeros dígitos deben estar entre 01 y 24, que son las provincias de Ecuador
    $provincia = substr($cedula, 0, 2);
    if ($provincia < 1 || $provincia > 24) {
        return "La cédula no corresponde a una provincia válida.";
    }

    // El tercer dígito debe estar entre 0 y 6 para cédulas de personas naturales
    $tercerDigito = substr($cedula, 2, 1);
    if ($tercerDigito > 6) {
        return "El tercer dígito es inválido.";
    }

    // Aplicar el algoritmo de verificación de cédula
    $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2]; // Coeficientes para multiplicar los primeros 9 dígitos
    $suma = 0;

    // Calcular la suma del algoritmo de verificación
    for ($i = 0; $i < 9; $i++) {
        $valor = (int)$cedula[$i] * $coeficientes[$i];
        if ($valor >= 10) {
            $valor -= 9;
        }
        $suma += $valor;
    }

    // Obtener el dígito verificador
    $digitoVerificador = (10 - ($suma % 10)) % 10;

    // Comparar el dígito verificador con el último dígito de la cédula
    if ($digitoVerificador != (int)$cedula[9]) {
        return "La cédula es inválida.";
    }

    return true; // La cédula es válida
}


$database = new Conexion();
$db = $database->obtenerConexion();

$cliente = new Cliente($db);

if($_POST){
    // Validar cédula antes de asignar valores
    $validacion = validarCedula($_POST['NUMERO_CEDULA']);

    if($validacion !== true) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <i class='bi bi-exclamation-triangle-fill'></i> $validacion
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                </div>";
    } 
    else 
    {
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
        } 
    else{
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <i class='bi bi-exclamation-triangle-fill'></i> No se pudo registrar el cliente.
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
        }
    }
}


include '../includes/head.php'; // Include header file for Bootstrap and other styles
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h3 class="mb-0 color-primario"><i class="bi bi-person-plus"></i> Registrar Nuevo Cliente</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="row g-3">

                            <div class="col-md-6 form-floating">
                                
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" required placeholder="numero">
                                <label for="NOMBRE" class="form-label">Nombre</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <input type="text" class="form-control" id="APELLIDO" name="APELLIDO" required placeholder="numero">
                                <label for="APELLIDO" class="form-label">Apellido</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <input type="text" class="form-control" id="NUMERO_CEDULA" name="NUMERO_CEDULA" required
                                       pattern="[0-9]{10}" title="Ingrese 10 dígitos numéricos" placeholder="numero">
                                <label for="NUMERO_CEDULA" class="form-label">Número de Cédula</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <input type="tel" class="form-control" id="TELEFONO" name="TELEFONO" 
                                       pattern="[0-9]{10}" title="Ingrese 10 dígitos numéricos" placeholder="numero">
                                       <label for="TELEFONO" class="form-label">Teléfono</label>
                            </div>
                            <div class="col-md-6 form-floating">
                               
                                <input type="email" class="form-control" id="CORREO" name="CORREO" placeholder="numero">
                                <label for="CORREO" class="form-label">Correo Electrónico</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <input type="text" class="form-control" id="DIRECCION" name="DIRECCION" placeholder="numero">
                                <label for="DIRECCION" class="form-label">Dirección</label>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primario me-md-2">
                                        <i class="bi bi-save"></i> Guardar Cliente
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