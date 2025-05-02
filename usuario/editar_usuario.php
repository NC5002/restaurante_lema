<?php
include '../includes/conexion.php';
include '../clases/Usuario.php';
include '../clases/Rol.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$usuario = new Usuario($db);
$rol = new Rol($db);
$roles = $rol->leer();

$usuario->id = isset($_GET['id']) ? $_GET['id'] : die('ID de usuario no especificado');
$usuario->leerUno();

if($_POST){
    $usuario->nombre = $_POST['nombre'];
    $usuario->email = $_POST['email'];
    $usuario->cedula = $_POST['cedula'];
    $usuario->rol_id = $_POST['rol_id'];
    $usuario->perfil = $_POST['perfil'] ?? 0;
    
    if($usuario->actualizar()){
        header("Location: index_usuario.php?actualizado=1");
        exit();
    } else {
        $error = "Error al actualizar el usuario";
    }
}

include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-dark">
                    <h3 class="mb-0 color-primario"><i class="bi bi-person-lines-fill"></i> Editar Usuario</h3>
                </div>
                <div class="card-body">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$usuario->id ?>" method="post">
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="<?= htmlspecialchars($usuario->nombre) ?>" required>
                                <label for="nombre">Nombre Completo</label>
                            </div>
                            
                            <div class="col-md-6 form-floating">
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= htmlspecialchars($usuario->email) ?>" required>
                                <label for="email">Email</label>
                            </div>
                            
                            <div class="col-md-6 form-floating">
                                <input type="text" class="form-control" id="cedula" name="cedula" 
                                       value="<?= htmlspecialchars($usuario->cedula) ?>" required>
                                <label for="cedula">Cédula</label>
                            </div>
                            
                            <div class="col-md-6 form-floating">
                                <select class="form-select" id="rol_id" name="rol_id" required>
                                    <?php foreach($roles as $rol): ?>
                                        <option value="<?= $rol['id'] ?>" 
                                            <?= ($rol['id'] == $usuario->rol_id) ? 'selected' : '' ?>>
                                            <?= $rol['nombre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="rol_id">Rol</label>
                            </div>
                            
                            <div class="col-12 form-check">
                                <input class="form-check-input" type="checkbox" id="perfil" name="perfil" value="1"
                                    <?= $usuario->perfil ? 'checked' : '' ?>>
                                <label class="form-check-label" for="perfil">Perfil completo</label>
                            </div>
                            
                            <div class="col-12 gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primario">
                                    <i class="bi bi-save"></i> Guardar Cambios
                                </button>

                                <a href="cambiar_password.php?id=<?= $usuario->id ?>" class="btn btn-terciario">
                                    <i class="bi bi-key"></i> Cambiar Contraseña
                                </a>
                                <a href="index_usuario.php" class="btn btn-secundario">
                                    <i class="bi bi-arrow-left"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>