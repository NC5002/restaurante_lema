<?php
include '../includes/conexion.php';
include '../clases/Rol.php';

$rol = new Rol($db);
$rol->id = isset($_GET['id']) ? $_GET['id'] : die('ID de rol no especificado');
$rol->leerUno();

if($_POST){
    $rol->nombre = $_POST['nombre'];
    
    if($rol->actualizar()){
        header("Location: index_rol.php?actualizado=1");
        exit();
    } else {
        $error = "Error al actualizar el rol";
    }
}

include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h3 class="mb-0"><i class="bi bi-tag"></i> Editar Rol</h3>
                </div>
                <div class="card-body">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$rol->id ?>" method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Rol</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                   value="<?= htmlspecialchars($rol->nombre) ?>" required>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Cambios
                            </button>
                            <a href="index_rol.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>