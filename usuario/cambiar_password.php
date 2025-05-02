<?php
include '../includes/conexion.php';
include '../clases/Usuario.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$usuario = new Usuario($db);
$usuario->id = isset($_GET['id']) ? $_GET['id'] : die('ID de usuario no especificado');
$usuario->leerUno();

if($_POST){
    if($_POST['nueva_password'] !== $_POST['confirmar_password']){
        $error = "Las contraseñas no coinciden";
    } elseif(strlen($_POST['nueva_password']) < 6){
        $error = "La contraseña debe tener al menos 6 caracteres";
    } else {
        if($usuario->actualizarPassword($_POST['nueva_password'])){
            header("Location: index_usuario.php?password=1");
            exit();
        } else {
            $error = "Error al cambiar la contraseña";
        }
    }
}

include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-dark">
                    <h3 class="mb-0 color-primario"><i class="bi bi-key"></i> Cambiar Contraseña</h3>
                </div>
                <div class="card-body">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <form method="post">
                        <div class="mb-3">
                            <label for="nueva_password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="nueva_password" name="nueva_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmar_password" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" required>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primario">
                                <i class="bi bi-save"></i> Guardar Cambios
                            </button>
                            <a href="editar_usuario.php?id=<?= $usuario->id ?>" class="btn btn-secundario">
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