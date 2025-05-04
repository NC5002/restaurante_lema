<?php
include '../includes/conexion.php'; 
include '../clases/Empresa.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$empresa = new Empresa($db);
$empresa->id = isset($_GET['id']) ? $_GET['id'] : die('ID no proporcionado.');
$empresa->leerUno();

if ($_POST) {
    foreach ($_POST as $key => $value) {
        if (property_exists($empresa, $key)) {
            $empresa->$key = $value;
        }
    }

    if ($empresa->actualizar()) {
        echo "<div class='alert alert-success'>Empresa actualizada correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>No se pudo actualizar la empresa.</div>";
    }
}

include '../includes/head.php'; 
include '../includes/header_configuracion.php';
?>

<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-dark">
            <h2 class="mb-0 color-primario"><i class="bi bi-pencil"></i> Editar Empresa</h2>
        </div>
        <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id={$empresa->id}"; ?>" method="post">
                <?php
                $fields = [
                    'nombre' => 'Nombre', 'ruc' => 'RUC', 'direccion' => 'Dirección',
                    'telefono' => 'Teléfono', 'correo' => 'Correo', 'sitio_web' => 'Sitio Web',
                    'logo' => 'Logo (URL o ruta)', 'ciudad' => 'Ciudad', 
                    'provincia' => 'Provincia', 'pais' => 'País',
                    'mensaje_factura' => 'Mensaje en la Factura'
                ];
                foreach ($fields as $name => $label): ?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo htmlspecialchars($empresa->$name); ?>" required>
                        <label for="<?php echo $name; ?>"><i class="bi bi-pencil-square"></i> <?php echo $label; ?></label>
                    </div>
                <?php endforeach; ?>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primario me-md-2"><i class="bi bi-save"></i> Guardar Cambios</button>
                    <a href="./index_empresa.php" class="btn btn-secundario"><i class="bi bi-arrow-left"></i> Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
