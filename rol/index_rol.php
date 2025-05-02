<?php
include '../includes/conexion.php';
include '../clases/Rol.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$rol = new Rol($db);
$stmt = $rol->leer();

include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="bi bi-tags"></i> Gestión de Roles</h3>
                    <a href="crear_rol.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nuevo Rol
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['id']) ?></td>
                                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="./editar_rol.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i> Editar
                                                </a>
                                                <a href="./eliminar_rol.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('¿Eliminar este rol?')">
                                                    <i class="bi bi-trash"></i> Eliminar
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

<?php include '../includes/footer.php'; ?>