<?php
// Rutas absolutas para includes
require_once __DIR__ . '/../includes/conexion.php';
require_once __DIR__ . '/../clases/Compra.php';
require_once __DIR__ . '/../clases/DetalleCompras.php';
require_once __DIR__ . '/../clases/Proveedor.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$compras = new Compras($db);
$detalleCompra = new DetalleCompras($db);
$proveedor = new Proveedor($db);

// Obtener lista de proveedores
$proveedores = $proveedor->leer();

// Procesar formulario
// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['guardar_compra'])) {
        // Procesar compra principal
        $compras->NUMERO_FACTURA_COMPRA = $_POST['numero_factura'];
        $compras->NUMERO_PROVEEDOR = $_POST['id_proveedor'];
        $compras->IVA = $_POST['iva'];
        $compras->TOTAL_VALOR = $_POST['total'];
        $compras->METODO_PAGO = $_POST['metodo_pago'];
        $compras->ID_USUARIO = $_POST['id_usuario'];
        
        if ($compras->crear()) {
            $numero_factura = $compras->NUMERO_FACTURA_COMPRA;
            
            // Procesar detalles
            if (!empty($_POST['descripcion'])) {
                foreach ($_POST['descripcion'] as $key => $descripcion) {
                    $detalleCompra->NUMERO_FACTURA_COMPRA = $numero_factura;
                    $detalleCompra->DESCRIPCION = $descripcion;
                    $detalleCompra->CANTIDAD = $_POST['cantidad'][$key];
                    $detalleCompra->PRECIO_UNITARIO = $_POST['precio'][$key];
                    $detalleCompra->crear();
                }
            }
            
            header("Location: index_compra.php?success=Compra registrada correctamente");
            exit();
        }
    } elseif (isset($_POST['agregar_detalle'])) {
        // Solo agregar detalle temporal (manejado con JavaScript)
    }
}

include __DIR__ . '/../includes/head.php';
include __DIR__ . '/../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark">
                    <h3 class="mb-0 color-primario"><i class="bi bi-cart-plus"></i> Registrar Nueva Compra</h3>
                </div>
                <div class="card-body">
                    <form id="formCompra" method="POST" action="create_compra.php">
                        <div class="row mb-3">
                            <div class="col-md-4 form-floating">
                               
                                <input type="text" class="form-control" id="numero_factura" name="numero_factura" required>
                                <label for="numero_factura" class="form-label">Número de Factura</label>
                            </div>
                            <div class="col-md-4 form-floating">
                                
                                <input type="text" class="form-control" id="fecha" value="<?= date('Y/m/d H:i') ?>" readonly>
                                <label for="fecha" class="form-label">Fecha de ingreso</label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <select class="form-select" id="id_proveedor" name="id_proveedor" required>
                                        <option value="">Seleccione un proveedor</option>
                                        <?php while ($prov = $proveedores->fetch(PDO::FETCH_ASSOC)): ?>
                                            <option value="<?= $prov['ID_PROVEEDOR'] ?>">
                                                <?= htmlspecialchars($prov['NOMBRE']) ?> - <?= htmlspecialchars($prov['RUC_CEDULA']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                    <a href="../proveedor/crear_proveedor.php" class="btn btn-primario" type="button">
                                        <i class="bi bi-plus-circle"></i> Nuevo
                                    </a>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-3">

                            <div class="col-md-6" hidden>
                                <label class="form-label">Usuario</label>
                                <input type="text" name="id_usuario" value="<?= $_SESSION['user_id'] ?>">
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 color-primario"><i class="bi bi-list-ul"></i> Detalles de la Compra</h5>
                                <button type="button" id="agregar-detalle" class="btn btn-sm btn-primario mt-2">
                                    <i class="bi bi-plus-circle"></i> Añadir Detalle
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="detalles-container">
                                    <!-- Detalles se agregarán aquí dinámicamente -->
                                </div>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="iva" class="form-label"><strong>IVA (15%)</strong></label>
                                <input type="number" class="form-control" id="iva" name="iva" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="metodo_pago" class="form-label"><strong>Método de Pago</strong></label>
                                <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Tarjeta de débito">Tarjeta de débito</option>
                                    <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                                    <option value="Paypal">Paypal</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="total" class="form-label"><strong>Total</strong></label>
                                <input type="number" step="0.01" class="form-control" id="total" name="total" readonly>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index_compra.php" class="btn btn-secondary me-md-2">
                                <i class="bi bi-arrow-left"></i> Volver
                            </a>
                            <button type="submit" name="guardar_compra" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Compra
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template para nuevos detalles (oculto) -->
<template id="detalle-template">
    <div class="detalle-item">
        <div class="row">
            <div class=" col-md-5" >
                <input type="text" class="form-control descripcion" name="descripcion[]" required placeholder="Descripción">
                      
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control cantidad" name="cantidad[]" min="1" required placeholder="Cantidad">
                          
            </div>
            <div class=" col-md-2">
                
                <input type="number" step="0.01" class="form-control precio" name="precio[]" min="0.01" required placeholder="Precio Unitario">
 
            </div>
            <div class=" col-md-2">
                <input type="number" step="0.01" class="form-control subtotal" readonly placeholder="Subtotal">

            </div>
            <div class="col-md-1 d-flex align-items-end justify-content-between align-items-center">
                <button type="button" class="btn btn-terciario btn-sm eliminar-detalle">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const detallesContainer = document.getElementById('detalles-container');
    const agregarBtn = document.getElementById('agregar-detalle');
    const template = document.getElementById('detalle-template');
    const form = document.getElementById('formCompra');
    
    // Validar campos numéricos en tiempo real
    function validarCampoNumerico(input, permitirDecimales = true, min = 0) {
        let valor = input.value;
        
        // Eliminar caracteres no numéricos excepto punto decimal si se permiten decimales
        if (permitirDecimales) {
            valor = valor.replace(/[^0-9.]/g, '');
            
            // Asegurar que solo haya un punto decimal
            const puntos = valor.match(/\./g);
            if (puntos && puntos.length > 1) {
                valor = valor.substring(0, valor.lastIndexOf('.'));
            }
            
            // Permitir solo 2 decimales
            if (valor.includes('.')) {
                const partes = valor.split('.');
                if (partes[1].length > 2) {
                    partes[1] = partes[1].substring(0, 2);
                    valor = partes.join('.');
                }
            }
        } else {
            valor = valor.replace(/[^0-9]/g, '');
        }
        
        // Verificar valor mínimo
        const numValor = parseFloat(valor) || 0;
        if (numValor < min && valor !== '') {
            valor = min.toString();
        }
        
        // Actualizar valor en el input solo si ha cambiado
        if (input.value !== valor) {
            input.value = valor;
        }
        
        return numValor;
    }
    
    // Agregar nuevo detalle
    agregarBtn.addEventListener('click', function() {
        const clone = template.content.cloneNode(true);
        detallesContainer.appendChild(clone);
        
        // Configurar validación para el nuevo detalle
        const nuevoDetalle = detallesContainer.lastElementChild;
        configurarValidacionDetalle(nuevoDetalle);
        
        actualizarCalculos();
    });
    
    // Configurar validación para un elemento detalle
    function configurarValidacionDetalle(detalleItem) {
        const cantidadInput = detalleItem.querySelector('.cantidad');
        const precioInput = detalleItem.querySelector('.precio');
        
        // Validar cantidad (solo números enteros, mínimo 1)
        cantidadInput.addEventListener('input', function() {
            validarCampoNumerico(this, false, 1);
            actualizarSubtotal(detalleItem);
        });
        
        // Validar precio (números con decimales, mínimo 0.01)
        precioInput.addEventListener('input', function() {
            validarCampoNumerico(this, true, 0.01);
            actualizarSubtotal(detalleItem);
        });
    }
    
    // Calcular subtotal para un detalle específico
    function actualizarSubtotal(detalleItem) {
        const cantidad = parseFloat(detalleItem.querySelector('.cantidad').value) || 0;
        const precio = parseFloat(detalleItem.querySelector('.precio').value) || 0;
        const subtotal = cantidad * precio;
        detalleItem.querySelector('.subtotal').value = subtotal.toFixed(2);
        
        actualizarCalculos();
    }
    
    // Eliminar detalle
    detallesContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('eliminar-detalle') || 
            e.target.closest('.eliminar-detalle')) {
            e.target.closest('.detalle-item').remove();
            actualizarCalculos();
        }
    });
    
    // Función para actualizar totales
    function actualizarCalculos() {
        let subtotalTotal = 0;
        document.querySelectorAll('.subtotal').forEach(input => {
            subtotalTotal += parseFloat(input.value) || 0;
        });
        
        const iva = subtotalTotal * 0.15;
        const total = subtotalTotal + iva;
        
        document.getElementById('iva').value = iva.toFixed(2);
        document.getElementById('total').value = total.toFixed(2);
    }
    
    // Validar formulario antes de enviar
    form.addEventListener('submit', function(e) {
        const detalles = document.querySelectorAll('.detalle-item');
        if (detalles.length === 0) {
            e.preventDefault();
            alert('Debe agregar al menos un detalle a la compra');
            return false;
        }
        
        let formValido = true;
        
        // Validar que todos los detalles tengan información válida
        detalles.forEach(detalle => {
            const descripcion = detalle.querySelector('.descripcion').value.trim();
            const cantidad = parseFloat(detalle.querySelector('.cantidad').value) || 0;
            const precio = parseFloat(detalle.querySelector('.precio').value) || 0;
            
            if (descripcion === '' || cantidad < 1 || precio < 0.01) {
                formValido = false;
            }
        });
        
        if (!formValido) {
            e.preventDefault();
            alert('Por favor, complete correctamente todos los campos de los detalles');
            return false;
        }
    });
    
    // Agregar un detalle por defecto al cargar
    agregarBtn.click();
});
</script>

<?php 
include __DIR__ . '/../includes/footer.php';
?>