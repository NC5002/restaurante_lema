<?php
include '../includes/conexion.php'; 
include '../clases/Proveedor.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$proveedor = new Proveedor($db);

if ($_POST) {
    // Verificar si es RUC y añadir 001 si es necesario
    $numeroDocumento = $_POST['RUC_CEDULA'];
    if (isset($_POST['es_ruc']) && $_POST['es_ruc'] == "1") {
        // Verificamos si ya tiene el sufijo 001 para no duplicarlo
        if (substr($numeroDocumento, -3) !== "001") {
            $numeroDocumento .= "001";
        }
    }
    
    $proveedor->RUC_CEDULA = $numeroDocumento;
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
                    <h3 class="mb-0 color-primario"><i class="bi bi-truck"></i> Nuevo Proveedor</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="RUC_CEDULA" name="RUC_CEDULA" 
                                    pattern="[0-9]{10}" title="Ingrese 10 dígitos numéricos" required placeholder="cedula">
                                    <label for="RUC_CEDULA" class="form-label">RUC/Cédula</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="es_ruc" name="es_ruc">
                                    <label class="form-check-label" for="es_ruc">
                                        Seleccione si es un RUC
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 form-floating">
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" required placeholder="nombre">
                                <label for="NOMBRE" class="form-label">Nombre/Empresa</label>
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

<script>

// Agrega este código JavaScript en tu archivo js o antes de </body>
document.addEventListener('DOMContentLoaded', function() {
    const rucCedulaInput = document.getElementById('RUC_CEDULA');
    const esRucCheckbox = document.getElementById('es_ruc');
    
    // Función para validar el número según sea RUC o cédula
    function validarDocumento() {
        const valor = rucCedulaInput.value.trim();
        const esRuc = esRucCheckbox.checked;
        
        if (esRuc) {
            // Para RUC se espera 10 o 13 dígitos (o 10 si luego se añadirá 001)
            if (valor.length !== 10 && valor.length !== 13) {
                rucCedulaInput.setCustomValidity('El RUC debe tener 10 dígitos (persona natural) o 13 dígitos (incluyendo 001)');
            } else {
                rucCedulaInput.setCustomValidity('');
            }
        } else {
            // Para cédula se espera exactamente 10 dígitos
            if (valor.length !== 10) {
                rucCedulaInput.setCustomValidity('La cédula debe tener exactamente 10 dígitos');
            } else {
                rucCedulaInput.setCustomValidity('');
            }
        }
    }
    
    // Validar cuando cambie el input o el checkbox
    rucCedulaInput.addEventListener('input', validarDocumento);
    esRucCheckbox.addEventListener('change', validarDocumento);
    
    // Opcionalmente, puedes añadir ayuda visual cuando se seleccione "Es RUC"
    esRucCheckbox.addEventListener('change', function() {
        if (this.checked) {
            // Si el valor actual tiene exactamente 10 dígitos, muestra cómo quedaría con el sufijo
            if (rucCedulaInput.value.length === 10) {
                // Aquí solo mostramos un mensaje de ayuda, no modificamos el valor real
                rucCedulaInput.title = `Al guardar se añadirá "001" (quedará como: ${rucCedulaInput.value}001)`;
            }
        } else {
            rucCedulaInput.title = '';
        }
    });
});

</script>

<script>

document.addEventListener('DOMContentLoaded', function() {
    // Obtener el campo de cédula
    const cedulaInput = document.getElementById('RUC_CEDULA');
    
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