<?php
include '../includes/conexion.php'; 
include '../clases/FacturaCabecera.php';
include '../clases/FacturaDetalle.php';
include '../clases/Cliente.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$factura = new FacturaCabecera($db);
$detalleFactura = new FacturaDetalle($db);
$cliente = new Cliente($db);

$factura->ID_FACTURA_CABECERA = isset($_GET['ID_FACTURA_CABECERA']) ? $_GET['ID_FACTURA_CABECERA'] : die('ERROR: ID de factura no encontrado.');
$factura->leerUno();

// Obtener datos del cliente
$cliente->ID_CLIENTE = $factura->ID_CLIENTE;
$cliente->leerUno();

// Obtener detalles de la factura
$detalles = $detalleFactura->leerPorFactura($factura->NUMERO_FACTURA);

include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 color-primario"><i class="bi bi-receipt"></i> Detalles de la Factura</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="bg-light" style="width: 30%"><i class="bi bi-file-earmark-text"></i> Número de Factura:</th>
                                            <td><?= htmlspecialchars($factura->NUMERO_FACTURA) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-person"></i> Cliente:</th>
                                            <td><?= htmlspecialchars($cliente->NOMBRE.' '.$cliente->APELLIDO) ?> (<?= htmlspecialchars($cliente->NUMERO_CEDULA) ?>)</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-calendar"></i> Fecha de Emisión:</th>
                                            <td><?= date('d/m/Y H:i', strtotime($factura->FECHA_EMISION)) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-percent"></i> Subtotal:</th>
                                            <td>$<?= number_format($factura->SUBTOTAL, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-percent"></i> IVA:</th>
                                            <td>$<?= number_format($factura->IVA, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-credit-card"></i> Método de Pago:</th>
                                            <td><?= htmlspecialchars($factura->METODO_PAGO) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-cash-stack"></i> Total:</th>
                                            <td>$<?= number_format($factura->TOTAL, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-person"></i> Registrado por:</th>
                                            <td>Usuario ID: <?= htmlspecialchars($factura->ID_USUARIO) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <h5 class="mt-4 color-primario"><i class="bi bi-list-ul"></i> Detalles de Productos/Servicios</h5>
                            <div class="table-responsive mt-3">
                                <table class="table table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($detalle = $detalles->fetch(PDO::FETCH_ASSOC)): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($detalle['NOMBRE_PRODUCTO'] ?? 'Producto no especificado') ?></td>
                                                <td><?= htmlspecialchars($detalle['CANTIDAD']) ?></td>
                                                <td>$<?= number_format($detalle['PRECIO'], 2) ?></td>
                                                <td>$<?= number_format($detalle['CANTIDAD'] * $detalle['PRECIO'], 2) ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-active">
                                            <th colspan="3" class="text-end">Subtotal:</th>
                                            <th>$<?= number_format($factura->SUBTOTAL, 2) ?></th>
                                        </tr>
                                        <tr class="table-active">
                                            <th colspan="3" class="text-end">IVA (15%):</th>
                                            <th>$<?= number_format($factura->IVA, 2) ?></th>
                                        </tr>
                                        <tr class="table-primary">
                                            <th colspan="3" class="text-end">Total:</th>
                                            <th>$<?= number_format($factura->TOTAL, 2) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">ID Factura: <?= $factura->ID_FACTURA_CABECERA ?></small>
                        <div>
                            <a href="javascript:window.print()" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-printer"></i> Imprimir
                            </a>
                            <a href="./index_factura.php" class="btn btn-primario">
                                <i class="bi bi-arrow-left"></i> Volver al Listado
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include '../includes/footer.php';
?>