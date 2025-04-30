<?php
include '../includes/conexion.php'; 
include '../clases/Compra.php';
include '../clases/DetalleCompras.php';
include '../clases/Proveedor.php';

$database = new Conexion();
$db = $database->obtenerConexion();

// Cambiar $compra por $compras para ser consistente con tu instancia
$compras = new Compras($db);
$detalleCompra = new DetalleCompras($db);
$proveedor = new Proveedor($db);

// Usar $compras en lugar de $compra
$compras->ID_COMPRA = isset($_GET['ID_COMPRA']) ? $_GET['ID_COMPRA'] : die('ERROR: ID de compra no encontrado.');
$compras->leerUno();

// Obtener nombre del proveedor
$proveedor->ID_PROVEEDOR = $compras->NUMERO_PROVEEDOR;
$proveedor->leerUno();

// Obtener detalles de la compra
$detalles = $detalleCompra->leerPorFactura($compras->NUMERO_FACTURA_COMPRA);

include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 color-primario"><i class="bi bi-cart-check"></i> Detalles de la Compra</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="bg-light" style="width: 30%"><i class="bi bi-file-earmark-text"></i> Número de Factura:</th>
                                            <td><?= htmlspecialchars($compras->NUMERO_FACTURA_COMPRA) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-truck"></i> Proveedor:</th>
                                            <td><?= htmlspecialchars($proveedor->NOMBRE) ?> (<?= htmlspecialchars($proveedor->RUC_CEDULA) ?>)</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-calendar"></i> Fecha de Registro:</th>
                                            <td><?= date('d/m/Y H:i', strtotime($compras->FECHA_REGISTRO)) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-percent"></i> IVA:</th>
                                            <td>$<?= number_format($compras->IVA, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-credit-card"></i> Método de Pago:</th>
                                            <td><?= htmlspecialchars($compras->METODO_PAGO) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-cash-stack"></i> Total:</th>
                                            <td>$<?= number_format($compras->TOTAL_VALOR, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-person"></i> Registrado por:</th>
                                            <td>Usuario ID: <?= htmlspecialchars($compras->ID_USUARIO) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <h5 class="mt-4 color-primario"><i class="bi bi-list-ul"></i> Detalles de Productos</h5>
                            <div class="table-responsive mt-3">
                                <table class="table table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($detalle = $detalles->fetch(PDO::FETCH_ASSOC)): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($detalle['DESCRIPCION']) ?></td>
                                                <td><?= htmlspecialchars($detalle['CANTIDAD']) ?></td>
                                                <td>$<?= number_format($detalle['PRECIO_UNITARIO'], 2) ?></td>
                                                <td>$<?= number_format($detalle['CANTIDAD'] * $detalle['PRECIO_UNITARIO'], 2) ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-active">
                                            <th colspan="3" class="text-end">Subtotal:</th>
                                            <th>$<?= number_format($compras->TOTAL_VALOR - $compras->IVA, 2) ?></th>
                                        </tr>
                                        <tr class="table-active">
                                            <th colspan="3" class="text-end">IVA (15%):</th>
                                            <th>$<?= number_format($compras->IVA, 2) ?></th>
                                        </tr>
                                        <tr class="table-primary">
                                            <th colspan="3" class="text-end">Total:</th>
                                            <th>$<?= number_format($compras->TOTAL_VALOR, 2) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">ID Compra: <?= $compras->ID_COMPRA ?></small>
                        <a href="./index_compra.php" class="btn btn-primario">
                            <i class="bi bi-arrow-left"></i> Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include '../includes/footer.php';
?>