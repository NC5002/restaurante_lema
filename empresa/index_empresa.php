<?php
include '../includes/conexion.php'; 
include '../clases/Empresa.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$empresa = new Empresa($db);
$stmt = $empresa->leer();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

include '../includes/head.php';
include '../includes/header_configuracion.php';
?>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                <h2 class="mb-0 color-primario"><i class="bi bi-building"></i> Datos de la Empresa</h2>
                <?php if ($row): ?>
                    <a href="editar_empresa.php?id=<?php echo $row['id']; ?>" class="btn btn-primario"><i class="bi bi-pencil"></i> Editar</a>
                <?php else: ?>
                    <a href="crear_empresa.php" class="btn btn-primario"><i class="bi bi-plus-circle"></i> Crear</a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if ($row): ?>
                    <table class="table table-bordered">
                        <tr><th>Nombre</th><td><?php echo $row['nombre']; ?></td></tr>
                        <tr><th>RUC</th><td><?php echo $row['ruc']; ?></td></tr>
                        <tr><th>Dirección</th><td><?php echo $row['direccion']; ?></td></tr>
                        <tr><th>Teléfono</th><td><?php echo $row['telefono']; ?></td></tr>
                        <tr><th>Correo</th><td><?php echo $row['correo']; ?></td></tr>
                        <tr><th>Sitio Web</th><td><?php echo $row['sitio_web']; ?></td></tr>
                        <tr><th>Ciudad</th><td><?php echo $row['ciudad']; ?></td></tr>
                        <tr><th>Provincia</th><td><?php echo $row['provincia']; ?></td></tr>
                        <tr><th>País</th><td><?php echo $row['pais']; ?></td></tr>
                        <tr><th>Mensaje en Factura</th><td><?php echo $row['mensaje_factura']; ?></td></tr>
                        <tr><th>Acción</th><td>
                            <a href="editar_empresa.php?id=<?php echo $row['id']; ?>" class="btn btn-primario"><i class="bi bi-pencil"></i> Editar</a>
                            </td></tr>

                    </table>
                <?php else: ?>
                    <div class="alert alert-primary">No hay datos de empresa registrados.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php include '../includes/footer.php'; ?>
