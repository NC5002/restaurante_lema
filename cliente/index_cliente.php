<?php
include '../includes/conexion.php'; 
include '../clases/Cliente.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$cliente = new Cliente($db);
$stmt = $cliente->leer();
include '../includes/head.php'; // Include header file for Bootstrap and other styles
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 color-primario"><i class="bi bi-people"></i> Listado de Clientes</h3>
                    <a href="crear_cliente.php" class="btn btn-primario">
                        <i class="bi bi-plus-circle"></i> Nuevo Cliente
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-light">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cédula</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Teléfono</th>
                                    <th>Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['ID_CLIENTE']) ?></td>
                                        <td><?= htmlspecialchars($row['NUMERO_CEDULA']) ?></td>
                                        <td><?= htmlspecialchars($row['NOMBRE']) ?></td>
                                        <td><?= htmlspecialchars($row['APELLIDO']) ?></td>
                                        <td><?= htmlspecialchars($row['TELEFONO']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($row['FECHA_REGISTRO'])) ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="ver_cliente.php?ID_CLIENTE=<?= $row['ID_CLIENTE'] ?>" 
                                                   class="btn btn-sm btn-secundario" title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="editar_cliente.php?ID_CLIENTE=<?= $row['ID_CLIENTE'] ?>" 
                                                   class="btn btn-sm btn-primario" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>



                                                <a href="eliminar_cliente.php?ID_CLIENTE=<?= $row['ID_CLIENTE'] ?>" 
                                                   class="btn btn-sm btn-terciario" 
                                                   onclick="return confirm('¿Está seguro de eliminar este cliente?')" title="Eliminar">
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