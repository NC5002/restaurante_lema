<?php
include '../includes/conexion.php'; 
include '../clases/Categoria.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$categoria = new Categoria($db);
$stmt = $categoria->leer();
include '../includes/head.php'; // Include header file for Bootstrap and other styles
include '../includes/header.php';
?>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h2 class="mb-0 color-primario"><i class="bi bi-list-ul"></i> Lista de Categorías</h2>
                        <a href="crear_categoria.php" class="btn btn-primario"><i class="bi bi-plus-circle"></i> Nueva Categoría</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-light">
                                <thead>
                                    <tr>
                                        <th>ID</th> 
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['ID_CATEGORIA']); ?></td>
                                            <td><?php echo htmlspecialchars($row['NOMBRE']); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $row['ESTADO'] == '1' ? 'dark' : 'warning'; ?>">
                                                    <?php echo htmlspecialchars($row['ESTADO']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group"> 
                                                <a href="editar_categoria.php?ID_CATEGORIA=<?php echo $row['ID_CATEGORIA']; ?>" class="btn btn-sm btn-primario"><i class="bi bi-pencil"></i></a>
                                                <?php if ($row['ESTADO'] == '1'): ?>
                                                    <a href="eliminar_categoria.php?ID_CATEGORIA=<?php echo $row['ID_CATEGORIA']; ?>" class="btn btn-sm btn-terciario" onclick="return confirm('¿Estás seguro de desactivar esta categoría?')"><i class="bi bi-trash"></i></a>
                                                <?php else: ?>
                                                    <a href="activar_categoria.php?ID_CATEGORIA=<?php echo $row['ID_CATEGORIA']; ?>" class="btn btn-sm btn-secundario" onclick="return confirm('¿Estás seguro de activar esta categoría?')"><i class="bi bi-check-square"></i></a>    
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