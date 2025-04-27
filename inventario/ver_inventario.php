<?php
include '../conexion.php'; 
include '../Inventario.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$inventario = new Inventario($db);

$inventario->ID_INVENTARIO = isset($_GET['ID_INVENTARIO']) ? $_GET['ID_INVENTARIO'] : die('ERROR: ID de inventario no encontrado.');
$inventario->leerUno();
include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="bi bi-box-seam"></i> Detalles del Inventario</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="bg-light" style="width: 30%"><i class="bi bi-upc-scan"></i> Código Menú:</th>
                                            <td><?= htmlspecialchars($inventario->CODIGO_MENU) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-basket"></i> Nombre del Ingrediente:</th>
                                            <td><?= htmlspecialchars($inventario->NOMBRE_INGREDIENTE) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-123"></i> Cantidad:</th>
                                            <td><?= htmlspecialchars($inventario->CANTIDAD) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-person"></i> ID Usuario:</th>
                                            <td><?= htmlspecialchars($inventario->ID_USUARIO) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-calendar"></i> Fecha Registro:</th>
                                            <td><?= date('d/m/Y', strtotime($inventario->FECHA_REGISTRO)) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="bi bi-gear"></i> Acciones</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="editar_inventario.php?ID_INVENTARIO=<?= $inventario->ID_INVENTARIO ?>" 
                                           class="btn btn-outline-primary btn-block mb-2">
                                           <i class="bi bi-pencil"></i> Editar Inventario
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">ID: <?= $inventario->ID_INVENTARIO ?></small>
                        <a href="index_inventario.php" class="btn btn-light">
                            <i class="bi bi-arrow-left"></i> Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include '../includes/footer.php'; // Include footer file for Bootstrap and other scripts
?>