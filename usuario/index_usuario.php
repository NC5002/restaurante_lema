<?php
include '../includes/conexion.php';
include '../clases/Usuario.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$usuario = new Usuario($db);
$stmt = $usuario->leer();

include '../includes/head.php';
include '../includes/header_configuracion.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 color-primario" ><i class="bi bi-people"></i> Gestión de Usuarios</h3>
                    <a href="crear_usuario.php" class="btn btn-primario">
                        <i class="bi bi-plus-circle"></i> Nuevo Usuario
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Cédula</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['id']) ?></td>
                                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= htmlspecialchars($row['cedula']) ?></td>
                                        <td><?= htmlspecialchars($row['rol_nombre']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $row['estado'] ? 'success' : 'danger' ?>">
                                                <?= $row['estado'] ? 'Activo' : 'Inactivo' ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($row['fecha_registro'])) ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="ver_usuario.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-secundario">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="editar_usuario.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primario">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <?php 
                                                if ($_SESSION['user_rol_nombre'] != 'Administrador') {
                                                    if($row['estado']== '1'): ?>
                                                        <a href="desactivar_usuario.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-terciario" onclick="return confirm('¿Desactivar este usuario?')">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="activar_usuario.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('¿Activar este usuario?')">
                                                            <i class="bi bi-check-square"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                <?php } ?>
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

<?php include '../includes/footer.php'; ?>