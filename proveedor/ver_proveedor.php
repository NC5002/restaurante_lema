<?php
include '../includes/conexion.php'; 
include '../clases/Proveedor.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$proveedor = new Proveedor($db);

$proveedor->ID_PROVEEDOR = isset($_GET['ID_PROVEEDOR']) ? $_GET['ID_PROVEEDOR'] : die('ERROR: ID de proveedor no encontrado.');
$proveedor->leerUno();
include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 color-primario"><i class="bi bi-truck"></i> Detalles del Proveedor</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="bg-light" style="width: 30%"><i class="bi bi-credit-card"></i> RUC/Cédula:</th>
                                            <td><?= htmlspecialchars($proveedor->RUC_CEDULA) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-person"></i> Nombre:</th>
                                            <td><?= htmlspecialchars($proveedor->NOMBRE) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-house"></i> Dirección:</th>
                                            <td><?= htmlspecialchars($proveedor->DIRECCION) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-telephone"></i> Teléfono:</th>
                                            <td><?= htmlspecialchars($proveedor->TELEFONO) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-envelope"></i> Correo:</th>
                                            <td><?= htmlspecialchars($proveedor->CORREO) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-chat-left-text"></i> Observaciones:</th>
                                            <td><?= htmlspecialchars($proveedor->OBSERVACIONES) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light"><i class="bi bi-calendar"></i> Fecha Registro:</th>
                                            <td><?= date('d/m/Y', strtotime($proveedor->FECHA_REGISTRO)) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">ID: <?= $proveedor->ID_PROVEEDOR ?></small>
                              <a href="./index_proveedor.php" class="btn btn-primario">
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