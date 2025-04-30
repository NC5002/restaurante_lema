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
                <div class="card-header bg-dark text-white">
                    <h3 class="mb-0 color-primario"><i class="bi bi-cart-plus"></i> Registrar Nueva Compra</h3>
                </div>
                <div class="card-body">
                    <form id="formCompra" method="POST" action="create_compra.php">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="numero_factura" class="form-label">Número de Factura</label>
                                <input type="text" class="form-control" id="numero_factura" name="numero_factura" required>
                            </div>
                            <div class="col-md-6">
                                <label for="id_proveedor" class="form-label">Proveedor</label>
                                <div class="input-group">
                                    <select class="form-select" id="id_proveedor" name="id_proveedor" required>
                                        <option value="">Seleccione un proveedor</option>
                                        <?php while ($prov = $proveedores->fetch(PDO::FETCH_ASSOC)): ?>
                                            <option value="<?= $prov['ID_PROVEEDOR'] ?>">
                                                <?= htmlspecialchars($prov['NOMBRE']) ?> - <?= htmlspecialchars($prov['RUC_CEDULA']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                    <a href="../proveedor/crear_proveedor.php" class="btn btn-outline-secondary" type="button">
                                        <i class="bi bi-plus-circle"></i> Nuevo
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="text" class="form-control" id="fecha" value="<?= date('Y/m/d H:i') ?>" readonly>
                            </div>
                            <div class="col-md-6" hidden>
                                <label class="form-label">Usuario</label>
                                <input type="text" name="id_usuario" value="<?= $_SESSION['user_id'] ?>">
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="bi bi-list-ul"></i> Detalles de la Compra</h5>
                            </div>
                            <div class="card-body">
                                <div id="detalles-container">
                                    <!-- Detalles se agregarán aquí dinámicamente -->
                                </div>
                                <button type="button" id="agregar-detalle" class="btn btn-sm btn-primary mt-2">
                                    <i class="bi bi-plus-circle"></i> Añadir Detalle
                                </button>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="iva" class="form-label">IVA (15%)</label>
                                <input type="number" class="form-control" id="iva" name="iva" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="metodo_pago" class="form-label">Método de Pago</label>
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
                                <label for="total" class="form-label">Total</label>
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
            <div class="form-floating col-md-5" >
                <input type="text" class="form-control descripcion" name="descripcion[]" required placeholder="Descripción">
                <label class="form-label">Descripción</label>                           
            </div>
            <div class="form-floating col-md-2">
                <input type="number" class="form-control cantidad" name="cantidad[]" min="1" required placeholder="Cantidad">
                <label class="form-label">Cantidad</label>                           
            </div>
            <div class="form-floating col-md-2">
                
                <input type="number" step="0.01" class="form-control precio" name="precio[]" min="0.01" required placeholder="Precio Unitario">
                <label class="form-label">Precio Unitario</label> 
            </div>
            <div class="form-floating col-md-2">
                <input type="number" step="0.01" class="form-control subtotal" readonly placeholder="Subtotal">
                <label class="form-label">Subtotal</label>
            </div>
            <div class="col-md-1 d-flex align-items-end">
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
    
    // Agregar nuevo detalle
    agregarBtn.addEventListener('click', function() {
        const clone = template.content.cloneNode(true);
        detallesContainer.appendChild(clone);
        actualizarCalculos();
    });
    
    // Eliminar detalle
    detallesContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('eliminar-detalle')) {
            e.target.closest('.detalle-item').remove();
            actualizarCalculos();
        }
    });
    
    // Calcular subtotal y total cuando cambian cantidades o precios
    detallesContainer.addEventListener('input', function(e) {
        if (e.target.classList.contains('cantidad') || e.target.classList.contains('precio')) {
            const item = e.target.closest('.detalle-item');
            const cantidad = parseFloat(item.querySelector('.cantidad').value) || 0;
            const precio = parseFloat(item.querySelector('.precio').value) || 0;
            const subtotal = cantidad * precio;
            item.querySelector('.subtotal').value = subtotal.toFixed(2);
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
    
    // Agregar un detalle por defecto al cargar
    agregarBtn.click();
});
</script>

<?php 
include __DIR__ . '/../includes/footer.php';
?>