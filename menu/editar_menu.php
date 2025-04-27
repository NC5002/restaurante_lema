<?php
include '../conexion.php'; 
include '../Menu.php';

$database = new Conexion();
$db = $database->obtenerConexion();

$menu = new Menu($db);
$menu->CODIGO_MENU = isset($_GET['CODIGO_MENU']) ? $_GET['CODIGO_MENU'] : die('ERROR: ID no encontrado.');
$menu->leerUno();

$categorias = $menu->leerCategorias();

if($_POST){
    $menu->NOMBRE = $_POST['NOMBRE'];
    $menu->DESCRIPCION = $_POST['DESCRIPCION'];
    $menu->PRECIO = $_POST['PRECIO'];
    $menu->NUMERO_CATEGORIA = $_POST['NUMERO_CATEGORIA'];
    $menu->ESTADO = $_POST['ESTADO'];
    
    if(!empty($_FILES['IMAGEN']['name'])) {
        $menu->IMAGEN = $_FILES['IMAGEN']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["IMAGEN"]["name"]);
        move_uploaded_file($_FILES["IMAGEN"]["tmp_name"], $target_file);
    }
    
    if($menu->actualizar()){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> Ítem de menú actualizado exitosamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    } else{
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> No se pudo actualizar el ítem de menú.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }
}
include '../includes/head.php'; 
include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-journal-text"></i> Editar Ítem de Menú</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?CODIGO_MENU={$menu->CODIGO_MENU}"); ?>" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="NOMBRE" class="form-label"><i class="bi bi-card-heading"></i> Nombre</label>
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" value="<?= htmlspecialchars($menu->NOMBRE) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="NUMERO_CATEGORIA" class="form-label"><i class="bi bi-bookmark"></i> Categoría</label>
                                <select class="form-select" id="NUMERO_CATEGORIA" name="NUMERO_CATEGORIA" required>
                                    <option value="">Seleccione una categoría</option>
                                    <?php while ($categoria = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?= $categoria['NUMERO_CATEGORIA'] ?>" <?= ($categoria['NUMERO_CATEGORIA'] == $menu->NUMERO_CATEGORIA) ? 'selected' : '' ?>>
                                            <?= $categoria['NOMBRE'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="DESCRIPCION" class="form-label"><i class="bi bi-text-paragraph"></i> Descripción</label>
                                <textarea class="form-control" id="DESCRIPCION" name="DESCRIPCION" rows="3"><?= htmlspecialchars($menu->DESCRIPCION) ?></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="PRECIO" class="form-label"><i class="bi bi-currency-dollar"></i> Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="PRECIO" name="PRECIO" value="<?= htmlspecialchars($menu->PRECIO) ?>" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="ESTADO" class="form-label"><i class="bi bi-toggle-on"></i> Estado</label>
                                <select class="form-select" id="ESTADO" name="ESTADO" required>
                                    <option value="ACTIVO" <?= ($menu->ESTADO == 'ACTIVO') ? 'selected' : '' ?>>Activo</option>
                                    <option value="INACTIVO" <?= ($menu->ESTADO == 'INACTIVO') ? 'selected' : '' ?>>Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="IMAGEN" class="form-label"><i class="bi bi-image"></i> Imagen Actual</label>
                                <?php if($menu->IMAGEN): ?>
                                    <img src="uploads/<?= htmlspecialchars($menu->IMAGEN) ?>" class="img-thumbnail mb-2" style="max-height: 100px;">
                                <?php else: ?>
                                    <p class="text-muted">No hay imagen</p>
                                <?php endif; ?>
                                <input class="form-control" type="file" id="IMAGEN" name="IMAGEN" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-calendar"></i> Fecha de Registro</label>
                                <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($menu->FECHA_REGISTRO)) ?>" readonly>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary me-md-2">
                                        <i class="bi bi-save"></i> Guardar Cambios
                                    </button>
                                    <a href="index_menu.php" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include '../includes/footer.php'; // Include footer file for Bootstrap and other scripts
?>