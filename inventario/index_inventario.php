<?php
include '../includes/conexion.php'; 
include '../clases/Inventario.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$inventario = new Inventario($db);
$stmt = $inventario->leer();
include '../includes/head.php'; // Include header file for Bootstrap and other styles
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 color-primario"><i class="bi bi-box-seam"></i> Listado de Inventario</h3>
                    <a href="crear_inventario.php" class="btn btn-primario">
                        <i class="bi bi-plus-circle"></i> Nuevo Registro
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-light">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Código Menú</th>
                                    <th>Ingrediente</th>
                                    <th>Cantidad</th>
                                    <th>Usuario</th>
                                    <th>Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['ID_INVENTARIO']) ?></td>
                                        <td><?= htmlspecialchars($row['CODIGO_MENU']) ?></td>
                                        <td><?= htmlspecialchars($row['NOMBRE_INGREDIENTE']) ?></td>
                                        <td><?= htmlspecialchars($row['CANTIDAD']) ?></td>
                                        <td><?= htmlspecialchars($row['ID_USUARIO']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($row['FECHA_REGISTRO'])) ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                            <a href="ver_inventario.php?ID_INVENTARIO=<?= $row['ID_INVENTARIO'] ?>" 
                                                   class="btn btn-sm btn-secundario" title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="editar_inventario.php?ID_INVENTARIO=<?= $row['ID_INVENTARIO'] ?>" 
                                                   class="btn btn-sm btn-primario" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="eliminar_inventario.php?ID_INVENTARIO=<?= $row['ID_INVENTARIO'] ?>" 
                                                   class="btn btn-sm btn-terciario" 
                                                   onclick="return confirm('¿Está seguro de eliminar este registro?')" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </a>

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
include '../includes/footer.php'; // Include footer file for Bootstrap and other scripts
?>