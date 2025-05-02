<?php
include '../includes/conexion.php';
include '../clases/Usuario.php';
include '../clases/Rol.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$usuario = new Usuario($db);
$rol = new Rol($db); // Asume que tienes una clase Rol
$roles = $rol->leer(); // Método para obtener todos los roles

if($_POST){
    $usuario->nombre = $_POST['nombre'];
    $usuario->email = $_POST['email'];
    $usuario->cedula = $_POST['cedula'];
    $usuario->password = $_POST['password'];
    $usuario->rol_id = $_POST['rol_id'];
    $usuario->perfil = $_POST['perfil'] ?? 0;
    
    // Validaciones
    if($usuario->emailExiste()){
        $error = "El email ya está registrado";
    } elseif($usuario->cedulaExiste()){
        $error = "La cédula ya está registrada";
    } elseif(strlen($_POST['password']) < 6){
        $error = "La contraseña debe tener al menos 6 caracteres";
    } else {
        if($usuario->crear()){
            header("Location: index_usuario.php?creado=1");
            exit();
        } else {
            $error = "Error al crear el usuario";
        }
    }
}

include '../includes/head.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-dark ">
                    <h3 class="mb-0 color-primario"><i class="bi bi-person-plus"></i> Nuevo Usuario</h3>
                </div>
                <div class="card-body">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                        <div class="row g-3">
                            <div class="col-md-6 form-floating">
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                <label for="nombre">Nombre Completo</label>
                            </div>
                            
                            <div class="col-md-6 form-floating">
                                <input type="email" class="form-control" id="email" name="email" required>
                                <label for="email">Email</label>
                            </div>
                            
                            <div class="col-md-6 form-floating">
                                <input type="text" class="form-control" id="cedula" name="cedula" required>
                                <label for="cedula">Cédula</label>
                            </div>
                            
                            <div class="col-md-6 form-floating">
                                <select class="form-select" id="rol_id" name="rol_id" required>
                                    <option value="">Seleccione un rol</option>
                                    <?php foreach($roles as $rol): ?>
                                        <option value="<?= $rol['id'] ?>"><?= $rol['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="rol_id">Rol</label>
                            </div>
                            
                            <div class="col-md-6 form-floating">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <label for="password">Contraseña</label>
                            </div>
                            
                            <div class="col-md-6 form-floating">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                <label for="confirm_password">Confirmar Contraseña</label>
                            </div>
                            
                            <div class="col-12 form-check">
                                <input class="form-check-input" type="checkbox" id="perfil" name="perfil" value="1">
                                <label class="form-check-label" for="perfil">Perfil completo (acceso a todas las funciones)</label>
                            </div>
                            
                            <div class="col-12 d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primario">
                                    <i class="bi bi-save"></i> Guardar Usuario
                                </button>
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

<script>
// Validación de contraseñas coincidentes
document.querySelector('form').addEventListener('submit', function(e) {
    const pass = document.getElementById('password');
    const confirmPass = document.getElementById('confirm_password');
    
    if(pass.value !== confirmPass.value) {
        e.preventDefault();
        alert('Las contraseñas no coinciden');
    }
});
</script>

<?php include '../includes/footer.php'; ?>