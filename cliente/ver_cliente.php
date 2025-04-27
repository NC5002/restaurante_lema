<?php
include '../conexion.php'; 
include '../Cliente.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$cliente = new Cliente($db);

$cliente->ID_CLIENTE = isset($_GET['ID_CLIENTE']) ? $_GET['ID_CLIENTE'] : die('ERROR: ID de cliente no encontrado.');
$cliente->leerUno();
include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="bi bi-person-lines-fill"></i> Detalles del Cliente</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="bg-light" style="width: 30%"><i class="bi bi-credit-card"></i> Cédula:</th>
                                            <td><?= htmlspecialchars($cliente->NUMERO_CEDULA) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-person"></i> Nombre:</th>
                                            <td><?= htmlspecialchars($cliente->NOMBRE) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-person"></i> Apellido:</th>
                                            <td><?= htmlspecialchars($cliente->APELLIDO) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-telephone"></i> Teléfono:</th>
                                            <td><?= htmlspecialchars($cliente->TELEFONO) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-envelope"></i> Correo:</th>
                                            <td><?= htmlspecialchars($cliente->CORREO) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-house"></i> Dirección:</th>
                                            <td><?= htmlspecialchars($cliente->DIRECCION) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-calendar"></i> Fecha Registro:</th>
                                            <td><?= date('d/m/Y', strtotime($cliente->FECHA_REGISTRO)) ?></td>
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
                                        <a href="editar_cliente.php?ID_CLIENTE=<?= $cliente->ID_CLIENTE ?>" 
                                           class="btn btn-outline-primary btn-block mb-2">
                                           <i class="bi bi-pencil"></i> Editar Cliente
                                        </a>
                                        <!--a href="eliminar_cliente.php?ID_CLIENTE=<?= $cliente->ID_CLIENTE ?>" 
                                           class="btn btn-outline-danger btn-block mb-2"
                                           onclick="return confirm('¿Está seguro de eliminar este cliente?')">
                                           <i class="bi bi-trash"></i> Eliminar Cliente
                                        </a-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">ID: <?= $cliente->ID_CLIENTE ?></small>
                        <a href="index_cliente.php" class="btn btn-light">
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