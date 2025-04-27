<?php
include '../conexion.php'; 
include '../Categoria.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$categoria = new Categoria($db);
$stmt = $categoria->leer();
include '../includes/head.php'; // Include header file for Bootstrap and other styles
include '../includes/header.php';
?>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h2 class="mb-0"><i class="bi bi-list-ul"></i> Listado de Categorías</h2>
                        <a href="crear_categoria.php" class="btn btn-light"><i class="bi bi-plus-circle"></i> Nueva Categoría</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
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
                                                <span class="badge bg-<?php echo $row['ESTADO'] == '1' ? 'success' : 'danger'; ?>">
                                                    <?php echo htmlspecialchars($row['ESTADO']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="editar_categoria.php?ID_CATEGORIA=<?php echo $row['ID_CATEGORIA']; ?>" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                                                <a href="eliminar_categoria.php?ID_CATEGORIA=<?php echo $row['ID_CATEGORIA']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de desactivar esta categoría?')"><i class="bi bi-trash"></i></a>
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