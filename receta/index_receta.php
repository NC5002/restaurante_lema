<?php
include '../includes/conexion.php';
include '../clases/Receta.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$receta = new Receta($db);
$stmt = $receta->leer();

include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 color-primario"><i class="bi bi-book"></i> Recetas</h3>
                    <a href="crear_receta.php" class="btn btn-primario">
                        <i class="bi bi-plus-circle"></i> Nueva Receta
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Menú</th>
                                    <th>Ingrediente</th>
                                    <th>Cantidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['id']) ?></td>
                                        <td><?= htmlspecialchars($row['menu_nombre']) ?></td>
                                        <td><?= htmlspecialchars($row['ingrediente_nombre']) ?></td>
                                        <td><?= htmlspecialchars($row['cantidad']) ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="editar_receta.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primario">
                                                    <i class="bi bi-pencil"></i> Editar
                                                </a>
                                                <a href="eliminar_receta.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-terciario" 
                                                   onclick="return confirm('¿Eliminar esta receta?')">
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