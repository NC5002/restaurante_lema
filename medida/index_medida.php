<?php
include '../conexion.php'; 
include '../Medida.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$medida = new Medida($db);
$stmt = $medida->leer();
include '../includes/head.php'; // Include header file for Bootstrap and other styles
include '../includes/header.php';
?>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h2 class="mb-0"><i class="bi bi-list-ul"></i> Listado de Medidas</h2>
                        <a href="crear_medida.php" class="btn btn-light"><i class="bi bi-plus-circle"></i> Nueva Medida</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['ID_MEDIDA']); ?></td>
                                            <td><?php echo htmlspecialchars($row['DESCRIPCION']); ?></td>
                                            <td>
                                                <a href="editar_medida.php?ID_MEDIDA=<?php echo $row['ID_MEDIDA']; ?>" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                                                <a href="eliminar_medida.php?ID_MEDIDA=<?php echo $row['ID_MEDIDA']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta medida?')"><i class="bi bi-trash"></i></a>
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