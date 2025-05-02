<?php
include '../includes/conexion.php'; 
include '../clases/Cliente.php';

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
                                <!-- Modificación del campo de cédula para incluir validación en tiempo real -->
                                <div class="col-md-6 form-floating">
                                    <input type="text" class="form-control" id="NUMERO_CEDULA" name="NUMERO_CEDULA" required
                                        pattern="[0-9]{10}" title="Ingrese 10 dígitos numéricos" placeholder="numero">
                                    <label for="NUMERO_CEDULA" class="form-label">Número de Cédula</label>
                                    <!-- Los mensajes de retroalimentación se agregarán dinámicamente con JavaScript -->
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

<script>

document.addEventListener('DOMContentLoaded', function() {
    // Obtener el campo de cédula
    const cedulaInput = document.getElementById('NUMERO_CEDULA');
    
    // Crear elementos para feedback
    const feedbackDiv = document.createElement('div');
    feedbackDiv.className = 'invalid-feedback';
    cedulaInput.parentNode.appendChild(feedbackDiv);
    
    // Crear un indicador de validación
    const validIndicator = document.createElement('div');
    validIndicator.className = 'valid-feedback';
    validIndicator.textContent = 'Cédula válida';
    cedulaInput.parentNode.appendChild(validIndicator);
    
    // Agregar evento para validar la cédula cuando cambie el valor
    cedulaInput.addEventListener('blur', function() {
        // Solo validar si hay 10 dígitos
        if(this.value.length === 10) {
            validarCedulaAjax(this.value);
        } else {
            // Limpiar feedback si no tiene 10 dígitos
            feedbackDiv.textContent = '';
            cedulaInput.classList.remove('is-valid', 'is-invalid');
        }
    });
    
    // Función para validar cédula mediante AJAX
    function validarCedulaAjax(cedula) {
        // Crear objeto FormData
        const formData = new FormData();
        formData.append('action', 'validar_cedula');
        formData.append('cedula', cedula);
        
        // Configurar y enviar la solicitud AJAX
        fetch('../ajax/validar_cedula.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.valido) {
                // Cédula válida
                cedulaInput.classList.remove('is-invalid');
                cedulaInput.classList.add('is-valid');
                feedbackDiv.textContent = '';
            } else {
                // Cédula inválida
                cedulaInput.classList.remove('is-valid');
                cedulaInput.classList.add('is-invalid');
                feedbackDiv.textContent = data.mensaje;
            }
        })
        .catch(error => {
            console.error('Error al validar cédula:', error);
        });
    }
});

</script>

<?php 
include '../includes/footer.php'; // Include footer file for Bootstrap and other scripts
?>