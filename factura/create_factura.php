<?php
require_once __DIR__ . '/../includes/conexion.php';
require_once __DIR__ . '/../clases/FacturaCabecera.php';
require_once __DIR__ . '/../clases/FacturaDetalle.php';
require_once __DIR__ . '/../clases/Cliente.php';
require_once __DIR__ . '/../clases/Menu.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$factura = new FacturaCabecera($db);
$detalleFactura = new FacturaDetalle($db);
$cliente = new Cliente($db);
$menu = new Menu($db);

// Obtener lista de clientes y productos del menú
$clientes = $cliente->leer();
$productos = $menu->leerFactura();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['guardar_factura'])) {
        // Procesar factura principal
        $factura->NUMERO_FACTURA = $_POST['numero_factura'];
        $factura->ID_CLIENTE = $_POST['id_cliente'];
        $factura->SUBTOTAL = $_POST['subtotal'];
        $factura->IVA = $_POST['iva'];
        $factura->TOTAL = $_POST['total'];
        $factura->METODO_PAGO = $_POST['metodo_pago'];
        $factura->ID_USUARIO = $_SESSION['user_id'];
        
        if ($factura->crear()) {
            $numero_factura = $factura->NUMERO_FACTURA;
            
            // Procesar detalles
            if (!empty($_POST['codigo_menu'])) {
                foreach ($_POST['codigo_menu'] as $key => $codigo) {
                    $detalleFactura->NUMERO_FACTURA = $numero_factura;
                    $detalleFactura->CODIGO_MENU = $codigo;
                    $detalleFactura->CANTIDAD = $_POST['cantidad'][$key];
                    $detalleFactura->PRECIO = $_POST['precio'][$key];
                    $detalleFactura->crear();
                }
            }
            
            header("Location: index_factura.php?success=Factura registrada correctamente");
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
                <div class="card-header bg-dark text-white">
                    <h3 class="mb-0 color-primario"><i class="bi bi-receipt"></i> Nueva Factura</h3>
                </div>
                <div class="card-body">
                    <form id="formFactura" method="POST" action="create_factura.php">
                        <div class="row mb-1">
                            <div class="col-md-6 form-floating">
                                <input type="text" class="form-control" id="numero_factura" name="numero_factura" required placeholder="Número de Factura">
                                <label for="numero_factura" class="form-label"> Número de Factura</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <div class="input-group">
                                    <select class="form-select" id="id_cliente" name="id_cliente" required>
                                        <option value="">Seleccione un cliente</option>
                                        <?php while ($cli = $clientes->fetch(PDO::FETCH_ASSOC)): ?>
                                            <option value="<?= $cli['ID_CLIENTE'] ?>">
                                                <?= htmlspecialchars($cli['NOMBRE']) ?> <?= htmlspecialchars($cli['APELLIDO']) ?> - <?= htmlspecialchars($cli['NUMERO_CEDULA']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>

                                    <a href="../cliente/crear_cliente.php" class="btn btn-primario" type="button">
                                        <i class="bi bi-plus-circle"></i> Nuevo
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 form-floating">
                                
                                <input type="text" class="form-control" id="fecha" value="<?= date('d/m/Y H:i') ?>" readonly>
                                <label for="fecha" class="form-label">Fecha</label>
                            </div>
                            <div class="col-md-6 form-floating">
                                
                                <input type="text" class="form-control" value="<?= htmlspecialchars($_SESSION['user_nombre']) ?>" readonly>
                                <input type="hidden" name="id_usuario" value="<?= $_SESSION['user_id'] ?>">
                                <label class="form-label">Usuario</label>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 color-primario"><i class="bi bi-list-ul"></i> Detalles de la Factura</h5>
                                <button type="button" id="agregar-detalle" class="btn btn-sm btn-primario mt-2">
                                    <i class="bi bi-plus-circle"></i> Añadir Producto
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="detalles-container">
                                    <!-- Detalles se agregarán aquí dinámicamente -->
                                </div>

                            </div>
                        </div>

                        <div class="row mb-3">
                        <div class="col-md-3">
                                <label for="metodo_pago" class="form-label"><strong>Método de Pago</strong></label>
                                <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Tarjeta de débito">Tarjeta de débito</option>
                                    <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="subtotal" class="form-label"><strong>Subtotal</strong></label>
                                <input type="number" step="0.01" class="form-control" id="subtotal" name="subtotal" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="iva" class="form-label"><strong>IVA (15%)</strong></label>
                                <input type="number" step="0.01" class="form-control" id="iva" name="iva" readonly>
                            </div>

                            <div class="col-md-3">
                                <label for="total" class="form-label"><strong>Total</strong></label>
                                <input type="number" step="0.01" class="form-control" id="total" name="total" readonly>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index_factura.php" class="btn btn-secundario me-md-2">
                                <i class="bi bi-arrow-left"></i> Volver
                            </a>
                            <button type="submit" name="guardar_factura" class="btn btn-primario">
                                <i class="bi bi-save"></i> Guardar Factura
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
    <div class="detalle-item mb-1">
        <div class="row">
            <div class="col-md-5 form-floating">
                
                <select class="form-select producto" name="codigo_menu[]" required>
                    <option value="">Seleccione un producto</option>
                    <?php while ($prod = $productos->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= $prod['CODIGO_MENU'] ?>" data-precio="<?= $prod['PRECIO'] ?>">
                            <?= htmlspecialchars($prod['NOMBRE']) ?> - $<?= number_format($prod['PRECIO'], 2) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <label class="form-label">Producto</label>
            </div>
            <div class="col-md-2 form-floating">
                
                <input type="number" class="form-control cantidad" name="cantidad[]" min="1" value="1" required>
                <label class="form-label">Cantidad</label>
            </div>
            <div class="col-md-2 form-floating">
                
                <input type="number" step="0.01" class="form-control precio" name="precio[]" min="0.01" required>
                <label class="form-label">Precio Unitario</label>
            </div>
            <div class="col-md-2 form-floating">
                
                <input type="number" step="0.01" class="form-control subtotal" readonly>
                <label class="form-label">Subtotal</label>
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
    
    // Función para inicializar eventos de un nuevo detalle
    function inicializarEventosDetalle(detalleItem) {
        const selectProducto = detalleItem.querySelector('.producto');
        const cantidadInput = detalleItem.querySelector('.cantidad');
        const precioInput = detalleItem.querySelector('.precio');
        
        // Cargar precio al seleccionar producto
        selectProducto.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                precioInput.value = selectedOption.getAttribute('data-precio');
                calcularSubtotal(detalleItem);
                actualizarTotales();
            }
        });
        
        // Actualizar al cambiar cantidad o precio
        cantidadInput.addEventListener('input', function() {
            calcularSubtotal(detalleItem);
            actualizarTotales();
        });
        
        precioInput.addEventListener('input', function() {
            calcularSubtotal(detalleItem);
            actualizarTotales();
        });
    }
    
    // Calcular subtotal para un ítem
    function calcularSubtotal(item) {
        const cantidad = parseFloat(item.querySelector('.cantidad').value) || 0;
        const precio = parseFloat(item.querySelector('.precio').value) || 0;
        const subtotal = cantidad * precio;
        item.querySelector('.subtotal').value = subtotal.toFixed(2);
    }
    
    // Actualizar totales generales
    function actualizarTotales() {
        let subtotalTotal = 0;
        
        document.querySelectorAll('.subtotal').forEach(input => {
            subtotalTotal += parseFloat(input.value) || 0;
        });
        
        const iva = subtotalTotal * 0.15;
        const total = subtotalTotal + iva;
        
        document.getElementById('subtotal').value = subtotalTotal.toFixed(2);
        document.getElementById('iva').value = iva.toFixed(2);
        document.getElementById('total').value = total.toFixed(2);
    }
    
    // Agregar nuevo detalle
    agregarBtn.addEventListener('click', function() {
        const clone = template.content.cloneNode(true);
        const detalleItem = clone.querySelector('.detalle-item');
        detallesContainer.appendChild(clone);
        inicializarEventosDetalle(detalleItem);
    });
    
    // Eliminar detalle
    detallesContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('eliminar-detalle')) {
            e.target.closest('.detalle-item').remove();
            actualizarTotales();
        }
    });
    
    // Agregar primer detalle al cargar la página
    agregarBtn.click();
});
</script>

<?php 
include __DIR__ . '/../includes/footer.php';
?>