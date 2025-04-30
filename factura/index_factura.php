<?php
include '../includes/conexion.php'; 
include '../clases/FacturaCabecera.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$facturas = new FacturaCabecera($db);
$stmt = $facturas->leer();
include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 color-primario"><i class="bi bi-receipt"></i> Listado de Facturas</h3>
                    <a href="create_factura.php" class="btn btn-primario">
                        <i class="bi bi-plus-circle"></i> Nueva Factura
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-light">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>N° Factura</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Subtotal</th>
                                    <th>IVA</th>
                                    <th>Total</th>
                                    <th>Método Pago</th>
                                    <th>Usuario</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['ID_FACTURA_CABECERA']) ?></td>
                                        <td><?= htmlspecialchars($row['NUMERO_FACTURA']) ?></td>
                                        <td>
                                            <?= htmlspecialchars($row['NOMBRE_CLIENTE'] ?? 'Cliente no especificado') ?>
                                            <?php if(isset($row['CEDULA_CLIENTE'])): ?>
                                                <br><small class="text-muted"><?= htmlspecialchars($row['CEDULA_CLIENTE']) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($row['FECHA_EMISION'])) ?></td>
                                        <td>$<?= number_format($row['SUBTOTAL'], 2) ?></td>
                                        <td>$<?= number_format($row['IVA'], 2) ?></td>
                                        <td>$<?= number_format($row['TOTAL'], 2) ?></td>
                                        <td><?= htmlspecialchars($row['METODO_PAGO']) ?></td>
                                        <td><?= htmlspecialchars($row['ID_USUARIO']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $row['ESTADO'] ? 'success' : 'danger' ?>">
                                                <?= $row['ESTADO'] ? 'Activa' : 'Anulada' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="view_factura.php?ID_FACTURA_CABECERA=<?= $row['ID_FACTURA_CABECERA'] ?>" 
                                                   class="btn btn-sm btn-secundario" title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="view_factura.php?ID_FACTURA_CABECERA=<?= $row['ID_FACTURA_CABECERA'] ?>" 
                                                   class="btn btn-sm btn-info" title="Imprimir" target="_blank">
                                                    <i class="bi bi-printer"></i>
                                                </a>
                                                <!--
                                                <a href="editar_factura.php?ID_FACTURA_CABECERA=<?= $row['ID_FACTURA_CABECERA'] ?>" 
                                                   class="btn btn-sm btn-primario" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="anular_factura.php?ID_FACTURA_CABECERA=<?= $row['ID_FACTURA_CABECERA'] ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('¿Está seguro de anular esta factura?')" title="Anular">
                                                    <i class="bi bi-x-circle"></i>
                                                </a>
                                                -->
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include '../includes/footer.php';
?>