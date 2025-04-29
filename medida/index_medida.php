<?php
include '../includes/conexion.php'; 
include '../clases/Medida.php';

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
                    <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                        <h2 class="mb-0 color-primario"><i class="bi bi-list-ul"></i> Listado de Medidas</h2>
                        <a href="crear_medida.php" class="btn btn-primario"><i class="bi bi-plus-circle"></i> Nueva Medida</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-light">
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
                                                <div class="btn-group" role="group"> 
                                                    <a href="ver_medida.php?ID_MEDIDA=<?php echo $row['ID_MEDIDA']; ?>" class="btn btn-sm btn-secundario"><i class="bi bi-eye"></i></a>
                                                <a href="editar_medida.php?ID_MEDIDA=<?php echo $row['ID_MEDIDA']; ?>" class="btn btn-sm btn-primario"><i class="bi bi-pencil"></i></a>
                                                <a href="eliminar_medida.php?ID_MEDIDA=<?php echo $row['ID_MEDIDA']; ?>" class="btn btn-sm btn-terciario" onclick="return confirm('¿Estás seguro de eliminar esta medida?')"><i class="bi bi-trash"></i></a>
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