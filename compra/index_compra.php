<?php
include '../includes/conexion.php'; 
include '../clases/Compra.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$compras = new Compras($db);
$stmt = $compras->leer();
include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 color-primario"><i class="bi bi-cart4"></i> Listado de Compras</h3>
                    <a href="create_compra.php" class="btn btn-primario">
                        <i class="bi bi-plus-circle"></i> Nueva Compra
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-light">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Factura</th>
                                    <th>Proveedor</th>
                                    <th>Fecha</th>
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
                                        <td><?= htmlspecialchars($row['ID_COMPRA']) ?></td>
                                        <td><?= htmlspecialchars($row['NUMERO_FACTURA_COMPRA']) ?></td>
                                        <td><?= htmlspecialchars($row['NOMBRE_PROVEEDOR'] ?? 'No especificado') ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($row['FECHA_REGISTRO'])) ?></td>
                                        <td>$<?= number_format($row['IVA'], 2) ?></td>
                                        <td>$<?= number_format($row['TOTAL_VALOR'], 2) ?></td>
                                        <td><?= htmlspecialchars($row['METODO_PAGO']) ?></td>
                                        <td><?= htmlspecialchars($row['ID_USUARIO']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $row['ESTADO'] ? 'success' : 'danger' ?>">
                                                <?= $row['ESTADO'] ? 'Activo' : 'Inactivo' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="view_compra.php?ID_COMPRA=<?= $row['ID_COMPRA'] ?>" 
                                                   class="btn btn-sm btn-secundario" title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <!--<a href="editar_compra.php?ID_COMPRA=<?= $row['ID_COMPRA'] ?>" 
                                                   class="btn btn-sm btn-primario" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>-->
                                                <!--<a href="eliminar_compra.php?ID_COMPRA=<?= $row['ID_COMPRA'] ?>" 
                                                   class="btn btn-sm btn-terciario" 
                                                   onclick="return confirm('¿Está seguro de eliminar esta compra?')" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </a>-->
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