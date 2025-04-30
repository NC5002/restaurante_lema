<?php
include '../includes/conexion.php'; 
include '../clases/Menu.php';

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
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="mb-0  color-primario"><i class="bi bi-journal-text"></i> Menú del Restaurante</h3>
                    <a href="crear_menu.php" class="btn btn-primario">
                        <i class="bi bi-plus-circle"></i> Nuevo Ítem
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-light">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Medida</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                                    $nombre_categoria = $menu->obtenerNombreCategoria($row['NUMERO_CATEGORIA']);
                                    // Cambiar $stmt por $stmt_medida
                                    try {                                                  
                                        $query = "SELECT DESCRIPCION FROM medidas WHERE ID_MEDIDA = ?";
                                        $stmt_medida = $db->prepare($query);
                                        $stmt_medida->execute([$row['MEDIDA']]);
                                        $medida = $stmt_medida->fetch(PDO::FETCH_ASSOC);                                                    
                                        $descripcion_medida = htmlspecialchars($medida['DESCRIPCION'] ?? 'Desconocido');
                                    } catch(PDOException $e) {
                                        $descripcion_medida = 'Error';
                                    }
                                ?>
                                    <tr>
                                        <td>
                                            <?php if($row['IMAGEN']): ?>
                                                <img src="../includes/img/<?= htmlspecialchars($row['IMAGEN'])?>" alt="<?= htmlspecialchars($row['NOMBRE']) ?>" class="img-fluid" width="50px">
                                            <?php else: ?>
                                                <i class="bi bi-image" style="font-size: 2rem;"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['NOMBRE']) ?></td>
                                        <td><?= htmlspecialchars($row['DESCRIPCION']) ?></td>
                                        <td><?= $descripcion_medida ?></td>
                                            </td>
                                        <td><?= htmlspecialchars($nombre_categoria) ?></td>
                                        <td>$<?= number_format($row['PRECIO'], 2) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $row['ESTADO'] == '1' ? 'success' : 'secondary' ?>">
                                                <?= $row['ESTADO'] == '1' ? 'Activo' : 'Inactivo' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="ver_menu.php?CODIGO_MENU=<?= $row['CODIGO_MENU'] ?>" 
                                                   class="btn btn-sm btn-secundario" title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="editar_menu.php?CODIGO_MENU=<?= $row['CODIGO_MENU'] ?>" 
                                                   class="btn btn-sm btn-primario" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <?php if ($row['ESTADO'] == '1'): ?>
                                                    <a href="eliminar_menu.php?CODIGO_MENU=<?= $row['CODIGO_MENU'] ?>" 
                                                       class="btn btn-sm btn-terciario" 
                                                       onclick="return confirm('¿Está seguro de desactivar este ítem?')" title="Desactivar">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="activar_menu.php?CODIGO_MENU=<?= $row['CODIGO_MENU'] ?>" 
                                                       class="btn btn-sm btn-secundario" 
                                                       onclick="return confirm('¿Está seguro de activar este ítem?')" title="Activar">
                                                        <i class="bi bi-check-square"></i>
                                                    </a>
                                                <?php endif; ?>
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