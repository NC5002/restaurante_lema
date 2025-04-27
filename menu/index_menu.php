<?php
include '../conexion.php'; 
include '../Menu.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$menu = new Menu($db);
$stmt = $menu->leer();
include '../includes/head.php'; // Include header file for Bootstrap and other styles
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="bi bi-journal-text"></i> Menú del Restaurante</h3>
                    <a href="crear_menu.php" class="btn btn-light">
                        <i class="bi bi-plus-circle"></i> Nuevo Ítem
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                                    $nombre_categoria = $menu->obtenerNombreCategoria($row['NUMERO_CATEGORIA']);
                                ?>
                                    <tr>
                                        <td>
                                            <?php if($row['IMAGEN']): ?>
                                                <img src="uploads/<?= htmlspecialchars($row['IMAGEN']) ?>" alt="<?= htmlspecialchars($row['NOMBRE']) ?>" style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php else: ?>
                                                <i class="bi bi-image" style="font-size: 2rem;"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['NOMBRE']) ?></td>
                                        <td><?= htmlspecialchars($row['DESCRIPCION']) ?></td>
                                        <td><?= htmlspecialchars($nombre_categoria) ?></td>
                                        <td>$<?= number_format($row['PRECIO'], 2) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $row['ESTADO'] == '1' ? 'success' : 'danger' ?>">
                                                <?= htmlspecialchars($row['ESTADO']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="editar_menu.php?CODIGO_MENU=<?= $row['CODIGO_MENU'] ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="eliminar_menu.php?CODIGO_MENU=<?= $row['CODIGO_MENU'] ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   onclick="return confirm('¿Está seguro de desactivar este ítem?')" title="Desactivar">
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