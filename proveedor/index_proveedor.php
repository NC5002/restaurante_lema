<?php
include '../includes/conexion.php'; 
include '../clases/Proveedor.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$proveedor = new Proveedor($db);

// Manejar el filtro de búsqueda
$filtro_ruc = isset($_GET['ruc']) ? $_GET['ruc'] : null;

if($filtro_ruc) {
    $stmt = $proveedor->buscarPorRuc($filtro_ruc);
} else {
    $stmt = $proveedor->leer();
}

include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 color-primario"><i class="bi bi-truck"></i> Listado de Proveedores</h3>
                    <a href="crear_proveedor.php" class="btn btn-primario">
                        <i class="bi bi-plus-circle"></i> Nuevo Proveedor
                    </a>
                </div>
                <div class="card-body">
                    <!-- Formulario de búsqueda -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="GET" action="">
                                <div class="row g-3 align-items-end">
 
                                    <div class="col-md-8">
                                        <input type="text" 
                                                class="form-control" 
                                                name="ruc" 
                                                placeholder="Buscar por RUC/Cédula..."
                                                value="<?= htmlspecialchars($filtro_ruc ?? '') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <?php if($filtro_ruc): ?>
                                            <a href="index_proveedor.php" class="btn btn-secondary w-100">
                                                <i class="bi bi-x-circle"></i> Limpiar
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-primario w-100" type="submit">
                                                <i class="bi bi-search"></i> Buscar
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-light">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>RUC/Cédula</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($stmt->rowCount() > 0): ?>
                                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['ID_PROVEEDOR']) ?></td>
                                            <td><?= htmlspecialchars($row['RUC_CEDULA']) ?></td>
                                            <td><?= htmlspecialchars($row['NOMBRE']) ?></td>
                                            <td><?= htmlspecialchars($row['TELEFONO']) ?></td>
                                            <td><?= date('d/m/Y', strtotime($row['FECHA_REGISTRO'])) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="ver_proveedor.php?ID_PROVEEDOR=<?= $row['ID_PROVEEDOR'] ?>" 
                                                       class="btn btn-sm btn-secundario" title="Ver detalles">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="editar_proveedor.php?ID_PROVEEDOR=<?= $row['ID_PROVEEDOR'] ?>" 
                                                       class="btn btn-sm btn-primario" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="eliminar_proveedor.php?ID_PROVEEDOR=<?= $row['ID_PROVEEDOR'] ?>" 
                                                       class="btn btn-sm btn-terciario" 
                                                       onclick="return confirm('¿Está seguro de eliminar este proveedor?')" title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No se encontraron proveedores</td>
                                    </tr>
                                <?php endif; ?>
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